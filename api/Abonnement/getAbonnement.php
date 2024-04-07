<?php
require_once __DIR__."/../../config.php";

$db = Database::getInstance();
if(!isset($id_abonne) || $id_abonne == ""){
    http_response_code(400);
    echo "L'id l'abonne est obligatoire";
    exit;
}
if(!isset($id_profil) || $id_profil == ""){
    http_response_code(400);
    echo "L'id du profil est obligatoire";
    exit;
}
try{
    $db = Database::getInstance();
    $msg_fav = "Abonner";
    $name_fav = "add_abonne";
    $stmt = $db->prepare('SELECT `id_profil`, `id_abonne` FROM `Profil_Abonnements` WHERE `id_profil`=:id_profil AND `id_abonne`=:id');
    $stmt->bindParam(':id_profil', $id_profil);
    $stmt->bindParam(':id', $id_abonne);
    $stmt->execute();
    $fav = $stmt->fetch();
    if(!empty($fav)){
        $msg_fav = "Desabonner";
        $name_fav = "delete_abonne";
    }
    $data = array(
        'msg' => $msg_fav,
        'name' => $name_fav,
    );

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);

} catch (PDOException $e){
    http_response_code(500);
    echo "Erreur lors de la suppression en BD: ".$e->getMessage();
}