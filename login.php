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

    <main class="login">
        <form method="POST" action="./api/User/loginUser.php">
            <div>
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit">Se connecter</button>
            </div>
            <div>
                <a href="/newUser">Se créer un compte</a>
            </div>
        </form>
    </main>
</body>

</html>