<?php
require_once __DIR__ . "/../../config.php";

if (isset($_SESSION['usager'])) {
    $_SESSION['error_message'] = "";

    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT * FROM Profil WHERE id_profil = ?');
    $stmt->execute([$_SESSION['usager']]);
    $user = $stmt->fetch();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = htmlspecialchars($_POST['username']);
        $emailNettoye = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars($_POST['password']);
        $info_paiement = htmlspecialchars($_POST['info_paiement']);
        $photo_profil = filter_var($_POST['photo_profil'], FILTER_SANITIZE_URL);
        $adresse = htmlspecialchars($_POST['adresse']);
        $bio = htmlspecialchars($_POST['bio']);

        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM Profil WHERE email = ?');
        $stmt->execute([$emailNettoye]);
        if ($stmt->fetch() && $emailNettoye != $user['email']) {
            $_SESSION['error_message'] = "Cet email est déjà utilisé.";
        }

        $stmt = $db->prepare('SELECT * FROM Profil WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch() && $username != $user['username']) {
            $_SESSION['error_message'] = "Ce nom d'utilisateur est déjà utilisé.";
        }

        if (!filter_var($emailNettoye, FILTER_SANITIZE_EMAIL)) {
            $_SESSION['error_message'] = "Email non valide";
        }

        if ($_POST['password'] != "") {
            $password = htmlspecialchars($_POST['password']);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare('UPDATE Profil SET username = ?, email = ?, password = ?, info_paiement = ?, photo_profil = ?, adresse = ?, bio = ? WHERE id_profil = ?');
            if ($stmt->execute([$username, $emailNettoye, $passwordHash, $info_paiement, $photo_profil, $adresse, $bio, $_SESSION['usager']])) {
                $_SESSION['error_message'] = "Informations modifiées avec succès.";
                $stmt = $db->prepare('SELECT * FROM Profil WHERE id_profil = ?');
                $stmt->execute([$_SESSION['usager']]);
                $user = $stmt->fetch();
                header('Location: ../../../../profil');
                exit();
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification des informations.";
            }
        } else {
            $stmt = $db->prepare('UPDATE Profil SET username = ?, email = ?, info_paiement = ?, photo_profil = ?, adresse = ?, bio = ? WHERE id_profil = ?');
            if ($stmt->execute([$username, $emailNettoye, $info_paiement, $photo_profil, $adresse, $bio, $_SESSION['usager']])) {
                $_SESSION['error_message'] = "Informations modifiées avec succès.";
                $stmt = $db->prepare('SELECT * FROM Profil WHERE id_profil = ?');
                $stmt->execute([$_SESSION['usager']]);
                $user = $stmt->fetch();
                header('Location: ../../../../profil');
                exit();
            } else {
                $_SESSION['error_message'] = "Erreur lors de la modification des informations.";
            }
        }
    }
} else {
    http_response_code(401);
    echo "Vous devez être connecté pour effectuer cette action.";
}
