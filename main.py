import socket
import os

tempFile='/tmp/ipList'

def getHost(ip):
    try:
        data = socket.gethostbyaddr(ip)
        host = repr(data[0])
        return host
        print(host)
    except Exception:
        # fail gracefully
        return False

def remFile(tmpfile):
    if os.path.exists(tmpfile):
        os.remove(tmpfile)
    else:
        print("The file does not exist")

with open(tempFile,"r") as tf:
    print(tf.readlines())