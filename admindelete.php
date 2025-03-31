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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = intval($_POST["userid"] ?? 0);

    if ($userId > 0) {
        $sql = "UPDATE users SET is_admin = 0 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => "Admin jog eltávolítva!"]);
        } else {
            echo json_encode(["error" => "Hiba az admin jog eltávolítása során!"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Érvénytelen felhasználói azonosító!"]);
    }
}

$conn->close();
?>
