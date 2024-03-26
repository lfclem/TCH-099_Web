<?php
require_once __DIR__ . "/../../config.php";

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No id provided']);
    exit;
}

$id = $_GET['id'];

try {
    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT photo_profil FROM Profil WHERE id_profil = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (!$user) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    if (empty($user['photo_profil'])) {
        $user['photo_profil'] = '';
    }

    echo json_encode(['photo' => $user['photo_profil']]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
