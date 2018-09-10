<?php
$servername = "192.168.1.100";
$username = "traffic_user";
$password = "pass";
$dbname = "flow";
$conn = new mysqli($servername, $username, $password, $dbname);
echo '
<!DOCTYPE html>
<html>
 <head>
   <title>NSLV</title>
   <meta charset='utf-8'>
   <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css'>
   <script type='text/javascript' charset='utf8' src='https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js'></script>
 </head>
 <body>

            $(document).ready( function () {

                $('#table_id').DataTable();

            } );



 </body>
</html>







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