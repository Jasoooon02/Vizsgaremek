<?php
$servername = "sql302.infinityfree.com";
$username = "if0_38165555";
$password = "manoka877";
$dbname = "if0_38165555_demoncars_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kapcsolati hiba: " . $conn->connect_error);
}


$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

header('Content-Type: application/json');
echo json_encode($orders);

$conn->close();
?>
