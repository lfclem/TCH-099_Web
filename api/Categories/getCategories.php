<?php
require_once __DIR__ . "/../../config.php";

$db = Database::getInstance();
$stmt = $db->prepare('SELECT * FROM Categorie');
$stmt->execute();
$categorie = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($categorie);