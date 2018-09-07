<?php
$servername = "192.168.1.100";
$username = "traffic_user";
$password = "pass";
$dbname = "flow";
$conn = new mysqli($servername, $username, $password, $dbname);
echo "

<style type='text/css'>
.tg  {border-collapse:collapse;border-spacing:0;border-color:#aabcfe; margin-left: auto; margin-right: auto}
.tg td{font-family:Arial, sans-serif;font-size:18px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#669;background-color:#e8edff;}
.tg th{font-family:Arial, sans-serif;font-size:18px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#039;background-color:#b9c9fe;}
.tg .tg-hmp3{background-color:#D2E4FC;text-align:left;vertical-align:top}
.tg .tg-baqh{text-align:center;vertical-align:top}
.tg .tg-mb3i{background-color:#D2E4FC;text-align:right;vertical-align:top}
.tg .tg-lqy6{text-align:right;vertical-align:top}
.tg .tg-0lax{text-align:left;vertical-align:top}


</style>
<form action='flow.php' method='POST'>
<input name='ipAddr' type='text'  />
<input name='submit' type='submit' />
</form>

<table class='tg'>
<tr>
<th class='tg-0lax'>Source IP</th>
<th class='tg-0lax'>DNS-name</th>
<th class='tg-0lax'>Bytes</th>
</tr>
";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT idx as id, INET_NTOA(IP_SRC_ADDR) as ip_addr, IN_BYTES as inBytes, dns FROM flowsv4 where dns <> 'NULL' AND INET_NTOA(IP_SRC_ADDR)='".$_POST['ipAddr']."' group by dns order by dns limit 100 ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr><th class='tg-0lax'> ".$row["ip_addr"]."</th>  <th class='tg-0lax'>".$row["dns"]."</th>  <th class='tg-0lax'>" . $row["inBytes"]."</th> </tr>";
    }
} else {
    echo "0 results";
}

echo "</table>";

$conn->close();
?>