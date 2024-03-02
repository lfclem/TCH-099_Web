<?php

require_once "./config.php";

$db = Database::getInstance();

$stmt = $db->prepare("SELECT * FROM `Publication`");
$stmt->execute();

$data = $stmt->fetchALL(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);