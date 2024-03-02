<?php
$error_message = "";

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
    } else {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
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
</head>

<body>
    <header class="headerInfos">
        <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
        <h1 class="title">Sell-it!</h1>
        <div class="icons">
            <a href=""><img src="/IMG/profil.png" alt="Profil" /></a>
        </div>
    </header>

    <main class="login">
        <form method="POST">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Se connecter</button>

            <a href="/newUser">Se créer un compte</a>
        </form>
    </main>
    <script>
        function showErrorMessage(message) {
            const modal = document.createElement("div");
            modal.style.position = "fixed";
            modal.style.zIndex = "1";
            modal.style.left = "0";
            modal.style.top = "0";
            modal.style.width = "100%";
            modal.style.height = "100%";
            modal.style.overflow = "auto";
            modal.style.backgroundColor = "rgba(0,0,0,0.4)";
            const modalContent = document.createElement("div");
            modalContent.style.backgroundColor = "#fefefe";
            modalContent.style.margin = "15% auto";
            modalContent.style.padding = "20px";
            modalContent.style.border = "1px solid #888";
            modalContent.style.width = "20%";
            modalContent.textContent = message;
            modal.appendChild(modalContent);
            document.body.appendChild(modal);
            setTimeout(function() {
                modal.remove();
            }, 2000);
        }

        <?php
        if ($error_message != "") {
            echo "showErrorMessage('$error_message');";
        }
        ?>
    </script>
</body>

</html>