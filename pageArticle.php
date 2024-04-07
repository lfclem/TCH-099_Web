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
      <a href=""><img src="/IMG/messages.png" alt="Messages" /></a>
      <a href="<?php echo isset($_SESSION['usager']) ? './profil' : './login'; ?>">
        <img class="pfp" src="/IMG/profil.png" alt="Profil" id="photoProfil" />
      </a>
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
                <button type="submit"  name="contact_seller">Contactez le vendeur</button>
            </form>
            <form method="post" action="/pageUser.php">
                <?php
                $db = Database::getInstance();
                $stmt = $db->prepare('SELECT id_profil FROM Publication WHERE id_publication = ?');
                $stmt->execute([$_SESSION['publicationId']]);
                $publication = $stmt->fetch();
                $id_profil = $publication['id_profil'];
                ?>
                <input type="hidden" name="user_id" value="<?php echo $id_profil; ?>">
                <button type="submit">Voir le profil du vendeur</button>
            </form>
        </article>
    </main>
</body>

</html>