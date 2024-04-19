<?php
require_once __DIR__ . "/../../config.php";

$_SESSION['error_message'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST['rating'];

    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT `nb_rating`, `rating_total` FROM Profil WHERE id_profil = :id_profil');
    $stmt->bindParam(':id_profil', $user2['id_profil']);
    $stmt->execute();
    $user = $stmt->fetch();

    $rating_total = isset($user2['rating_total']) ? $user2['rating_total'] : 0;
    $nb_rating = isset($user2['nb_rating']) ? $user2['nb_rating'] : 0;
    $rating_totalApres = 0;
    $nb_ratingApres = 0;
    $rating_totalApres = $rating_total + $_POST['rating'];
    $nb_ratingApres = $nb_rating + 1;
    $rating_total = isset($_POST['rating_totalApres']) ? htmlspecialchars($_POST['rating_totalApres']) : $rating_total;
    $nb_rating = isset($_POST['nb_ratingApres']) ? htmlspecialchars($_POST['nb_ratingApres']) : $nb_rating;
}
 