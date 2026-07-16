import subprocess
import time
import requests
import re
import os

WEB_URL = "http://ez.mn/tmpl/feeds/feed/rob/api.php"
FILE_DIR = "/storage/emulated/0/Delta/Autoexecute"

cached_packages = []
cached_usernames = {}
last_status = {
    "installed": [],
    "running": {},
    "username": {}
}

def clear_screen():
    os.system('clear')

def run_root(cmd):
    try:
        res = subprocess.run(f"su -c '{cmd}'", shell=True, capture_output=True, text=True, stdin=subprocess.DEVNULL)
        return res.stdout.strip()
    except:
        return ""

def get_all_packages():
    global cached_packages
    if not cached_packages:
        out = run_root("pm list packages | grep 'com.roblox'")
        if out:
            cached_packages = [line.replace("package:", "").strip() for line in out.splitlines() if line.strip()]
    return cached_packages

def get_running_packages():
    out = run_root("ps -A | grep com.roblox")
    running = []
    for line in out.splitlines():
        parts = line.split()
        if parts and 'com.roblox' in parts[-1]:
            running.append(parts[-1])
    return running

def force_stop(pkg):
    run_root(f"am force-stop {pkg}")

def start_game(pkg, mode, target):
    if mode == "private":
        uri = f"https://www.roblox.com/share?code={target}&type=Server" if "http" not in target else target
    else:
        uri = f"roblox://placeId={target}"
    run_root(f'am start -a android.intent.action.VIEW -d "{uri}" {pkg}')

def get_username(pkg):
    if pkg in cached_usernames and cached_usernames[pkg] != "Unknown":
        return cached_usernames[pkg]
    
    out = run_root(f"cat /data/data/{pkg}/shared_prefs/prefs.xml 2>/dev/null | grep username")
    match = re.search(r'<string name="username">([^<]+)</string>', out)
    username = match.group(1) if match else "Unknown"
    
    if username != "Unknown":
        cached_usernames[pkg] = username
    return username

def sanitize_filename(filename):
    return os.path.basename(filename)

def list_files():
    try:
        if not os.path.exists(FILE_DIR):
            return {"success": True, "data": []}
        files = []
        for item in os.listdir(FILE_DIR):
            path = os.path.join(FILE_DIR, item)
            if os.path.isfile(path):
                stat = os.stat(path)
                files.append({
                    "name": item,
                    "size": stat.st_size,
                    "mtime": stat.st_mtime
                })
        return {"success": True, "data": files}
    except Exception as e:
        return {"success": False, "message": str(e)}

def add_file(filename, content):
    try:
        filename = sanitize_filename(filename)
        if not os.path.exists(FILE_DIR):
            os.makedirs(FILE_DIR, exist_ok=True)
        path = os.path.join(FILE_DIR, filename)
        with open(path, 'w', encoding='utf-8') as f:
            f.write(content)
        return {"success": True, "message": f"File {filename} created"}
    except Exception as e:
        return {"success": False, "message": str(e)}

def edit_file(filename, content):
    return add_file(filename, content)

def delete_file(filename):
    try:
        filename = sanitize_filename(filename)
        path = os.path.join(FILE_DIR, filename)
        if os.path.exists(path):
            os.remove(path)
            return {"success": True, "message": f"File {filename} deleted"}
        else:
            return {"success": False, "message": "File not found"}
    except Exception as e:
        return {"success": False, "message": str(e)}

def send_file_result(operation, success, data=None, message=""):
    try:
        requests.post(f"{WEB_URL}?action=file_result", json={
            "operation": operation,
            "success": success,
            "data": data or [],
            "message": message
        }, timeout=10)
    except Exception:
        pass

def sync_status():
    installed = get_all_packages()
    running_pkgs = get_running_packages()
    
    accounts_status = {}
    running_status = {}
    username_status = {}
    
    for pkg in installed:
        running = pkg in running_pkgs
        username = get_username(pkg)
        accounts_status[pkg] = {"running": running, "username": username}
        running_status[pkg] = running
        username_status[pkg] = username

    last_status["installed"] = installed
    last_status["running"] = running_status
    last_status["username"] = username_status

    payload = {"installed": installed, "accounts": accounts_status}
    try:
        requests.post(f"{WEB_URL}?action=sync", json=payload, timeout=5)
        return True
    except:
        return False

def get_pending_commands():
    try:
        res = requests.get(f"{WEB_URL}?action=get_commands", timeout=5)
        data = res.json()
        return data if isinstance(data, dict) else {}
    except:
        return {}

def ack_execution(pkg):
    try:
        requests.get(f"{WEB_URL}?action=ack_execution&pkg={pkg}", timeout=3)
    except:
        pass

def main():
    clear_screen()
    print("READY, Waiting Commands...")
    sync_status()

    while True:
        try:
            sync_status()
            commands = get_pending_commands()
            
            if isinstance(commands, dict) and commands:
                for pkg, cmd_info in commands.items():
                    cmd = cmd_info.get("cmd", "IDLE")
                    mode = cmd_info.get("mode", "public")
                    target = cmd_info.get("target", "")
                    content = cmd_info.get("content", "")

                    if pkg == '_file_manager':
                        if cmd == "FILE_LIST":
                            result = list_files()
                            send_file_result("FILE_LIST", result["success"], result.get("data", []), result.get("message", ""))
                        elif cmd == "FILE_ADD":
                            result = add_file(target, content)
                            send_file_result("FILE_ADD", result["success"], [], result.get("message", ""))
                        elif cmd == "FILE_EDIT":
                            result = edit_file(target, content)
                            send_file_result("FILE_EDIT", result["success"], [], result.get("message", ""))
                        elif cmd == "FILE_DELETE":
                            result = delete_file(target)
                            send_file_result("FILE_DELETE", result["success"], [], result.get("message", ""))
                        
                        ack_execution(pkg)
                        continue

                    if cmd == "START":
                        if not last_status["running"].get(pkg, False):
                            start_game(pkg, mode, target)
                        ack_execution(pkg)
                    elif cmd == "STOP":
                        if last_status["running"].get(pkg, False):
                            force_stop(pkg)
                        ack_execution(pkg)
                    elif cmd == "RERUN":
                        force_stop(pkg)
                        time.sleep(1.5)
                        start_game(pkg, mode, target)
                        ack_execution(pkg)
                    elif cmd == "IDLE":
                        ack_execution(pkg)
                        
            time.sleep(8) 
            
        except KeyboardInterrupt:
            break
        except Exception:
            time.sleep(8)

if __name__ == "__main__":
    main()
