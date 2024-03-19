<?php
require './config.php';

$_SESSION['error_message'] = "";

if (isset($_GET['publicationId'])) {
    $_SESSION['publicationId'] = $_GET['publicationId'];
} else{
    //echo "pas de id_publication";
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT `titre`, `prix`, `description`, `image`, `id_categorie` FROM `Publication` WHERE `id_publication`=:id');
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

<body data-error-message="<?php echo $_SESSION['error_message'] ?>" data-reload="false">
    <header class="headerInfos">
        <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
        <h1 class="title">Sell-it!</h1>
        <div class="icons">
            <a href=""><img src="/IMG/messages.png" alt="Messages" /></a>
            <a href=""><img src="/IMG/cart.png" alt="Panier" /></a>
            <?php
            $photo_profil = $user['photo_profil'];
            ?>
            <?php if ($photo_profil) : ?>
                <a href=""><img class="pfp" src="<?php echo $photo_profil; ?>" alt="Photo_Profil" /></a>
            <?php else : ?>
                <a href=""><img class="pfp" src="/IMG/profil.png" alt="Profil" /></a>
            <?php endif; ?>
        </div>
    </header>

    <form method="POST" class="editUserGrid">
        <div class="pfp">
            <div>
                <?php
                $photo_profil = $user['photo_profil'];
                ?>
                <?php if ($photo_profil) : ?>
                    <img class="pfp" src="<?php echo $photo_profil; ?>" alt="Photo_Profil" />
                <?php else : ?>
                    <img class="pfp" src="/IMG/profil.png" alt="Profil" />
                <?php endif; ?>
            </div>

            <div>
                <label for="photo_profil">Photo de profil:</label>
                <input type="url" id="photo_profil" name="photo_profil" accept=".jpg, .png" value="<?php echo $user['photo_profil']; ?>">
            </div>
        </div>

        <div class="details">
            <div>
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>">
            </div>
            <div>
                <label for="email">Adresse email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>">
            </div>
            <div>
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse" value="<?php echo $user['adresse']; ?>">
            </div>

            <div class="bio">
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio"><?php echo $user['bio']; ?></textarea>
            </div>
            <div class="links">
                <a href="?deconnexion=1">Deconnecter</a>
                <a href="?delete=1" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le compte?');">Supprimer le compte</a>
            </div>
        </div>

        <div class="following"></div>
    </form>
</body>

</html>