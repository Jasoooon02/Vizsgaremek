<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "sql302.infinityfree.com";
$username = "if0_38165555";
$password = "manoka877";
$dbname = "if0_38165555_demoncars_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $action = $_POST['action'];

    if (empty($email)) {
        echo "<script>alert('Az email megadása kötelező!'); window.location.href='index.html';</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Érvénytelen email cím!'); window.location.href='index.html';</script>";
        exit();
    }

    if ($action === "recover_username") {
        $stmt = $conn->prepare("SELECT username FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row['username'];

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
                $mail->setFrom('demoncarsweb@gmail.com', 'Admin');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Felhasználónév helyreállítás';
                $mail->Body = "Kedves Felhasználó, az Ön felhasználóneve: <b>$username</b>";

                $mail->send();
                echo "<script>alert('A felhasználónév sikeresen elküldve az e-mail címére.');</script>";
                echo "<script>setTimeout(function() { window.location.href = 'index.html'; }, 100);</script>";
            } catch (Exception $e) {
                echo "<script>alert('Hiba történt az email küldése során: {$mail->ErrorInfo}'); window.location.href='index.html';</script>";
            }
        } else {
            echo "<script>alert('Ez az email cím nincs regisztrálva!'); window.location.href='index.html';</script>";
        }
    }
}

$conn->close();
?>
