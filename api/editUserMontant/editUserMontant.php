<?php
require_once __DIR__."/../../config.php";


$db = Database::getInstance();

if(!isset($_SERVER["CONTENT_TYPE"]) || $_SERVER["CONTENT_TYPE"]!='application/json'){
    http_response_code(400);
    exit;
}

//Obtenir le corps de la requête
$body = json_decode(file_get_contents("php://input"));

if(!isset($id) || $id == ""){
    http_response_code(400);
    echo "L'id de la publication est obligatoire";
    exit;
}

if(!isset($body) || $body == ""){
    http_response_code(400);
    echo $body->titre;
    echo "Le titre est obligatoire";
    exit;
}

try{
    $stmt = $db->prepare('UPDATE Profil SET montant_balance = ?WHERE id_profil = ?');
    $stmt->execute([$body,$id]);


    $insertion = ["reponse"=>"OK"];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($insertion);

} catch (PDOException $e){
    http_response_code(500);
    echo "Erreur lors de l'insertion en BD: ".$e->getMessage();
}