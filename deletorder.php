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
    
    if (isset($_POST['orderid']) && is_numeric($_POST['orderid'])) {
        $order_id = intval($_POST['orderid']);

        
        $sql = "DELETE FROM orders WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $order_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => "Sikeresen törölve: rendelés ID $order_id"]);
        } else {
            echo json_encode(["error" => "Hiba történt a törlés során: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Érvénytelen vagy hiányzó orderid"]);
    }
} else {
    echo json_encode(["error" => "Csak POST kérések engedélyezettek"]);
}

$conn->close();
?>
