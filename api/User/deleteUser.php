<?php
require_once __DIR__ . "/../../config.php";

$db = Database::getInstance();
$stmt = $db->prepare('DELETE FROM Profil WHERE id_profil = ?');
$stmt->execute([$_SESSION['usager']]);
unset($_SESSION['usager']);
header('Location: /');
exit();