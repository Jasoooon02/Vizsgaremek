<?php
$servername = "localhost";
$username = "root"; 
$password = "root"; 
$dbname = "user_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolat hiba: " . $conn->connect_error . "" );
}
//$sql="INSERT INTO users (id,username,password) VALUES ()";
echo "Sikeresen kapcsolódott az adatbázishoz.";
?>
