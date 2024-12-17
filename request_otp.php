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

    // Ellenőrizzük, hogy a megadott email cím létezik-e
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // OTP generálása
        $otp = rand(100000, 999999); // 6 számjegyű OTP

        // Lejárati idő beállítása (5 perc)
        $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        // Mentjük el az OTP-t és a lejáratot az adatbázisba
        $stmt = $conn->prepare("INSERT INTO password_resets (email, otp, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $otp, $expires_at);
        $stmt->execute();

        // Küldhetünk egy emailt az OTP-vel, de most csak kiírjuk
        echo "Az OTP: " . $otp;
        
        // Továbbítjuk az emailt a következő lépéshez (felhasználó beállíthatja a jelszót)
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
