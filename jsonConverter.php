<?php
// Connexion à la base de données
require_once 'config.php';

$db = Database::getInstance();

// Requête pour récupérer les profils
$stmtProfil = $db->prepare('SELECT * FROM Profil');
$stmtProfil->execute();
$profil = $stmtProfil->fetchAll(PDO::FETCH_ASSOC);

// Requête pour récupérer les catégories
$stmtCategories = $db->prepare('SELECT * FROM Categorie');
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

// Requête pour récupérer les publications
$stmtPub = $db->prepare('SELECT * FROM Publication');
$stmtPub->execute();
$publication = $stmtPub->fetchAll(PDO::FETCH_ASSOC);

// Requête pour récupérer les favoris
$stmtFav = $db->prepare('SELECT * FROM Publication_Favoris');
$stmtFav->execute();
$favoris = $stmtFav->fetchAll(PDO::FETCH_ASSOC);

//
// ajouter des requete si necessaire
//
$gUserId = isset($_SESSION["usager"]) ? $_SESSION["usager"] : 0;

$data = array(
    'publication' => $publication,
    'categories' => $categories,
    'profil' => $profil,
    'favoris' => $favoris,
    'usager' => $gUserId // Add the user type
);

// Conversion des données en format JSON et envoi
// header('Content-Type: application/json');
echo json_encode($data);
?>