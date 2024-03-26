<?php
require_once './config.php';
$error_message = $_SESSION['error_message'] ?? '';
$_SESSION['error_message'] = "";
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

<body data-error-message="<?php echo htmlspecialchars($error_message); ?>" data-reload="false">
    <header class="headerInfos">
        <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
        <h1 class="title">Sell-it!</h1>
        <div class="icons">
            <a href=""><img src="/IMG/profil.png" alt="Profil" /></a>
        </div>
    </header>

    <main class="newUser">
        <form method="POST" action="./api/User/newUser.php">
            <div>
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="email">Adresse email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="info_paiement">Numéro de votre carte bancaire:</label>
                <input type="number" id="info_paiement" name="info_paiement" required>
            </div>
            <div>
                <label for="date_naissance">Date de naissance:</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
            </div>
            <div>
                <label for="photo_profil">Photo de profil:</label>
                <input type="url" id="photo_profil" name="photo_profil" accept=".jpg, .png">
            </div>
            <div>
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse" required>
            </div>
            <div>
                <button type="submit">Créer le compte</button>
            </div>
            <div>
                <a href="/login">Se connecter à un compte</a>
            </div>
        </form>
    </main>
</body>

</html>