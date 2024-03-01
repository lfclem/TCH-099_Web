<?php
require_once './config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT * FROM Profil WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usager'] = $user['id_profil'];
        header('Location: /');
        exit;
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
        echo $error;
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
        <a href=""><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
        <h1 class="title">Sell-it!</h1>
        <div class="icons">
            <a href=""><img src="/IMG/profil.png" alt="Profil" /></a>
        </div>
    </header>

    <main>
        <div class="login">
            <form action="" method="POST">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Se connecter</button>

                <a href="/newUser">Se créer un compte</a>
            </form>
        </div>
    </main>
</body>

</html>