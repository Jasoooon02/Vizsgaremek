<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

// Kapcsolat létrehozása az adatbázissal
$conn = new mysqli($servername, $username, $password, $dbname);

// Ellenőrizzük a kapcsolatot
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Adatok bevitele és tisztítása
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);

    // Ellenőrizzük, hogy a felhasználónév és jelszó ne legyen üres
    if (empty($input_username) || empty($input_password)) {
        echo "Felhasználónév és jelszó szükséges!";
    } else {
        // Előkészített lekérdezés a felhasználónév ellenőrzéséhez
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $input_username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Felhasználónév már létezik!";
        } else {
            // Előkészített lekérdezés a felhasználó hozzáadásához
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $hashed_password = password_hash($input_password, PASSWORD_DEFAULT); // Jelszó hashelése
            $stmt->bind_param("ss", $input_username, $hashed_password);

            // Végrehajtás és hibakezelés
            if ($stmt->execute()) {
                echo "Sikeres regisztráció!";
                header("Location: login.html");
                exit();
            } else {
                echo "Hiba történt: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>
