<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "mysql80.r3.websupport.hu";
$username = "if0_38165555";
$password = "manoka877";
$dbname = "demoncars_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("<script>alert('Kapcsolódási hiba: " . $conn->connect_error . "');</script>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);
    $input_confirm_password = trim($_POST['confirm_password']);
    $input_email = trim($_POST['email']);
    $admin_code = isset($_POST['admin_code']) ? trim($_POST['admin_code']) : null;

    $admin_key = "22087078022"; 
    $is_admin = ($admin_code === $admin_key) ? 1 : 0;

    if ($admin_code !== null && $admin_code !== $admin_key) {
        echo "<script>alert('Hibás admin kód!'); window.location.href = 'index.html';</script>";
        exit();
    }

    if (empty($input_username) || empty($input_password) || empty($input_confirm_password) || empty($input_email)) {
        echo "<script>alert('Minden mező kitöltése kötelező!');</script>";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Érvénytelen email cím!');</script>";
    } elseif ($input_password !== $input_confirm_password) {
        echo "<script>
                alert('A jelszavak nem egyeznek!');
                setTimeout(function() {
                    window.location.href = 'index.html';
                }, 1000);
              </script>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $input_username, $input_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('A felhasználónév vagy az email már használatban van!'); window.location.href = 'index.html';</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, is_admin) VALUES (?, ?, ?, ?)");
            $hashed_password = password_hash($input_password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssi", $input_username, $hashed_password, $input_email, $is_admin);

            if ($stmt->execute()) {
                $to = $input_email;
                $subject = "Sikeres regisztráció";
                $message = "Kedves " . $input_username . ",\n\nKöszönjük, hogy regisztrált oldalunkon!\nÜdvözlünk a közösségben.\n\nÜdvözlettel,\nA Demoncars Weboldal Csapata";

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'demoncarsweb@gmail.com';
                    $mail->Password = 'zufb koea rjur sysg';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    
                    $mail->setFrom('demoncarsweb@gmail.com', 'Weboldal');
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
