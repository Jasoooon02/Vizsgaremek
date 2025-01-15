<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demoncars_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
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

        
        $order_details = "Megrendelés azonosítója: $order_id\n";
        $order_details .= "Név: $name\nEmail: $email\nCím: $address\nTelefon: $phone\nFizetési mód: $payment_method\nÖsszesen: $total_price\n\n";
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
        $headers = "From: no-reply@demoncars.hu" . "\r\n" .
                   "Reply-To: support@demoncars.hu" . "\r\n" .
                   "Content-Type: text/plain; charset=UTF-8";

        
        $message = "Kedves $name!\n\nKöszönjük a rendelését!\n\n" . 
                   "A rendelés részletei:\n$order_details\n\n" . 
                   "A megrendelését sikeresen rögzítettük, és hamarosan feldolgozzuk.\n\n" . 
                   "Üdvözlettel,\nA DemonCars csapata";

        
        $mail = new PHPMailer(true);
        
        try {
            
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->Username = 'kelemenjanos400@gmail.com';  
            $mail->Password = 'tbws adir tbrk tbgu'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            
            $mail->setFrom('kelemenjanos400@gmail.com', 'DemonCars');
            $mail->addAddress($to);  
            $mail->addReplyTo('support@demoncars.hu', 'Support');
            $mail->CharSet = 'UTF-8';
            
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            
            $mail->send();

            
            $admin_email = 'kelemenjanos400@gmail.com';  
            $mail->clearAddresses();
            $mail->addAddress($admin_email);
            $mail->Subject = "Új rendelés: #$order_id";
            $mail->Body = $order_details;
            $mail->send();

        } catch (Exception $e) {
            echo "Hiba az e-mail küldésekor: {$mail->ErrorInfo}";
        }

        
        echo "<script>
                alert('Megrendelés sikeresen leadva! A megrendelés azonosítója: " . $order_id . "');
                setTimeout(function() {
                    window.location.href = 'index.html';
                }, 500); 
              </script>";
    } else {
        echo "Hiba a megrendelés leadásakor: " . $conn->error;
    }
}
$conn->close();
?>
