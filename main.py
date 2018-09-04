import socket
import os

tempFile='/tmp/ipList'

def getHost(ip):
    try:
        data = socket.gethostbyaddr(ip)
        host = repr(data[0])
        print(host)
        return host
    except Exception:
        return False

def remFile(tmpfile):
    if os.path.exists(tmpfile):
        os.remove(tmpfile)
    else:
        print("The file does not exist")

with open(tempFile,"r") as tf:
    line = "".join(tf.readlines()).split("\n")
    print(line)
