<?php
header('Content-Type: application/json');

$servername = "mysql80.r3.websupport.hu";
$username = "if0_38165555"; 
$password = "manoka877"; 
$dbname = "demoncars_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die(json_encode(["error" => "Kapcsolati hiba: " . $conn->connect_error]));
}

$sql = "SELECT id, username, email FROM users"; 
$result = $conn->query($sql);

if (!$result) {
    die(json_encode(["error" => "SQL hiba: " . $conn->error]));
}

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

$json_data = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
if ($json_data === false) {
    die(json_encode(["error" => "JSON hiba: " . json_last_error_msg()])); 
}

echo $json_data;

$conn->close();
?>
