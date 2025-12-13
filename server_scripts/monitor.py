import psutil
import json
import platform

def get_system_stats():
    stats = {
        "os": platform.system(),
        "cpu_percent": psutil.cpu_percent(interval=1),
        "memory_percent": psutil.virtual_memory().percent,
        "disk_percent": psutil.disk_usage('/').percent,
        "boot_time": psutil.boot_time()
    }
    return stats

if __name__ == "__main__":
    print(json.dumps(get_system_stats()))
