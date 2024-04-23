<?php
require_once __DIR__ . "/../../config.php";


if (isset($_SESSION['usager'])) {
    $db = Database::getInstance();
    $stmt = $db->prepare('DELETE FROM Profil WHERE id_profil = ?');
    $stmt->execute([$_SESSION['usager']]);
    unset($_SESSION['usager']);
    header('Location: /');
    exit();
} else {
    http_response_code(401);
    echo "Vous devez être connecté pour effectuer cette action.";
}
