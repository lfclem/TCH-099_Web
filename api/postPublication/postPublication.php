<?php
require_once __DIR__ . "/../../config.php";



if (isset($_SESSION['usager'])) {
    $db = Database::getInstance();

    if (!isset($_SERVER["CONTENT_TYPE"]) || $_SERVER["CONTENT_TYPE"] != 'application/json') {
        http_response_code(400);
        exit;
    }

    //Obtenir le corps de la requête
    $body = json_decode(file_get_contents("php://input"));

    if (!isset($body->titre) || $body->titre == "") {
        http_response_code(400);
        echo "Le titre est obligatoire";
        exit;
    }

    if (!isset($body->prix) || $body->prix == "") {
        http_response_code(400);
        echo "Le prix est obligatoire";
        exit;
    }

    if (!isset($body->image) || $body->image == "") {
        http_response_code(400);
        echo "L'url de l'imgae est obligatoire";
        exit;
    }

    if (!isset($body->id_categorie) || $body->id_categorie == "") {
        http_response_code(400);
        echo "L'id de la categorie est obligatoire";
        exit;
    }

    if (!isset($body->id_etat) || $body->id_etat == "") {
        http_response_code(400);
        echo "L'id de l'etat est obligatoire";
        exit;
    }

    try {
        $stmt = $db->prepare("INSERT INTO `Publication` (`titre`, `prix`, `description`, `image`, `id_etat`, `id_categorie`, `id_profil`) VALUES (:titre, :prix, :descriptions, :img, :id_etat, :id_cat, :id_p)");
        $stmt->bindValue(":titre", $body->titre);
        $stmt->bindValue(":prix", $body->prix);
        $stmt->bindValue(":descriptions", $body->description);
        $stmt->bindValue(":img", $body->image);
        $stmt->bindValue(":id_etat", $body->id_etat);
        $stmt->bindValue(":id_p", $body->id_profil);
        $stmt->bindValue(":id_cat", $body->id_categorie);
        $stmt->execute();

        $id = $db->lastInsertId();


        $insertion = ["id_publication" => $id, "titre" => $body->titre, "prix" => $body->prix, "img" => $body->image];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($insertion);
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Erreur lors de l'insertion en BD: " . $e->getMessage();
    }
} else {
    http_response_code(401);
    echo "Vous devez être connecté pour effectuer cette action.";
}
