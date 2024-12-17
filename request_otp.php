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
    $email = $_POST['email'];

    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
       
        $otp = rand(100000, 999999); 

        
        $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        
        $stmt = $conn->prepare("INSERT INTO password_resets (email, otp, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $otp, $expires_at);
        $stmt->execute();

        
        echo "Az OTP: " . $otp;
        
        
        echo '<form action="password_reset.php" method="POST">
                <div class="user-box">
                  <input type="text" name="otp" placeholder="Add meg az OTP-t" required>
                  <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
                </div>
                <button type="submit" class="button">OTP ellenőrzése</button>
              </form>';
    } else {
        echo "Nem található felhasználó ezzel az email címmel!";
    }
}

$conn->close();
?>
