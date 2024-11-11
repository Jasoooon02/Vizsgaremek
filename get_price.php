<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cars";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Csatlakozási hiba: " . $conn->connect_error);
}

$name = $_GET['name'];
$engine = $_GET['engine'];

$sql = "SELECT price FROM cars WHERE name = ? AND engine = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $engine);
$stmt->execute();
$stmt->bind_result($price);
$stmt->fetch();
$stmt->close();
$conn->close();

echo $price;
?>
