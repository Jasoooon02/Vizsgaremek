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
    
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);

    
    if (empty($input_username) || empty($input_password)) {
        echo "Felhasználónév és jelszó szükséges!";
    } else {
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $input_username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Felhasználónév már létezik!";
        } else {
            
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $hashed_password = password_hash($input_password, PASSWORD_DEFAULT); 
            $stmt->bind_param("ss", $input_username, $hashed_password);

          
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
