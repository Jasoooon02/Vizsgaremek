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
    $otp = trim($_POST['otp']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($email) || empty($otp) || empty($new_password) || empty($confirm_password)) {
        echo "Minden mező kitöltése kötelező!";
        exit();
    }

    if ($new_password !== $confirm_password) {
        echo "A jelszavak nem egyeznek!";
        
        echo '<script>
                setTimeout(function() {
                    window.history.back();
                }, 2000);
              </script>';
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE email = ? AND otp = ? AND expires_at > NOW()");
    $stmt->bind_param("si", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $hashed_password, $email);

        if ($update_stmt->execute()) {
            
            $mail = new PHPMailer(true);

            try {
                
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'demoncarsweb@gmail.com'; 
                $mail->Password = 'bicu xoan ysot bfdc'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                
                $mail->CharSet = 'UTF-8'; 
                
                
                $mail->setFrom('no-reply@webshop.hu', 'Webshop');
                $mail->addAddress($email); 
                $mail->Subject = 'Jelszó módosítása sikeresen megtörtént';
                $mail->Body = "Kedves Felhasználó,\n\nA jelszavát sikeresen megváltoztattuk. Ha nem Ön kérte a jelszó módosítását, kérjük, lépjen kapcsolatba velünk.\n\nÜdvözlettel,\nDemoncars Webshop csapat";

                
                $mail->send();
                echo '<div class="success">A jelszó sikeresen megváltozott. Egy emailt küldtünk a változtatásról.</div>';
            } catch (Exception $e) {
                echo '<div class="error">Hiba történt az értesítő email küldése közben: ' . $mail->ErrorInfo . '</div>';
            }

            
            header("Location: index.html");
            exit();
        } else {
            echo "Hiba történt a jelszó frissítésekor!";
        }
    } else {
        echo "Hibás OTP, vagy lejárt a kód!";
    }
}

$conn->close();
?>
