<?php
$servername = "192.168.1.178";
$username = "traffic_user";
$password = "pass";
$dbname = "flow";
$conn = new mysqli($servername, $username, $password, $dbname);
$a= array();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT INET_NTOA(IP_SRC_ADDR) as ip_addr, dns, IN_BYTES as inBytes FROM flowsv4 where dns <> 'NULL'  group by dns order by dns limit 5000 ";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $a['data'][] = $row;
    }
   }
else {
    echo "0 results";
}

    echo (json_encode($a));


$conn->close();
?>