<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "mysql80.r3.websupport.hu";
$username = "if0_38165555";
$password = "manoka877";
$dbname = "demoncars_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$order_success = false;
$order_id = null;

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

        $order_details = "Megrendelés azonosítója: $order_id\n";
        $order_details .= "Név: $name\nEmail: $email\nCím: $address\nTelefon: $phone\nFizetési mód: $payment_method\nÖsszesen: $total_price Ft\n\n";
        $order_details .= "Rendelt termékek:\n";

        foreach ($cart_items as $item) {
            $car_name = $item['name'];
            $color = $item['color'];
            $engine = $item['engine'];
            $price = $item['price'];

            $sql_item = "INSERT INTO order_items (order_id, car_name, color, engine, price) 
                         VALUES ('$order_id', '$car_name', '$color', '$engine', '$price')";

            $conn->query($sql_item);
            $order_details .= "- $car_name ($color, $engine motor) - $price Ft\n";
        }

        $to = $email;
        $subject = "Rendelés megerősítése - Megrendelés azonosító: $order_id";
        $message = "Kedves $name!\n\nKöszönjük a rendelését!\n\n" . 
                   "A rendelés részletei:\n$order_details\n\n" . 
                   "A megrendelését sikeresen rögzítettük, és hamarosan feldolgozzuk.\n\n" . 
                   "Üdvözlettel,\nA DemonCars csapata";

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'demoncarsweb@gmail.com';
            $mail->Password = 'zufb koea rjur sysg';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('demoncarsweb@gmail.com', 'DemonCars');
            $mail->addAddress($to);
            $mail->addReplyTo('support@demoncars.hu', 'Support');
            $mail->CharSet = 'UTF-8';

            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();

            $admin_email = 'demoncarsweb@gmail.com';
            $mail->clearAddresses();
            $mail->addAddress($admin_email);
            $mail->Subject = "Új rendelés: #$order_id";
            $mail->Body = $order_details;
            $mail->send();

            $order_success = true;

        } catch (Exception $e) {
            echo "Hiba az e-mail küldésekor: {$mail->ErrorInfo}";
        }
    } else {
        echo "Hiba a megrendelés leadásakor: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelés</title>
    <style>
        #success-check {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        #success-check svg {
            width: 50px;
            height: 50px;
            fill: limegreen;
        }
    </style>
</head>
<body>

<?php if ($order_success): ?>
    <div id="success-check">
        <svg viewBox="0 0 24 24">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
        <p>Sikeres rendelés! Megrendelés azonosítója: <?php echo $order_id; ?></p>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("success-check").style.display = "flex";
            setTimeout(function() {
                window.location.href = 'fo.html';
            }, 8000);
        });
    </script>
<?php endif; ?>

</body>
</html>
