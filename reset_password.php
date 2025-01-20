<?php
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
    $otp = trim($_POST['otp']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);


    if (empty($email) || empty($otp) || empty($new_password) || empty($confirm_password)) {
        echo "Minden mező kitöltése kötelező!";
        exit();
    }


    if ($new_password !== $confirm_password) {
        echo "A jelszavak nem egyeznek!";
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