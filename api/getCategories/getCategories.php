<?php

require_once "./config.php";

$db = Database::getInstance();

$stmt = $db->prepare("SELECT * FROM `Categorie`");

$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
