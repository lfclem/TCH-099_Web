<?php
require_once __DIR__."/../../config.php";


$db = Database::getInstance();

if(!isset($id_profil) || $id_profil == ""){
    http_response_code(400);
    echo "L'id du profil est obligatoire";
    exit;
}
if(!isset($id_pub) || $id_pub == ""){
    http_response_code(400);
    echo "L'id de la publication est obligatoire";
    exit;
}
try{
    $db = Database::getInstance();
    $stmt = $db->prepare('DELETE FROM Publication_Favoris WHERE `id_profil`=:id_profil AND `id_publication`=:id');
    $stmt->bindParam(':id_profil', $id_profil);
    $stmt->bindParam(':id', $id_pub);
    $stmt->execute();

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