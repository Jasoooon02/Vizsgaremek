<?php
session_start();
header('Access-Control-Allow-Origin: http://demoncars.free.nf');
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
        
        $sql = "SELECT email FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response = [
                "success" => true,
                "email" => $row['email']
            ];
            
            
            if ($username === 'admin') {
                $response["showToggleButton"] = true;
            }
            
            echo json_encode($response);
        } else {
            echo json_encode(["success" => false, "message" => "Felhasználó nem található."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Nincs bejelentkezve."]);
    }

    $conn->close();
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Hiba történt az adatbázis kapcsolat során."]);
}
?>
