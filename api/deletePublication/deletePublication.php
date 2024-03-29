<?php
require_once __DIR__."/../../config.php";


$db = Database::getInstance();

if(!isset($id) || $id == ""){
    http_response_code(400);
    echo "L'id de la publication est obligatoire";
    exit;
}
try{
    $stmt= $db->prepare('DELETE FROM `Publication` WHERE `id_publication`= ?');
    $stmt->execute([$id]);

    if(!$stmt->rowCount()){
        http_response_code(400);
        echo "Identifiant de la publication invalide.";
        exit;
    }
    $reponse = ["response"=>"OK"];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($reponse);

} catch (PDOException $e){
    http_response_code(500);
    echo "Erreur lors de la suppression en BD: ".$e->getMessage();
}