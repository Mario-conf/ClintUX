import docker
import json
import sys

def get_containers():
    try:
        client = docker.from_env()
        containers = client.containers.list(all=True)
        result = []
        for c in containers:
            result.append({
                "id": c.short_id,
                "name": c.name,
                "status": c.status,
                "image": c.image.tags[0] if c.image.tags else "unknown"
            })
        return result
    except Exception as e:
        return {"error": str(e)}

def manage_container(action, container_id):
    try:
        client = docker.from_env()
        container = client.containers.get(container_id)
        if action == 'start':
            container.start()
        elif action == 'stop':
            container.stop()
        elif action == 'restart':
            container.restart()
        else:
            return {"error": "Invalid action"}
        return {"success": True, "message": f"Container {container.name} {action}ed"}
    except Exception as e:
        return {"error": str(e)}

def create_container(image, name, ports):
    try:
        client = docker.from_env()
        
        # Parse ports: "8080:80" -> {'80/tcp': 8080}
        port_bindings = {}
        if ports:
            parts = ports.split(':')
            if len(parts) == 2:
                port_bindings[f'{parts[1]}/tcp'] = int(parts[0])
        
        container = client.containers.run(
            image,
            name=name if name else None,
            ports=port_bindings,
            detach=True
        )
        return {"success": True, "message": f"Container created: {container.name} ({container.id[:10]})"}
    except Exception as e:
        return {"error": str(e)}

if __name__ == "__main__":
    if len(sys.argv) > 1:
        if sys.argv[1] == 'list':
            print(json.dumps(get_containers()))
        elif sys.argv[1] == 'create':
            # create <image> <name> <ports>
            image = sys.argv[2] if len(sys.argv) > 2 else None
            name = sys.argv[3] if len(sys.argv) > 3 and sys.argv[3] != "_" else None
            ports = sys.argv[4] if len(sys.argv) > 4 and sys.argv[4] != "_" else None
            print(json.dumps(create_container(image, name, ports)))
        else:
            action = sys.argv[1]
            container_id = sys.argv[2] if len(sys.argv) > 2 else None
            print(json.dumps(manage_container(action, container_id)))
    else:
        print(json.dumps({"error": "No action specified"}))
```
