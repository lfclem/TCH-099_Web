<?php
require_once __DIR__."/../../config.php";


$db = Database::getInstance();

if(!isset($_SERVER["CONTENT_TYPE"]) || $_SERVER["CONTENT_TYPE"]!='application/json'){
    http_response_code(400);
    exit;
}

//Obtenir le corps de la requête
$body = json_decode(file_get_contents("php://input"));

if(!isset($body->titre) || $body->titre == ""){
    http_response_code(400);
    echo "Le titre est obligatoire";
    exit;
}

if(!isset($body->prix) || $body->prix == ""){
    http_response_code(400);
    echo "Le prix est obligatoire";
    exit;
}

if(!isset($body->image) || $body->image == ""){
    http_response_code(400);
    echo "L'url de l'imgae est obligatoire";
    exit;
}

if(!isset($body->id_categorie) || $body->id_categorie == ""){
    http_response_code(400);
    echo "L'id de la categorie est obligatoire";
    exit;
}

if(!isset($body->id_publication) || $body->id_publication == ""){
    http_response_code(400);
    echo "L'id est obligatoire";
    exit;
}

try{
    $stmt = $db->prepare("INSERT INTO `Publication` (`titre`, `prix`, `description`, `image`, `video`, `id_profil`, `id_categorie`) VALUES (:titre, :prix, :descriptions, :img, :vid, :id_p, :id_cat)");
    //$stmt->bindValue(":id_pub", $body->id_publication);
    $stmt->bindValue(":titre", $body->titre);
    $stmt->bindValue(":prix", $body->prix);
    $stmt->bindValue(":descriptions", $body->description);
    $stmt->bindValue(":img", $body->image);
    $stmt->bindValue(":vid", $body->video);
    $stmt->bindValue(":id_p", $body->id_profil);
    $stmt->bindValue(":id_cat", $body->id_categorie);
    $stmt->execute();

    $id = $db->lastInsertId();


    $insertion = ["id_publication"=>$id, "titre"=>$body->titre, "prix"=>$body->prix, "img"=>$body->image];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($insertion);

} catch (PDOException $e){
    http_response_code(500);
    echo "Erreur lors de l'insertion en BD: ".$e->getMessage();
}