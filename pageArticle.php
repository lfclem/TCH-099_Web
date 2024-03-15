<?php
require './config.php';


if (isset($_GET['publicationId'])) {
    $_SESSION['publicationId'] = $_GET['publicationId'];
} else{
    //echo "pas de id_publication";
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT `titre`, `prix`, `description`, `image`, `video`, `id_categorie` FROM `Publication` WHERE `id_publication`=:id');
    $stmt->bindParam(':id', $_SESSION['publicationId']);
    $stmt->execute();
    $pub = $stmt->fetch();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Sell-it!</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/style.css" />
  <link rel="stylesheet" href="/normalize.css" />
  <script src="/script.js"></script>
</head>
<body>
    <header class="headerInfos">
        <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
        <h1 class="title">Sell-it!</h1>
        <div class="icons">
        <?php if (isset($_SESSION['usager'])) : ?>
            <?php
            $db = Database::getInstance();
            $stmt = $db->prepare('SELECT photo_profil FROM Profil WHERE id_profil = ?');
            $stmt->execute([$_SESSION['usager']]);
            $user = $stmt->fetch();
            $photo_profil = $user['photo_profil'];
            if (!$photo_profil) {
                $photo_profil = "/IMG/profil.png";
            }
        ?>
        <a href=""><img src="/IMG/messages.png" alt="Messages" /></a>
        <a href=""><img src="/IMG/cart.png" alt="Panier" /></a>
        <a href="/editUser"><img class="pfp" src="<?php echo $photo_profil; ?>" alt="Profil" /></a>
        <?php else : ?>
            <a href="/login"><img class="pfp" src="/IMG/profil.png" alt="Profil" /></a>
        <?php endif; ?>
        </div>
    </header>

    <main class="pageArticle">
        <article class="article">
            <h2><?php echo $pub['titre']; ?></h2>
            <img src="<?php echo $pub['image']; ?>" alt="Article Image" class="center">
            <p><?php echo $pub['description']; ?></p>
            <p>Prix: <strong><?php echo $pub['prix']; ?></strong></p>
            <button>Contactez le vendeur</button>
        </article>
    </main>
</body>
</html>
