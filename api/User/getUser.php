<?php
require './config.php';

$db = Database::getInstance();
$stmt = $db->prepare("SELECT * FROM Profil WHERE id_profil = :id_profil");
$stmt->bindParam(':id_profil', $id_profil);
$stmt->execute();
$user = $stmt->fetch();

if ($user) {
    header('Content-Type: application/json');
    echo json_encode($user);
    exit;
} else {
    header("HTTP/1.0 404 Not Found");
    exit;
}