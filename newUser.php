<?php

require_once "./config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $emailNettoye = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $info_paiement = htmlspecialchars($_POST['info_paiement']);
    $date_naissance = htmlspecialchars($_POST['date_naissance']);
    $photo_profil = htmlspecialchars($POST['photo_profil']);
    $statut = htmlspecialchars($_POST['statut']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $montant_balance = htmlspecialchars($_POST['montant_balance']);
    $id_parent = htmlspecialchars($POST['id_parent']);

    // Vérifier si l'utilisateur existe déjà
    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT * FROM Profil WHERE username = ?');
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        echo 'Ce nom d\'utilisateur est déjà pris.';
    } else if (!filter_var($emailNettoye, FILTER_SANITIZE_EMAIL)) {
        echo "Email non valide";
    } else {
        // Hasher le mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insérer le nouvel utilisateur
        $stmt = $db->prepare('INSERT INTO Profil (username, email, password, info_paiement, date_naissance, photo_profil, statut, adresse, montant_balance, id_parent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        if ($stmt->execute([$username, $emailNettoye, $password, $info_paiement, $date_naissance, $photo_profil, $statut, $adresse, $montant_balance, $id_parent])) {
            header("Location: login.php");
            exit;
        } else {
            echo 'Erreur lors de la création du compte.';
        }
    }
}