<?php
require("./config.php");
if (isset($_GET['deconnexion'])) {
    unset($_SESSION['usager']);
    header('Location: /');
    exit();
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
            <a href=""><img src="/IMG/messages.png" alt="Messages" /></a>
            <a href=""><img src="/IMG/cart.png" alt="Panier" /></a>
            <?php
            $db = Database::getInstance();
            $stmt = $db->prepare('SELECT photo_profil FROM Profil WHERE id_profil = ?');
            $stmt->execute([$_SESSION['usager']]);
            $user = $stmt->fetch();
            $photo_profil = $user['photo_profil'];
            ?>
            <?php if ($photo_profil) : ?>
                <a href=""><img class="pfp" src="<?php echo $photo_profil; ?>" alt="Photo_Profil" /></a>
            <?php else : ?>
                <a href=""><img class="pfp" src="/IMG/profil.png" alt="Profil" /></a>
            <?php endif; ?>
        </div>
    </header>

    <main class="editUser">
        <a href="?deconnexion=1">Deconnecter</a>
        <form method="POST">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username">

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password">

            <label for="email">Adresse email:</label>
            <input type="email" id="email" name="email">

            <label for="info_paiement">Numéro de votre carte:</label>
            <input type="number" id="info_paiement" name="info_paiement">

            <label for="photo_profil">Photo de profil:</label>
            <input type="url" id="photo_profil" name="photo_profil" accept=".jpg, .png">

            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse">

            <label for="bio">Bio:</label>
            <input type="text" id="bio" name="bio">

            <button type="submit">Créer le compte</button>
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