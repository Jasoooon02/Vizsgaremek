<?php
session_start();

$servername = "mysql80.r3.websupport.hu";
$username = "if0_38165555";
$password = "manoka877";
$dbname = "demoncars_db"; 

header('Access-Control-Allow-Origin: www.demoncars.online');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Adatbázis kapcsolódási hiba']));
}


if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $felhasznalonev = $_SESSION['username'];


    $query = "SELECT is_admin FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $felhasznalonev);
    $stmt->execute();


    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['is_admin' => $row['is_admin']]);
    } else {
        echo json_encode(['is_admin' => 0]); 
    }


    $stmt->close();
} else {
    echo json_encode(['is_admin' => 0, 'error' => 'Nincs bejelentkezve']); 
}


$conn->close();
?>
