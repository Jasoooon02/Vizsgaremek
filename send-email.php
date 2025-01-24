<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $to = $data['to'];
    $subject = $data['subject'];
    $email = $data['email'];
    $message = $data['message'];

    
    $mail = new PHPMailer(true);

    try {
        
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'demoncarsweb@gmail.com'; 
        $mail->Password = 'bicu xoan ysot bfdc';      
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
        echo json_encode(['success' => true, 'message' => 'Üzenet elküldve!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Hiba: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Nem érvényes kérés']);
}
