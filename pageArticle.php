<?php
require './config.php';

$_SESSION['error_message'] = "";

if (isset($_GET['publicationId'])) {
    $_SESSION['publicationId'] = $_GET['publicationId'];
} else {
    //echo "pas de id_publication";
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT `titre`, `prix`, `description`, `image`, `id_etat`, `id_categorie` FROM `Publication` WHERE `id_publication`=:id');
    $stmt->bindParam(':id', $_SESSION['publicationId']);
    $stmt->execute();
    $pub = $stmt->fetch();

    $msg_fav = "Ajouter en favoris";
    $name_fav = "add_favorite";
    $stmt = $db->prepare('SELECT `id_profil`, `id_publication` FROM `Publication_Favoris` WHERE `id_profil`=:id_profil AND `id_publication`=:id');
    $stmt->bindParam(':id_profil', $_SESSION['usager']);
    $stmt->bindParam(':id', $_SESSION['publicationId']);
    $stmt->execute();
    $fav = $stmt->fetch();
    if(!empty($fav)){
        $msg_fav = "Enlever des favoris";
        $name_fav = "delete_favorite";
    }
}



if(isset($_POST['contact_seller'])) {
    if (isset($_SESSION['usager'])){
        echo "chat";
    } else {
        header("Location: login.php");
        exit(); 
    }
}

//ajouter en favoris
if(isset($_POST['add_favorite'])) {
    if (isset($_SESSION['usager'])){
        $db = Database::getInstance();
        $stmt = $db->prepare('INSERT INTO Publication_Favoris (id_profil, id_publication) VALUES (?, ?)');
        $stmt->execute([$_SESSION['usager'], $_SESSION['publicationId']]);
        header('Location: /');
    } else {
        header("Location: login.php");
        exit(); 
    }
}
//enlever des favoris
if(isset($_POST['delete_favorite'])) {
    if (isset($_SESSION['usager'])){
        $db = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM Publication_Favoris WHERE `id_profil`=:id_profil AND `id_publication`=:id');
        $stmt->bindParam(':id_profil', $_SESSION['usager']);
        $stmt->bindParam(':id', $_SESSION['publicationId']);
        $stmt->execute();
        header('Location: /');
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
            <p><?php echo $pub['id_etat']; ?></p>
            <p>Prix: <strong><?php echo $pub['prix']; ?></strong></p>
            <form method="post">
                <button type="submit" name="contact_seller">Contactez le vendeur</button>
            </form>
            <form method="post">
                <button type="submit" name="<?php echo $name_fav; ?>"><?php echo $msg_fav; ?></button>
            </form>
        </article>
    </main>
</body>

</html>