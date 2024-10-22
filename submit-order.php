<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demoncars_db";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment-method'];
    $total_price = $_POST['total_price']; 


    $sql = "INSERT INTO orders (name, email, address, phone, payment_method, total_price) 
            VALUES ('$name', '$email', '$address', '$phone', '$payment_method', '$total_price')";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id; 

        
        $cart_items = json_decode($_POST['cart_items'], true);

        foreach ($cart_items as $item) {
            $car_name = $item['name'];
            $color = $item['color'];
            $engine = $item['engine'];
            $price = $item['price'];

            $sql_item = "INSERT INTO order_items (order_id, car_name, color, engine, price) 
                         VALUES ('$order_id', '$car_name', '$color', '$engine', '$price')";

            $conn->query($sql_item);
        }

        echo "Megrendelés sikeresen leadva!";
    } else {
        echo "Hiba a megrendelés leadásakor: " . $conn->error;
    }
}

$conn->close();
?>
