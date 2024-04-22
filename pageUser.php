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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if the user_id is set in the GET data
    if (isset($_GET['user_id'])) {
        // Retrieve the value of user_id
        $id_profil = $_GET['user_id'];
        echo "<script>";
        echo "var id_profil = " . json_encode($id_profil) . ";";
        echo "</script>";

        echo "Visiting profile with id: " . $id_profil;
        echo "<br>";
        echo $_SESSION['usager'];
    }
}

$db = Database::getInstance();

// Prepare the SQL statement
$stmt = $db->prepare('SELECT `id_profil`,`username`, `email`, `date_naissance`, `photo_profil`, `bio`, `statut`, `adresse`, `nb_rating`, `rating_total` FROM `Profil` WHERE `id_profil`=:id');

// Bind the id parameter to the user_id from the form
$stmt->bindParam(':id', $id_profil);

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
    <link rel="stylesheet" href="/style.css" />
    <link rel="stylesheet" href="/normalize.css" />
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

    <main class="viewUserGrid">
        <img src="<?php echo $user2['photo_profil'] ?>" alt="">

        <div class="profile-info">
            <h2><?php echo $user2['username']; ?></h2>
        </div>
        <div class="email-info">
            <h2 for="email">email : <?php echo $user2['email']; ?></h2>
        </div>
        <div class="adresse-info">
            <h3 for="adresse">Adresse : <?php echo $user2['adresse']; ?></h3>
        </div>

        <div class="rating-form">
            <form method="POST" action="/api/directUser">
                <label for="rating">Évaluation (1 - 5) : </label>
                <input type="number" id="rating" name="rating" step="0.5" min="1" max="5" required>
                <button type="submit" name="submit">Effectuer l'évaluation</button>
            </form>
        </div>
        <button type="button" onclick="Abonner()" id="abn" name=""></button>
    </main>
</body>

</html>