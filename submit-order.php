<?php
// MySQL kapcsolódási adatok
$servername = "localhost";
$username = "root"; // vagy a saját felhasználóneved
$password = ""; // vagy a saját jelszavad
$dbname = "demoncars_db";

// Kapcsolat az adatbázishoz
$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Az űrlap adatok feldolgozása
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment-method'];
    $total_price = $_POST['total_price']; // Ez a kosár összárát kellene tartalmazza

    // Megrendelés mentése az orders táblába
    $sql = "INSERT INTO orders (name, email, address, phone, payment_method, total_price) 
            VALUES ('$name', '$email', '$address', '$phone', '$payment_method', '$total_price')";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id; // Megrendelés azonosító (order_id)

        // Kosár elemek hozzáadása
        $cart_items = json_decode($_POST['cart_items'], true); // A localStorage-ból érkező kosáradatok

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
