<?php
require_once __DIR__."/../../config.php";

$db = Database::getInstance();

if(!isset($id) || $id == ""){
    http_response_code(400);
    echo "L'id de la publication est obligatoire";
    exit;
}
try{
    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT `titre`, `prix`, `description`, `image`, `id_etat`, `id_categorie` FROM `Publication` WHERE `id_publication`=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $publication = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!$stmt->rowCount()){
        http_response_code(400);
        echo "Identifiant de la publication invalide.";
        exit;
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($publication);

} catch (PDOException $e){
    http_response_code(500);
    echo "Erreur lors de la suppression en BD: ".$e->getMessage();
}