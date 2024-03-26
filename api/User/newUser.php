<?php
require_once __DIR__ . "/../../config.php";

$_SESSION['error_message'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $emailNettoye = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST['password']);
    $info_paiement = htmlspecialchars($_POST['info_paiement']);
    $date_naissance = htmlspecialchars($_POST['date_naissance']);
    $photo_profil = filter_var($_POST['photo_profil'], FILTER_SANITIZE_URL);
    $statut = 1;
    $adresse = htmlspecialchars($_POST['adresse']);
    $montant_balance = 0;

    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT * FROM Profil WHERE email = ?');
    $stmt->execute([$emailNettoye]);
    if ($stmt->fetch()) {
        $_SESSION['error_message'] = "Cet email est déjà utilisé.";
        header("Location: ../../../../newUser");
    } else {
        $stmt = $db->prepare('SELECT * FROM Profil WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $_SESSION['error_message'] = "Ce nom d'utilisateur est déjà pris.";
            header("Location: ../../../../newUser");
        } else if (!filter_var($emailNettoye, FILTER_SANITIZE_EMAIL)) {
            $_SESSION['error_message'] = "Email non valide";
            header("Location: ../../../../newUser");
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $db->prepare('INSERT INTO Profil (username, email, password, info_paiement, date_naissance, photo_profil, statut, adresse, montant_balance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            if ($stmt->execute([$username, $emailNettoye, $passwordHash, $info_paiement, $date_naissance, $photo_profil, $statut, $adresse, $montant_balance])) {
                $_SESSION['error_message'] = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
                header("Location: ../../../../login");
            } else {
                $_SESSION['error_message'] = "Erreur lors de la création du compte.";
                header("Location: ../../../../newUser");
            }
        }
    }
}
