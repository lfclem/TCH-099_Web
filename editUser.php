<?php
require './config.php';

$_SESSION['error_message'] = "";

$db = Database::getInstance();
$stmt = $db->prepare('SELECT * FROM Profil WHERE id_profil = ?');
$stmt->execute([$_SESSION['usager']]);
$user = $stmt->fetch();

$balance = $user['montant_balance'];
$nbRatings = $user['nb_rating'];
$ratingTotal = $user['rating_total'];

$averageRating = ($nbRatings > 0) ? round($ratingTotal / $nbRatings * 2) / 2 : 0.0;


if (isset($_GET['deconnexion'])) {
    unset($_SESSION['usager']);
    header('Location: /');
    exit();
}

if (isset($_GET['delete'])) {
    $db = Database::getInstance();
    $stmt = $db->prepare('DELETE FROM Profil WHERE id_profil = ?');
    $stmt->execute([$_SESSION['usager']]);
    unset($_SESSION['usager']);
    header('Location: /');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $emailNettoye = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST['password']);
    $info_paiement = htmlspecialchars($_POST['info_paiement']);
    $photo_profil = filter_var($_POST['photo_profil'], FILTER_SANITIZE_URL);
    $adresse = htmlspecialchars($_POST['adresse']);
    $bio = htmlspecialchars($_POST['bio']);

    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT * FROM Profil WHERE email = ?');
    $stmt->execute([$emailNettoye]);
    if ($stmt->fetch() && $emailNettoye != $user['email']) {
        $_SESSION['error_message'] = "Cet email est déjà utilisé.";
    }

    $stmt = $db->prepare('SELECT * FROM Profil WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch() && $username != $user['username']) {
        $_SESSION['error_message'] = "Ce nom d'utilisateur est déjà utilisé.";
    }

    if (!filter_var($emailNettoye, FILTER_SANITIZE_EMAIL)) {
        $_SESSION['error_message'] = "Email non valide";
    }

    if ($_POST['password'] != "") {
        $password = htmlspecialchars($_POST['password']);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare('UPDATE Profil SET username = ?, email = ?, password = ?, info_paiement = ?, photo_profil = ?, adresse = ?, bio = ? WHERE id_profil = ?');
        if ($stmt->execute([$username, $emailNettoye, $passwordHash, $info_paiement, $photo_profil, $adresse, $bio, $_SESSION['usager']])) {
            $_SESSION['error_message'] = "Informations modifiées avec succès.";
            $stmt = $db->prepare('SELECT * FROM Profil WHERE id_profil = ?');
            $stmt->execute([$_SESSION['usager']]);
            $user = $stmt->fetch();
        } else {
            $_SESSION['error_message'] = "Erreur lors de la modification des informations.";
        }
    } else {
        $stmt = $db->prepare('UPDATE Profil SET username = ?, email = ?, info_paiement = ?, photo_profil = ?, adresse = ?, bio = ? WHERE id_profil = ?');
        if ($stmt->execute([$username, $emailNettoye, $info_paiement, $photo_profil, $adresse, $bio, $_SESSION['usager']])) {
            $_SESSION['error_message'] = "Informations modifiées avec succès.";
            $stmt = $db->prepare('SELECT * FROM Profil WHERE id_profil = ?');
            $stmt->execute([$_SESSION['usager']]);
            $user = $stmt->fetch();
        } else {
            $_SESSION['error_message'] = "Erreur lors de la modification des informations.";
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
        <div class="column1">
            <div class="pfp">
                <?php
                $photo_profil = $user['photo_profil'];
                ?>
                <?php if ($photo_profil) : ?>
                    <img class="pfp" src="<?php echo $photo_profil; ?>" alt="Photo_Profil" />
                <?php else : ?>
                    <img class="pfp" src="/IMG/profil.png" alt="Profil" />
                <?php endif; ?>

                <label for="photo_profil">Photo de profil:</label>
                <input type="url" id="photo_profil" name="photo_profil" accept=".jpg, .png" value="<?php echo $user['photo_profil']; ?>">
            </div>

            <div class="rating">
                <?php for ($i = 0; $i < 5; $i++) : ?>
                    <?php if ($averageRating - $i >= 1) : ?>
                        <img src="/IMG/filled_star.png" alt="Star" />
                    <?php elseif ($averageRating - $i > 0) : ?>
                        <img src="/IMG/half_filled_star.png" alt="Star" />
                    <?php else : ?>
                        <img src="/IMG/empty_star.png" alt="Star" />
                    <?php endif; ?>
                <?php endfor; ?>
                <?php echo $nbRatings; ?> évaluations
            </div>

            <div class="balance">
                <h2>Solde:</h2>
                <h3><?php echo $balance; ?>$</h3>
            </div>
        </div>

        <div class="column2">
            <div>
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>">
            </div>
            <div>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password">
            </div>
            <div>
                <label for="email">Adresse email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>">
            </div>

            <div>
                <label for="info_paiement">Numéro de votre carte:</label>
                <input type="number" id="info_paiement" name="info_paiement" value="<?php echo $user['info_paiement']; ?>">
            </div>

            <div>
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse" value="<?php echo $user['adresse']; ?>">
            </div>

            <div class="bio">
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio"><?php echo $user['bio']; ?></textarea>
            </div>

            <button type="submit">Modifier mes informations</button>

            <div class="links">
                <a href="?deconnexion=1">Deconnecter</a>
                <a href="?delete=1" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le compte?');">Supprimer le compte</a>
            </div>
        </div>

        <div class="column3"></div>
    </form>
</body>

</html>