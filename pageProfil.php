<?php
require_once './config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sell-it!</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/style.css" />
    <link rel="stylesheet" href="/normalize.css" />
    <script>
        var user = "<?php echo $_SESSION['usager']; ?>";
    </script>
    <script src="/userPhoto.js"></script>
    <script src="/scriptFetchUserData.js"></script>
</head>

<body data-error-message="<?php echo $_SESSION['error_message'] ?>" data-reload="false">
    <header class="headerInfos">
        <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
        <h1 class="title">Sell-it!</h1>
        <div class="icons">
            <a href=""><img class="pfp" src="" alt="Photo_Profil" id="photoProfil" /></a>
        </div>
    </header>

    <form method="POST" action="./api/User/editUser.php" class="editUserGrid">
        <div class="column1">
            <div class="balance">
                <label id="balance">Votre solde: </label>
                <div class="btn_balance">
                    <a href="">Ajouter</a>
                    <a href="">Retirer</a>
                </div>
            </div>
            <div class="rating">
                <label id="rating">Vos Évaluations:</label>
                <div id="stars">
                </div>
            </div>
        </div>

        <div class="column2">
            <div>
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username">
            </div>
            <div>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password">
            </div>
            <div>
                <label for="email">Adresse email:</label>
                <input type="email" id="email" name="email">
            </div>
            <div>
                <label for="photo_profil">Photo de profil:</label>
                <input type="url" id="photo_profil" name="photo_profil" accept=".jpg, .png">
            </div>
            <div>
                <label for="info_paiement">Numéro de votre carte bancaire:</label>
                <input type="number" id="info_paiement" name="info_paiement">
            </div>
            <div>
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse">
            </div>
            <div class="bio">
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio"></textarea>
            </div>
            <button type="submit">Modifier mes informations</button>
            <div class="links">
                <a href="./api/User/logoutUser.php">Deconnecter</a>
                <a href="./api/User/deleteUser.php" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le compte?');">Supprimer le compte</a>
            </div>
        </div>

        <div class="column3">

            <h1>Mes Abonnements</h1>
            <ul>
            </ul>
        </div>
    </form>
</body>

</html>