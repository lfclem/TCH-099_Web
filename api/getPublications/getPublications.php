<?php

require_once "./config.php";

$db = Database::getInstance();
$stmt = $db->prepare("SELECT * FROM `Publication` WHERE id_profil = :id_profil");
$stmt->bindParam(':id_profil', $id);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
} else {
    header("HTTP/1.0 404 Not Found");
    exit;
}