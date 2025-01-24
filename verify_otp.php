<?php
$servername = "sql302.infinityfree.com";
$username = "if0_38165555";
$password = "manoka877";
$dbname = "if0_38165555_user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Ellenőrzés</title>
    <link rel="stylesheet" href="css/forgot.css">
    <script>
        function hideAlert() {
            setTimeout(function() {
                document.getElementById('otp-alert').style.display = 'none';
            }, 2000);
        }
    </script>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $otp = trim($_POST['otp']);

    if (empty($otp)) {
        echo "<div class='error'>Az OTP mező kitöltése kötelező!</div>";
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE email = ? AND otp = ? AND expires_at > NOW()");
    $stmt->bind_param("si", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div id="otp-alert" class="success">Az OTP kód helyes. Most állíthatod be az új jelszót!</div>';
        echo '<form action="reset_password.php" method="POST" class="otp-box">
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
        echo '<script>hideAlert();</script>';
    } else {
        echo "<div class='error'>Hibás OTP, vagy lejárt a kód!</div>";
    }
}

$conn->close();
?>
</body>
</html>
