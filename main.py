# NtopNG Simple netflowLog Viewer
# by ep4sh
# simple utility, that connect to mysql RDMS (https://www.ntop.org/guides/ntopng/advanced_features/flows_dump.html#mysql)
# and gather ip-addr for L7 protocols: HTTP(code 7) and HTTPS (code 178)
# and resolve them into DNS names
#
# Please, dont forget change your creds!
#
#
#
import socket
import mysql.connector
import sys

# MySQL creds
mysql_user='traffic_user'
mysql_password='pass'
mysql_database='flow'
mysql_host='192.168.1.178'
IP_SRC = ''
# задаём ip, который хотим мониторить
try:
    if len(sys.argv) == 2:
        IP_SRC = sys.argv[1]
    else:
        IP_SRC = '192.168.1.41'
except:
    pass

def mysql_conn(user=mysql_user,password=mysql_password,db=mysql_database,host=mysql_host, ip_src=IP_SRC):
    cnx = mysql.connector.connect(user=user, password=password, database=db, host=host)
    cursor = cnx.cursor()
    query = ("SELECT idx, INET_NTOA(IP_DST_ADDR) as ip_dest from flowsv4 where INET_NTOA(IP_SRC_ADDR)='"+ip_src+"' AND (L4_DST_PORT='443' or L4_DST_PORT='80') AND IN_BYTES > 1000 group by ip_dest;")
    cursor.execute(query)
# Получаем данные.

    for x in cursor.fetchall():
        id = x[0]
        dnsName = getHost(x[1])
        if dnsName is not None:
            insert_stmt = (
                "UPDATE flowsv4 SET  "
                "dns=(%s) where idx=%s ;"
            )
            data = (dnsName,id)
            cursor.execute(insert_stmt, data)
            print(data)
    cnx.commit()
    cnx.close()


## функция резолв хоста
def getHost(ip):
    try:
        data = socket.gethostbyaddr(ip)
        host = repr(data[0])
        root = "".join(host.split(".")[-1]).replace('\'','')
        tld = "".join(host.split(".")[-2]).replace('\'','')
        full = tld + "." + root
        return full
    except Exception:
        pass


#****************************************************************************
#****************************************************************************


# подключение к базе
mysql_conn()
