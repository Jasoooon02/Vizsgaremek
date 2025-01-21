<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "sql204.infinityfree.com";
$username = "if0_38141147";
$password = "manoka87";
$dbname = "if0_38141147_user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("<script>alert('Kapcsolódási hiba: " . $conn->connect_error . "');</script>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);
    $input_email = trim($_POST['email']);

    if (empty($input_username) || empty($input_password) || empty($input_email)) {
        echo "<script>alert('Minden mező kitöltése kötelező!');</script>";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Érvénytelen email cím!');</script>";
    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $input_username, $input_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('A felhasználónév vagy az email már használatban van!'); window.location.href = 'index.html';</script>";
        } else {

            $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $hashed_password = password_hash($input_password, PASSWORD_DEFAULT);
            $stmt->bind_param("sss", $input_username, $hashed_password, $input_email);

            if ($stmt->execute()) {

                $to = $input_email;
                $subject = "Sikeres regisztráció";
                $message = "Kedves " . $input_username . ",\n\nKöszönjük, hogy regisztrált oldalunkon!\nÜdvözlünk a közösségben.\n\nÜdvözlettel,\nA Demoncars Weboldal Csapata";

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'kelemenjanos400@gmail.com';
                    $mail->Password = 'tbws adir tbrk tbgu';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('kelemenjanos400@gmail.com', 'Weboldal');
                    $mail->addAddress($to);
                    $mail->addReplyTo('support@yourdomain.com', 'Support');
                    $mail->CharSet = 'UTF-8';

                    $mail->isHTML(false);
                    $mail->Subject = $subject;
                    $mail->Body = $message;

                    $mail->send();
                    echo "<script>alert('Sikeres regisztráció! Ellenőrizze az emailjeit.'); window.location.href = 'index.html';</script>";
                } catch (Exception $e) {
                    echo "<script>alert('Sikeres regisztráció, de az email küldése sikertelen volt: {$mail->ErrorInfo}'); window.location.href = 'index.html';</script>";
                }
                exit();
            } else {
                echo "<script>alert('Hiba történt: " . $stmt->error . "');</script>";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>
