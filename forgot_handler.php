<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $action = $_POST['action'];

    if (empty($email)) {
        echo "Az email megadása kötelező!";
        exit();
    }

    // Email validálás
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Érvénytelen email cím!";
        exit();
    }

    if ($action === "reset_password") {
        // Ellenőrizzük, hogy létezik-e a felhasználó az adatbázisban
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $otp = rand(100000, 999999);

            // Mentjük az OTP-t az adatbázisba
            $stmt = $conn->prepare("INSERT INTO password_resets (email, otp, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 15 MINUTE))");
            $stmt->bind_param("si", $email, $otp);
            $stmt->execute();

            // OTP email küldése
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kelemenjanos400@gmail.com'; 
                $mail->Password = 'ngos nthm ppff yuyf';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Feladó és címzett
                $mail->setFrom('kelemenjanos400@gmail.com', 'Te Neved');
                $mail->addAddress($email);

                // Email tartalom
                $mail->isHTML(true);
                $mail->Subject = 'Egyszer használatos kód';
                $mail->Body = 'Az egyszer használatos kódod: ' . $otp;

                $mail->send();

                // OTP küldés után átirányítjuk a felhasználót az OTP beíró oldalra
                header("Location: forgot_verify.php?email=$email");
                exit();
            } catch (Exception $e) {
                echo "Hiba történt az email küldése során: {$mail->ErrorInfo}";
            }
        } else {
            echo "Ez az email cím nincs regisztrálva!";
        }
    }
}

$conn->close();
?>