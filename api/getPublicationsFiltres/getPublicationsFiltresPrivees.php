<?php

require_once "./config.php";

$db = Database::getInstance();

$sql = 'SELECT * FROM `Publication`';
$conditions = [];

if ($titre) {
    $conditions[] = '`titre` LIKE :titre';
}
if ($prixMin) {
    $conditions[] = '`prix` >= :prixMin';
}
if ($prixMax && $prixMax != 'Infinity') {
    $conditions[] = '`prix` <= :prixMax';
}
if ($id_etat && $id_etat != 1) {
    $conditions[] = '`id_etat` = :id_etat';
}
if ($id_categorie && $id_categorie != 1) {
    $conditions[] = '`id_categorie` = :id_categorie';
}

$conditions[] = '`id_profil` = :id_profil';

if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

$stmt = $db->prepare($sql);

if ($titre) {
    $titreParam = '%' . $titre . '%';
    $stmt->bindParam(':titre', $titreParam);
}
if ($prixMin) {
    $stmt->bindParam(':prixMin', $prixMin);
}
if ($prixMax && $prixMax != 'Infinity') {
    $stmt->bindParam(':prixMax', $prixMax);
}
if ($id_etat && $id_etat != 1) {
    $stmt->bindParam(':id_etat', $id_etat);
}
if ($id_categorie && $id_categorie != 1) {
    $stmt->bindParam(':id_categorie', $id_categorie);
}
$stmt->bindParam(':id_profil', $id_profil);

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
