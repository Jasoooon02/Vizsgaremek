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

// Kapcsolódás
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Adatbázis kapcsolódási hiba']));
}

// Ellenőrzés, hogy a felhasználó be van-e jelentkezve
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $felhasznalonev = $_SESSION['username'];

    // SQL előkészítés
    $query = "SELECT is_admin FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $felhasznalonev);
    $stmt->execute();

    // Eredmény feldolgozása
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['is_admin' => $row['is_admin']]);
    } else {
        echo json_encode(['is_admin' => 0]); // Ha nincs ilyen felhasználó
    }

    // Erőforrások felszabadítása
    $stmt->close();
} else {
    echo json_encode(['is_admin' => 0, 'error' => 'Nincs bejelentkezve']); // Ha nincs bejelentkezve
}

// Kapcsolat lezárása
$conn->close();
?>
