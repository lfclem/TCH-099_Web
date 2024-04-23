<?php
require_once __DIR__ . "/../../config.php";

if (isset($_SESSION['usager'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $rating = $_POST['rating'];
        $user_id = $_POST['user_id'];
        $evaluator_id = $_SESSION['usager'];

        $db = Database::getInstance();

        $stmt = $db->prepare('SELECT * FROM Profil_Evaluation WHERE id_evaluateur = :evaluator_id AND id_evalue = :user_id');
        $stmt->bindParam(':evaluator_id', $evaluator_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $existingRating = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRating) {
            $stmt = $db->prepare('UPDATE Profil_Evaluation SET rating = :rating WHERE id_evaluateur = :evaluator_id AND id_evalue = :user_id');
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':evaluator_id', $evaluator_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $stmt = $db->prepare('UPDATE Profil SET rating_total = rating_total - :old_rating + :new_rating WHERE id_profil = :id');
            $stmt->bindParam(':old_rating', $existingRating['rating']);
            $stmt->bindParam(':new_rating', $rating);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
        } else {
            $stmt = $db->prepare('INSERT INTO Profil_Evaluation (id_evaluateur, id_evalue, rating) VALUES (:evaluator_id, :user_id, :rating)');
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':evaluator_id', $evaluator_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $stmt = $db->prepare('UPDATE Profil SET nb_rating = nb_rating + 1, rating_total = rating_total + :rating WHERE id_profil = :id');
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
        }
    }

    header("Location: /pageUser.php?user_id=$user_id");
    exit();
} else {
    http_response_code(401);
    echo "Vous devez être connecté pour effectuer cette action.";
}
