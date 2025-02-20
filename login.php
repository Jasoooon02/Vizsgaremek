<?php
session_start();
$servername = "sql302.infinityfree.com";
$username = "if0_38165555"; 
$password = "manoka877"; 
$dbname = "if0_38165555_demoncars_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);

    if (empty($input_username) || empty($input_password)) {
        echo "<script>alert('Felhasználónév és jelszó szükséges!'); window.location.href='index.html';</script>";
    } else {
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $input_username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($input_password, $row['password'])) {
                
                $_SESSION['username'] = $input_username;
                echo "
                    <script>
                        alert('Sikeresen bejelentkeztél!');
                        localStorage.setItem('isLoggedIn', 'true');
                        localStorage.setItem('username', '" . $input_username . "');
                        window.location.href = 'fo.html';
                    </script>";
                exit();
            } else {
                echo "<script>alert('Helytelen jelszó!'); window.location.href='index.html';</script>";
            }
        } else {
            echo "<script>alert('Nincs ilyen felhasználó!'); window.location.href='index.html';</script>";
        }
    }
}

$conn->close();
?>
