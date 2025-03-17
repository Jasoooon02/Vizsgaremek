<?php
session_start();
$servername = "mysql80.r3.websupport.hu";
$username = "if0_38165555"; 
$password = "manoka877"; 
$dbname = "demoncars_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_user = trim($_POST['user']); 
    $input_password = trim($_POST['password']);

    if (empty($input_user) || empty($input_password)) {
        echo "<script>alert('Felhasználónév/E-mail és jelszó szükséges!'); window.location.href='index.html';</script>";
    } else {
        
        $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $input_user, $input_user);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($input_password, $row['password'])) {
                
                $_SESSION['username'] = $row['username'];
                echo "
                    <script>
                        alert('Sikeresen bejelentkeztél!');
                        localStorage.setItem('isLoggedIn', 'true');
                        localStorage.setItem('username', '" . $row['username'] . "');
                        window.location.href = 'fo.html';
                    </script>";
                exit();
            } else {
                echo "<script>alert('Helytelen jelszó!'); window.location.href='index.html';</script>";
            }
        } else {
            echo "<script>alert('Nincs ilyen felhasználó vagy e-mail!'); window.location.href='index.html';</script>";
        }
    }
}

$conn->close();
?>
