<?php

require_once "./config.php";

$db = Database::getInstance();

$requestUri = $_SERVER['REQUEST_URI'];

$segments = explode('/', $requestUri);

$id_profil = end($segments);

$stmt = $db->prepare("SELECT * FROM `Paiement` WHERE id_profil = :id_profil");
$stmt->bindParam(':id_profil', $id_profil);
$stmt->execute();

$data = $stmt->fetch();

if ($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
} else {
    header("HTTP/1.0 404 Not Found");
    exit;
}