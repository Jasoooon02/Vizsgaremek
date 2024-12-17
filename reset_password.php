<?php
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
    $otp = trim($_POST['otp']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Ellenőrizzük, hogy minden mező ki van-e töltve
    if (empty($email) || empty($otp) || empty($new_password) || empty($confirm_password)) {
        echo "Minden mező kitöltése kötelező!";
        exit();
    }

    // Ellenőrizzük, hogy az új jelszó és a megerősítés megegyezik-e
    if ($new_password !== $confirm_password) {
        echo "A jelszavak nem egyeznek!";
        exit();
    }

    // Ellenőrizzük, hogy az OTP helyes és nem járt le
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE email = ? AND otp = ? AND expires_at > NOW()");
    $stmt->bind_param("si", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jelszó titkosítása
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Jelszó frissítése az adatbázisban
        $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $hashed_password, $email);

        if ($update_stmt->execute()) {
            // Jelszó sikeresen frissítve, átirányítás a login oldalra
            header("Location: login.html");
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