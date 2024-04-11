<?php

require_once __DIR__ . "/../../config.php";

$db = Database::getInstance();
$stmt = $db->prepare("SELECT P.username, P.photo_profil
FROM Profil P
INNER JOIN Profil_Abonnements PA ON P.id_profil = PA.id_abonne
WHERE PA.id_profil = $id_profil");
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
