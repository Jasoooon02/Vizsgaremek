<?php
$servername = "mysql80.r3.websupport.hu";
$username = "if0_38165555"; 
$password = "manoka877"; 
$dbname = "demoncars_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die(json_encode(["error" => "Kapcsolati hiba: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['userid']) && is_numeric($_POST['userid'])) {
        $user_id = intval($_POST['userid']);

        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => "Sikeresen törölve: felhasználó ID $user_id"]);
        } else {
            echo json_encode(["error" => "Hiba történt a törlés során: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Érvénytelen vagy hiányzó userid"]);
    }
} else {
    echo json_encode(["error" => "Csak POST kérések engedélyezettek"]);
}

$conn->close();
?>
