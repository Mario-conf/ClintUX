import psutil
import json
import platform

def get_system_stats():

    boot_time = psutil.boot_time()
    
    # Network
    net_io = psutil.net_io_counters()
    
    # Top Processes
    processes = []
    for proc in psutil.process_iter(['pid', 'name', 'cpu_percent', 'memory_percent']):
        try:
            # Filter out low usage to speed up
            if proc.info['cpu_percent'] > 0 or proc.info['memory_percent'] > 1:
                processes.append(proc.info)
        except (psutil.NoSuchProcess, psutil.AccessDenied, psutil.ZombieProcess):
            pass
    
    # Sort by CPU and take top 5
    top_processes = sorted(processes, key=lambda p: p['cpu_percent'], reverse=True)[:5]

    # IPs
    local_ip = "Unknown"
    public_ip = "Unknown"
    
    try:
        # Get local IP
        for interface, addrs in psutil.net_if_addrs().items():
            for addr in addrs:
                if addr.family == 2 and not addr.address.startswith("127."):
                    local_ip = addr.address
                    break
            if local_ip != "Unknown": break
    except:
        pass

    try:
        # Get public IP (timeout 1s to avoid hang)
        import urllib.request
        public_ip = urllib.request.urlopen('https://api.ipify.org', timeout=1).read().decode('utf8')
    except:
        pass

    stats = {
        "os": platform.system(),
        "cpu_percent": psutil.cpu_percent(interval=1),
        "memory_percent": psutil.virtual_memory().percent,
        "disk_percent": psutil.disk_usage('/').percent,
        "boot_time": boot_time,
        "net_sent": net_io.bytes_sent,
        "net_recv": net_io.bytes_recv,
        "processes": top_processes,
        "local_ip": local_ip,
        "public_ip": public_ip
    }
    return stats

if __name__ == "__main__":
    print(json.dumps(get_system_stats()))
