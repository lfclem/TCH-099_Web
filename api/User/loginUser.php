<?php
require_once __DIR__ . "/../../config.php";

$_SESSION['error_message'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT * FROM Profil WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usager'] = $user['id_profil'];
        header('Location: /');
    } else {
        $_SESSION['error_message'] = "Nom d'utilisateur ou mot de passe incorrect.";
        header('Location: ../../../../login');
    }
}
