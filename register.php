<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = [
        'username' => $username,
        'password' => $password
    ];

    $ch = curl_init("http://localhost:8080/register");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($http_code == 200) {
        echo "Sikeres regisztráció!";
    } else {
        echo "Hiba: " . $response;
    }
}
?>