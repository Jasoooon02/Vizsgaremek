<?php
session_start();
header('Access-Control-Allow-Origin: www.demoncars.online');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

try {
    $conn = new mysqli('mysql80.r3.websupport.hu', 'if0_38165555', 'manoka877', 'demoncars_db');
    $conn->set_charset("utf8");

    if (isset($_POST['orderid']) && isset($_POST['email'])) {
        $orderId = $_POST['orderid'];
        $email = $_POST['email'];

        
        $sql = "SELECT payment_method FROM orders WHERE id = ? AND email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $orderId, $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($paymentMethod);
        $stmt->fetch();
        
        
        $sqlUpdate = "UPDATE orders SET status = 'Kész' WHERE id = ? AND email = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("is", $orderId, $email);
        $stmtUpdate->execute();

        
        $deliveryDate = date('Y-m-d', strtotime('+3 days'));

        
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'demoncarsweb@gmail.com';
        $mail->Password = 'zufb koea rjur sysg';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('demoncarsweb@gmail.com', 'DemonCars');
        $mail->addAddress($email);
        $mail->addReplyTo('support@yourdomain.com', 'Support');
        $mail->CharSet = 'UTF-8';
        
        
        $subject = "Rendelés állapot frissítés";
        $message = "
            Örömmel értesítjük, hogy a rendelése elkészült és a státusza 'Kész' lett.<br><br>
            A rendelése várható szállítási dátuma: {$deliveryDate}.<br><br>
            Köszönjük, hogy minket választott!<br><br>
            Üdvözlettel,<br>
            A DemonCars csapata
        ";

        
        if ($paymentMethod === 'készpénz') {
            $message = "
                Örömmel értesítjük, hogy a rendelése elkészült és a státusza 'Kész' lett.<br><br>
                A rendelése várható szállítási dátuma: {$deliveryDate}.<br><br>
                Mivel készpénzes fizetést választott, kérjük, keresse fel csapatunkat.<br><br>
                Köszönjük, hogy minket választott!<br><br>
                Üdvözlettel,<br>
                A DemonCars csapata
            ";
        }

        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        
        if ($mail->send()) {
            echo json_encode(["success" => true, "message" => "E-mail sikeresen elküldve."]);
        } else {
            echo json_encode(["success" => false, "message" => "Hiba történt az e-mail küldésekor."]);
        }

    } else {
        echo json_encode(["success" => false, "message" => "Hiányzó paraméterek."]);
    }

    $conn->close();
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Hiba történt az adatbázis kapcsolat során."]);
}
?>
