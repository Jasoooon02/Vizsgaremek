<?php
// Hibaüzenetek bekapcsolása
ini_set('display_errors', 1);
error_reporting(E_ALL);

// A többi kód következik...

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $to = 'demoncarsweb@gmail.com';
    $subject = 'Kapcsolat Üzenet';

    if (empty($email) || empty($message)) {
        echo 'Hiba: Az összes mező kitöltése kötelező!';
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'demoncarsweb@gmail.com'; 
        $mail->Password = 'zufb koea rjur sysg';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->CharSet = 'UTF-8';
        $mail->setFrom($email, 'Kapcsolat Üzenet');
        $mail->addAddress($to);
        $mail->addReplyTo($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;

        $formattedMessage = "
            <p><strong>Üzenet:</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
            <hr>
            <p><strong>Válasz cím:</strong> <a href='mailto:$email'>$email</a></p>
        ";

        $mail->Body = $formattedMessage;
        $mail->AltBody = "Üzenet: $message\n\nVálasz cím: $email";

        $mail->send();
        echo 'success';  
    } catch (Exception $e) {
        echo 'Hiba: ' . $mail->ErrorInfo;
    }
} else {
    echo 'Hiba: Nem megfelelő kérés';
}
