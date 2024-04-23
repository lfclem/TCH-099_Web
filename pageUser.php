<?php
require './config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id'])) {
        $id_profil = $_POST['user_id'];
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['user_id'])) {
        $id_profil = $_GET['user_id'];
    }
}

$db = Database::getInstance();
$stmt = $db->prepare('SELECT * FROM `Profil` WHERE `id_profil`=:id');
$stmt->bindParam(':id', $id_profil);
$stmt->execute();
$user2 = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user2['nb_rating'] != 0) {
    $rating = $user2['rating_total'] / $user2['nb_rating'];
    $rating = round($rating * 2) / 2;
} else {
    $rating = 0;
}
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
    <script>
        var userID = "<?php echo isset($_SESSION['usager']) ? $_SESSION['usager'] : 0; ?>";
    </script>
    <script>
        var id_profil = <?php echo json_encode($id_profil); ?>;
    </script>
    <script src="/userPhoto.js"></script>
    <script src="/getPublications.js"></script>
</head>

<body>
    <header class="headerInfos">
        <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
        <h1 class="title">Sell-it!</h1>
        <div class="icons">
            <a id="linkPfp" href="">
                <img class="pfp" src="" alt="Profil" id="photoProfil" />
            </a>
        </div>
    </header>

    <main class="viewUserGrid">
        <div class="userInfo">
            <img src="<?php echo $user2['photo_profil'] ?>" alt="">

            <div>
                <h1><?php echo $user2['username']; ?></h1>
            </div>
            <div>
                <h3 for="email">Email : <?php echo $user2['email']; ?></h3>
            </div>
            <div>
                <h3 for="adresse">Adresse : <?php echo $user2['adresse']; ?></h3>
            </div>
            <div class="rating">
                <h3>Rating (<?php echo $user2['nb_rating']; ?>) : </h3>
                <div class="stars">
                    <?php
                    $fullStars = floor($rating);
                    $halfStar = $rating - $fullStars > 0 ? 1 : 0;
                    $emptyStars = 5 - $fullStars - $halfStar;

                    for ($i = 0; $i < $fullStars; $i++) {
                        echo '<img src="./IMG/filled_star.png">';
                    }

                    for ($i = 0; $i < $halfStar; $i++) {
                        echo '<img src="./IMG/half_filled_star.png">';
                    }

                    for ($i = 0; $i < $emptyStars; $i++) {
                        echo '<img src="./IMG/empty_star.png">';
                    }
                    ?>
                    </div>
            </div>
            <?php
            if (isset($_SESSION['usager'])) {
            ?>
                <form method="POST" action="/api/rating">
                    <label for="rating">Évaluation (1 - 5) : </label>
                    <input type="number" id="rating" name="rating" step="0.5" min="1" max="5" required>
                    <input type="hidden" name="user_id" value="<?php echo $user2['id_profil']; ?>">
                    <button type="submit" name="submit">Effectuer l'évaluation</button>
                </form>

            <?php
            }
            ?>
            <button type="button" onclick="Abonner()" id="abn" name=""></button>
        </div>
        <div class="userPublications">

        </div>
    </main>
</body>

</html>