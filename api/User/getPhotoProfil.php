<?php
require_once __DIR__ . "/../../config.php";

$db = Database::getInstance();
$stmt = $db->prepare("SELECT photo_profil FROM Profil WHERE id_profil = :id_profil");
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
