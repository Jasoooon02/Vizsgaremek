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
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);
    $input_email = trim($_POST['email']);

    if (empty($input_username) || empty($input_password) || empty($input_email)) {
        echo "Minden mező kitöltése kötelező!";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        echo "Érvénytelen email cím!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $input_username, $input_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "A felhasználónév vagy az email már használatban van!";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $hashed_password = password_hash($input_password, PASSWORD_DEFAULT);
            $stmt->bind_param("sss", $input_username, $hashed_password, $input_email);

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
