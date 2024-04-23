<?php
require_once __DIR__ . "/../../config.php";

$db = Database::getInstance();
$stmt = $db->prepare('SELECT id_profil FROM Publication WHERE id_publication = :id');
$stmt->bindParam(':id', $id_publication);
$stmt->execute();
$publication = $stmt->fetch(PDO::FETCH_ASSOC);

if ($publication) {
    header('Content-Type: application/json');
    echo json_encode($publication);
    exit;
} else {
    header("HTTP/1.0 404 Not Found");
    exit;
}