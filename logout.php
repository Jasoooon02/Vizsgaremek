<?php
header('Access-Control-Allow-Origin: www.demoncars.online');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

session_start();
session_destroy();
echo json_encode(["success" => true, "message" => "Sikeresen kijelentkeztél!"]);
?>
