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

    if (empty($otp)) {
        echo "Az OTP mező kitöltése kötelező!";
        exit();
    }

    // Ellenőrizzük, hogy az OTP helyes és nem járt le
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE email = ? AND otp = ? AND expires_at > NOW()");
    $stmt->bind_param("si", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // OTP helyes, most kérjük az új jelszót
        echo "Az OTP helyes. Most állíthatod be az új jelszót!";
        
        // Jelszó beállító űrlap
        echo '<form action="reset_password.php" method="POST">
                <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
                <input type="hidden" name="otp" value="' . htmlspecialchars($otp) . '">
                <div class="user-box">
                  <input type="password" name="new_password" placeholder="Új jelszó" required>
                </div>
                <div class="user-box">
                  <input type="password" name="confirm_password" placeholder="Jelszó megerősítése" required>
                </div>
                <button type="submit" class="button">Új jelszó mentése</button>
              </form>';
    } else {
        echo "Hibás OTP, vagy lejárt a kód!";
    }
}

$conn->close();
?>