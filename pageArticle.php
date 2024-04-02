<?php
require './config.php';

$_SESSION['error_message'] = "";

if (isset($_GET['publicationId'])) {
    $_SESSION['publicationId'] = $_GET['publicationId'];
} else {
    //echo "pas de id_publication";
}



if(isset($_POST['contact_seller'])) {
    if (isset($_SESSION['usager'])){
        echo "chat";
    } else {
        header("Location: login.php");
        exit(); 
    }
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
    <script src="/scriptFavoris.js"></script>
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
                <a href="/editUser"><img class="pfp" src="<?php echo $photo_profil; ?>" alt="Profil" /></a>
            <?php else : ?>
                <a href="/login"><img class="pfp" src="/IMG/profil.png" alt="Profil" /></a>
            <?php endif; ?>
        </div>
    </header>

    <main class="pageArticle">
        <article class="article">
            <h2 id="titre"></h2>
            <img src="" alt="Article Image" class="center" id="image">
            <p id="description"></p>
            <p id="etat"></p>
            <p id="prix"></strong></p>
            <form method="post">
                <button type="submit" name="contact_seller">Contactez le vendeur</button>
            </form>
            <form method="post">
                <button type="button" onclick="favoris()" id="fav" name=""></button>
            </form>
        </article>
    </main>
</body>

</html>