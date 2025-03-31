<?php
session_start();
header('Access-Control-Allow-Origin: www.demoncars.online');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

try {
    $conn = new mysqli('mysql80.r3.websupport.hu', 'if0_38165555', 'manoka877', 'demoncars_db');
    $conn->set_charset("utf8");

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        
        $sql = "SELECT id, name, email, address, phone, payment_method, total_price, created_at, status FROM orders";
        $result = $conn->query($sql);

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        echo json_encode($orders);
    } else {
        echo json_encode(["success" => false, "message" => "Nincs bejelentkezve."]);
    }

    $conn->close();
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Hiba történt az adatbázis kapcsolat során."]);
}

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}


$json_data = json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
if ($json_data === false) {
    die(json_encode(["error" => "JSON hiba: " . json_last_error_msg()]));
}

echo $json_data;

$conn->close();
?>
