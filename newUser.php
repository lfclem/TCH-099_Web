<?php
$error_message = "";

require_once "./config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $emailNettoye = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST['password']);
    $info_paiement = htmlspecialchars($_POST['info_paiement']);
    $date_naissance = htmlspecialchars($_POST['date_naissance']);
    $photo_profil = filter_var($_POST['photo_profil'], FILTER_SANITIZE_URL);
    $statut = 1;
    $adresse = htmlspecialchars($_POST['adresse']);
    $montant_balance = 0;

    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT * FROM Profil WHERE email = ?');
    $stmt->execute([$emailNettoye]);
    if ($stmt->fetch()) {
        $error_message = "Cet email est déjà utilisé.";
    } else {
        $stmt = $db->prepare('SELECT * FROM Profil WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error_message = "Ce nom d'utilisateur est déjà pris.";
        } else if (!filter_var($emailNettoye, FILTER_SANITIZE_EMAIL)) {
            $error_message = "Email non valide";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $db->prepare('INSERT INTO Profil (username, email, password, info_paiement, date_naissance, photo_profil, statut, adresse, montant_balance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            if ($stmt->execute([$username, $emailNettoye, $passwordHash, $info_paiement, $date_naissance, $photo_profil, $statut, $adresse, $montant_balance])) {
                $error_message = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
            } else {
                $error_message = "Erreur lors de la création du compte.";
            }
        }
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

    <main class="newUser">
        <form method="POST">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <label for="email">Adresse email:</label>
            <input type="email" id="email" name="email" required>

            <label for="info_paiement">Numéro de votre carte:</label>
            <input type="number" id="info_paiement" name="info_paiement" required>

            <label for="date_naissance">Date de naissance:</label>
            <input type="date" id="date_naissance" name="date_naissance" required>

            <label for="photo_profil">Photo de profil:</label>
            <input type="url" id="photo_profil" name="photo_profil" accept=".jpg, .png">

            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" required>

            <button type="submit">Créer le compte</button>

            <a href="/login">Se connecter à un compte</a>
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