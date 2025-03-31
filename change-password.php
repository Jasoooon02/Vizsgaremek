<?php
session_start();

$servername = "mysql80.r3.websupport.hu";
$username = "if0_38165555"; 
$password = "manoka877"; 
$dbname = "demoncars_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    if (!isset($_SESSION['username'])) {
        echo 'Hiba: Nincs bejelentkezve!';
        exit;
    }

    $username = $_SESSION['username'];

    $query = "SELECT password, email FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo 'Hiba: Felhasználó nem található!';
        exit;
    }

    if (!password_verify($currentPassword, $user['password'])) {
        echo 'Hiba: A jelenlegi jelszó nem megfelelő!';
        exit;
    }

    if (strlen($newPassword) < 5 || !preg_match('/[0-9!@#$%^&*(),.?":{}|<>]/', $newPassword)) {
        echo 'Hiba: Az új jelszónak legalább 5 karakter hosszúnak kell lennie és tartalmaznia kell egy számot vagy speciális karaktert!';
        exit;
    }

    $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

    $updateQuery = "UPDATE users SET password = ? WHERE username = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ss", $newPasswordHash, $username);
    $updateStmt->execute();

    if ($updateStmt->affected_rows > 0) {
        
        $userEmail = $user['email']; 

        
        require 'vendor/autoload.php'; 

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'demoncarsweb@gmail.com'; 
            $mail->Password = 'zufb koea rjur sysg'; 
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('demoncarsweb@gmail.com', 'Weboldal');
            $mail->addAddress($userEmail); 
            $mail->addReplyTo('support@yourdomain.com', 'Support');
            $mail->CharSet = 'UTF-8';

            
            $mail->isHTML(false);
            $mail->Subject = 'Jelszó módosítása';
            $mail->Body = 'Kedves Felhasználó! A jelszavad sikeresen megváltozott. Ha nem te végezted el ezt a műveletet, kérjük, vedd fel a kapcsolatot csapatunkkal.';

            
            $mail->send();
        } catch (Exception $e) {
            echo 'Hiba történt az e-mail küldésekor: ', $mail->ErrorInfo;
        }

        echo 'success';
    } else {
        echo 'Hiba történt a jelszó módosítása során.';
    }
}

$conn->close();
?>
