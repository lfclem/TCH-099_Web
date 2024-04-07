<?php
require_once __DIR__."/../../config.php";


$db = Database::getInstance();

if(!isset($id_profil) || $id_profil == ""){
    http_response_code(400);
    echo "L'id du profil est obligatoire";
    exit;
}
if(!isset($id_abonne) || $id_abonne == ""){
    http_response_code(400);
    echo "L'id de l'abonne est obligatoire";
    exit;
}
try{
    $db = Database::getInstance();
    $stmt = $db->prepare('DELETE FROM Profil_Abonnements WHERE `id_profil`=:id_profil AND `id_abonne`=:id');
    $stmt->bindParam(':id_profil', $id_profil);
    $stmt->bindParam(':id', $id_abonne);
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