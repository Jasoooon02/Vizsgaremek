<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "sql204.infinityfree.com";
$username = "if0_38141147";
$password = "manoka87";
$dbname = "if0_38141147_user_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $action = $_POST['action'];

    if (empty($email)) {
        echo "Az email megadása kötelező!";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Érvénytelen email cím!";
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
                $mail->Username = 'kelemenjanos400@gmail.com'; 
                $mail->Password = 'tbws adir tbrk tbgu'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->CharSet = 'UTF-8'; 
                $mail->setFrom('kelemenjanos400@gmail.com', 'Admin');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Felhasználónév helyreállítás';
                $mail->Body = "Kedves Felhasználó, az Ön felhasználóneve: <b>$username</b>";

                $mail->send();
                echo "<script>alert('A felhasználónév sikeresen elküldve az e-mail címére.');</script>";
                echo "<script>setTimeout(function() { window.location.href = 'index.html'; }, 100);</script>";
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
