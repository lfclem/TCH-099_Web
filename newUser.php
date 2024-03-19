<?php

$_SESSION['error_message'] = "";

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
        $_SESSION['error_message'] = "Cet email est déjà utilisé.";
    } else {
        $stmt = $db->prepare('SELECT * FROM Profil WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $_SESSION['error_message'] = "Ce nom d'utilisateur est déjà pris.";
        } else if (!filter_var($emailNettoye, FILTER_SANITIZE_EMAIL)) {
            $_SESSION['error_message'] = "Email non valide";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $db->prepare('INSERT INTO Profil (username, email, password, info_paiement, date_naissance, photo_profil, statut, adresse, montant_balance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            if ($stmt->execute([$username, $emailNettoye, $passwordHash, $info_paiement, $date_naissance, $photo_profil, $statut, $adresse, $montant_balance])) {
                $_SESSION['error_message'] = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
                header("Location: /login");
            } else {
                $_SESSION['error_message'] = "Erreur lors de la création du compte.";
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
    <script src="/script.js"></script>
</head>

<body data-error-message="<?php echo isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '' ?>" data-reload="false">
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
</body>

</html>