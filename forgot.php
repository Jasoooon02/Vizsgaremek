<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "mysql80.r3.websupport.hu";
$username = "if0_38165555";
$password = "manoka877";
$dbname = "demoncars_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $action = $_POST['action'];

    if (empty($email)) {
        echo "<script>alert('Az email megadása kötelező!'); window.location.href='login.html';</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Érvénytelen email cím!'); window.location.href='login.html';</script>";
        exit();
    }

    if ($action === "reset_password") {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND username = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $otp = rand(100000, 999999);
    
            $stmt = $conn->prepare("INSERT INTO password_resets (email, otp, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 15 MINUTE))");
            $stmt->bind_param("si", $email, $otp);
            $stmt->execute();
    
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'demoncarsweb@gmail.com';
                $mail->Password = 'zufb koea rjur sysg';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                
                $mail->setFrom('demoncarsweb@gmail.com', 'Admin');
                $mail->addAddress($email);
    
                $mail->CharSet = 'UTF-8'; 
                $mail->isHTML(true);
                $mail->Subject = 'Egyszer használatos kód';
                $mail->Body = 'Az egyszer használatos kódod: ' . $otp;
    
                $mail->send();
    
                
                header("Location: forgot_verify.html?email=" . urlencode($email));
                exit();
            } catch (Exception $e) {
                echo "<script>alert('Hiba történt az email küldése során: {$mail->ErrorInfo}'); window.location.href='login.html';</script>";
            }
        } else {
            echo "<script>alert('Ez az email cím vagy felhasználónév nincs regisztrálva vagy nem helyesen van megadva!'); window.location.href='login.html';</script>";
        }
    }
}

$conn->close();
?>
