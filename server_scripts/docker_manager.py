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

if __name__ == "__main__":
    if len(sys.argv) > 2:
        # Action mode: python docker_manager.py start <id>
        action = sys.argv[1]
        container_id = sys.argv[2]
        print(json.dumps(manage_container(action, container_id)))
    else:
        # List mode
        print(json.dumps(get_containers()))
