<?php
$conn = new mysqli('mysql80.r3.websupport.hu', 'if0_38165555', 'manoka877', 'demoncars_db');
$conn->set_charset("utf8");

if (isset($_GET['name']) && isset($_GET['engine'])) {
    $name = $conn->real_escape_string($_GET['name']);
    $engine = $conn->real_escape_string($_GET['engine']);
    
    
    $sql = "SELECT price FROM cars WHERE name='$name' AND engine='$engine'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['price']; 
    } else {
        echo "Hiba: Az ár nem található."; 
    }
} else {
    echo "Hibás paraméterek."; 
}

$conn->close();
?>
