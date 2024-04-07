<?php
require_once __DIR__ . "/../../config.php";

$db = Database::getInstance();
$stmt = $db->prepare('SELECT * FROM Profil WHERE id_profil = ?');
$stmt->execute([$_SESSION['usager']]);
$user = $stmt->fetch();

unset($_SESSION['usager']);
header('Location: ../../');
exit();
