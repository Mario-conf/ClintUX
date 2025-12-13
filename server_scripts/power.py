import sys
import json
import os
import platform

def system_power(action):
    try:
        if action not in ['shutdown', 'reboot']:
            return {"error": "Invalid action"}

        # Detect OS
        is_windows = platform.system() == "Windows"
        
        if action == 'shutdown':
            cmd = "shutdown /s /t 0" if is_windows else "shutdown -h now"
        elif action == 'reboot':
            cmd = "shutdown /r /t 0" if is_windows else "reboot"
        
        # In a real environment, the user running this script needs sudo permissions without password 
        # or be an Administrator.
        # Since this is a dashboard running typically as a service/user, this might fail without config.
        # ALLOWING THIS TO RUN FOR DEMO PURPOSES via os.system (Dangerous in prod without auth!)
        
        # Uncomment to actually run:
        # os.system(cmd)
        
        return {"success": True, "message": f"System execution: {cmd} (Simulated)"}

    except Exception as e:
        return {"error": str(e)}

if __name__ == "__main__":
    if len(sys.argv) > 1:
        print(json.dumps(system_power(sys.argv[1])))
    else:
        print(json.dumps({"error": "No action specified"}))
