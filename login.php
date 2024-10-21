<?php
session_start();
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
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);

    if (empty($input_username) || empty($input_password)) {
        echo "Felhasználónév és jelszó szükséges!";
    } else {
        // Bejelentkezési logika
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $input_username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($input_password, $row['password'])) {
                $_SESSION['username'] = $input_username;
                header("Location: index.html"); 
                exit();
            } else {
                echo "Helytelen jelszó!";
            }
        } else {
            echo "Nincs ilyen felhasználó!";
        }
    }
}

$conn->close();
?>
