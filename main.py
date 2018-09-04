# NtopNG Simple netflowLog Viewer
# by ep4sh
# simple utility, that connect to mysql RDMS (https://www.ntop.org/guides/ntopng/advanced_features/flows_dump.html#mysql)
# and gather ip-addr for L7 protocols: HTTP(code 7) and HTTPS (code 178)
# and resolve them into DNS names
#
# Please, dont forget change your creds!
import socket
import mysql.connector

# MySQL creds
mysql_user='traffic_user'
mysql_password='pass'
mysql_database='flow'
mysql_host='192.168.1.178'

# задаём ip, который хотим мониторить
IP_SRC = '192.168.1.43'
IP_LIST = []

def mysql_conn(user=mysql_user,password=mysql_password,db=mysql_database,host=mysql_host, ip_src=IP_SRC, ip_list=IP_LIST):
    cnx = mysql.connector.connect(user=user, password=password, database=db, host=host)
    cursor = cnx.cursor()

    query = ("SELECT INET_NTOA(IP_DST_ADDR) as ip_dest, IN_BYTES as inBytes from flowsv4 where INET_NTOA(IP_SRC_ADDR)='"+ip_src+"' AND (L4_DST_PORT='443' or L4_DST_PORT='80') group by ip_dest;")
    cursor.execute(query)

# Получаем данные.
    for x in cursor.fetchall():
        ip_list.append(x)
    cnx.close()


## функция резолв хоста
def getHost(ip):
    try:
        data = socket.gethostbyaddr(ip)
        host = repr(data[0])
        print(host)
        return host
    except Exception:
        return False

#****************************************************************************
#****************************************************************************

# подключение к базе
mysql_conn()


# резолв хостов
for (ip, bytes_in) in IP_LIST:
    if bytes_in > 1000:
        if not (ip.startswith("192.168.")):
           getHost(ip)
