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
    $email = trim($_POST['email']);

    if (empty($email)) {
        echo "Az email mező kitöltése kötelező!";
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "Ez az email cím nincs regisztrálva!";
    } else {
        $otp = rand(100000, 999999);

        $stmt = $conn->prepare("INSERT INTO password_resets (email, otp, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 15 MINUTE))");
        $stmt->bind_param("si", $email, $otp);

        if ($stmt->execute()) {
            $subject = "Egyszer használatos belépési kód";
            $message = "Kedves Felhasználó,\n\nAz egyszer használatos belépési kódod: $otp\nEz a kód 15 percig érvényes.\n\nÜdvözlettel,\nA Csapat";
            $headers = "From: no-reply@yourdomain.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "Az egyszer használatos kódot elküldtük az email címedre.";
            } else {
                echo "Hiba történt az email küldése során.";
            }
        } else {
            echo "Hiba történt: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>