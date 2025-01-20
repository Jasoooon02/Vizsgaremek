<?php
session_start();
$servername = "sql204.infinityfree.com";
$username = "if0_38141147";
$password = "manoka87";
$dbname = "if0_38141147_user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($input_password, $row['password'])) {
            $_SESSION['username'] = $input_username;
            header("Location: index.html");
        } else {
            echo "Helytelen jelszó!";
        }
    } else {
        echo "Felhasználó nem található!";
    }
}
$conn->close();
?>
