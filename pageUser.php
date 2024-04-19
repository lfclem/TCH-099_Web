<?php
require './config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user_id is set in the POST data
    if (isset($_POST['user_id'])) {
        // Retrieve the value of user_id
        $id_profil = $_POST['user_id'];
        echo "<script>";
        echo "var id_profil = " . json_encode($id_profil) . ";";
        echo "</script>";
    }
}
$db = Database::getInstance();

// Prepare the SQL statement
$stmt = $db->prepare('SELECT `id_profil`,`username`, `email`, `date_naissance`, `photo_profil`, `bio`, `statut`, `adresse`, `nb_rating`, `rating_total` FROM `Profil` WHERE `id_profil`=:id');

// Bind the id parameter to the user_id from the form
$stmt->bindParam(':id', $_POST['user_id']);

// Execute the statement
$stmt->execute();

// Fetch the user data
$user2 = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sell-it!</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/normalize.css" />
    <link rel="stylesheet" href="/style.css" />
    <script src="/scriptAbonnement.js"></script>
</head>

<body>
    <header class="headerInfos">
        <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
        <h1 class="title">Sell-it!</h1>
        <div class="icons">
            <a href=""><img src="/IMG/messages.png" alt="Messages" /></a>
            <a href="<?php echo isset($_SESSION['usager']) ? './profil' : './login'; ?>">
                <img class="pfp" src="/IMG/profil.png" alt="Profil" id="photoProfil" />
            </a>
        </div>
    </header>

    <div class="profile-info">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" value="<?php echo $user2['username']; ?>" readonly>
    </div>
    <div class="email-info">
        <label for="email">Adresse email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user2['email']; ?>" readonly>
    </div>
    <div class="photo-info">
        <label for="photo_profil">Photo de profil:</label>
        <input type="url" id="photo_profil" name="photo_profil" accept=".jpg, .png" value="<?php echo $user2['photo_profil']; ?>" readonly>
    </div>
    <div class="adresse-info">
        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" value="<?php echo $user2['adresse']; ?>" readonly>
    </div>

    <div class="rating-form">
        <form method="POST" action="/api/directUser">
            <label for="rating">Évaluation (0-5):</label>
            <input type="number" id="rating" name="rating" step="0.5" min="0" max="5" required>
            <button type="submit" name="submit">Effectuer l'évaluation</button>
        </form>
    </div>
    <button type="submit">Contacter</button>
    <button type="button" onclick="Abonner()" id="abn" name=""></button>
</body>

</html>