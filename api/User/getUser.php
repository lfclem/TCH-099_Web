<?php
require './config.php';

$db = Database::getInstance();
$stmt = $db->prepare('SELECT * FROM Profil WHERE id_profil = ?');
$stmt->execute([$_SESSION['usager']]);
$user = $stmt->fetch();

$statut = $user['statut'];
$balance = $user['montant_balance'];
$nbRatings = $user['nb_rating'];
$ratingTotal = $user['rating_total'];
$averageRating = ($nbRatings > 0) ? round($ratingTotal / $nbRatings * 2) / 2 : 0.0;
