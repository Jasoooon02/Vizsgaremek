<?php
$servername = "sql302.infinityfree.com";
$username = "if0_38165555";
$password = "manoka877";
$dbname = "if0_38165555_demoncars_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kapcsolati hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $orderId = $_POST['order_id'];
    $action = $_POST['action'];

    if ($action === "accept") {
        $sql = "SELECT email, created_at FROM orders WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $stmt->bind_result($email, $created_at);
        $stmt->fetch();
        $stmt->close();

        $deliveryDate = date('Y-m-d', strtotime($created_at . ' +3 days'));

        $to = $email;
        $subject = "Megrendelés visszaigazolás";
        $message = "Kedves Vásárló! A rendelése szállítás alatt van. Várható érkezés: " . $deliveryDate;
        $headers = "From: noreply@demoncars.com";

        mail($to, $subject, $message, $headers);

        echo "Email elküldve.";
    } elseif ($action === "delete") {
        $sql = "DELETE FROM orders WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        echo "Rendelés törölve.";
        $stmt->close();
    }
}

$conn->close();
?>
