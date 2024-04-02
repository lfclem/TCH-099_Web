<?php
require_once __DIR__."/../../config.php";


$db = Database::getInstance();

if(!isset($_SERVER["CONTENT_TYPE"]) || $_SERVER["CONTENT_TYPE"]!='application/json'){
    http_response_code(400);
    exit;
}

$body = json_decode(file_get_contents("php://input"));

if(!isset($body->id_profil) || $body->id_profil == ""){
    http_response_code(400);
    echo "L'id du profil est obligatoire";
    exit;
}

if(!isset($body->id_publication) || $body->id_publication == ""){
    http_response_code(400);
    echo "L'id de la publication est obligatoire";
    exit;
}

try{
    $db = Database::getInstance();
    $stmt = $db->prepare('INSERT INTO Publication_Favoris (id_profil, id_publication) VALUES (?, ?)');
    $stmt->execute([$body->id_profil, $body->id_publication]);

    $reponse = ["response"=>"OK"];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($reponse);

} catch (PDOException $e){
    http_response_code(500);
    echo "Erreur lors de l'insertion en BD: ".$e->getMessage();
}