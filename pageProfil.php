<?php
require './config.php';

$db = Database::getInstance();
$stmt = $db->prepare('SELECT * FROM Profil WHERE id_profil = ?');
$stmt->execute([$_SESSION['usager']]);
$user = $stmt->fetch();

$statut = $user['statut'];
$balance = $user['montant_balance'];
$nbRatings = $user['nb_rating'];
$ratingTotal = $user['rating_total'];
$averageRating = ($nbRatings > 0) ? round($ratingTotal / $nbRatings * 2) / 2 : 0.0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sell-it!</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/style.css" />
    <link rel="stylesheet" href="/normalize.css" />
    <script src="/scriptAbonnement.js"></script>
</head>

<body data-error-message="<?php echo $_SESSION['error_message'] ?>" data-reload="false">
    <header class="headerInfos">
        <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
        <h1 class="title">Sell-it!</h1>
        <div class="icons">
            <a href=""><img src="/IMG/messages.png" alt="Messages" /></a>
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

    <form method="POST" action="./api/User/editUser.php" class="editUserGrid">
        <div class="column1">
            <div class="balance">
                <label>Votre solde: <?php echo $balance; ?>$</label>
                <div class="btn_balance">
                    <a href="">Ajouter</a>
                    <a href="">Retirer</a>
                </div>
            </div>
            <div class="rating">
                <label>Vos Évaluations (<?php echo $nbRatings; ?>):</label>
                <div>
                    <?php for ($i = 0; $i < 5; $i++) : ?>
                        <?php if ($averageRating - $i >= 1) : ?>
                            <img src="/IMG/filled_star.png" alt="Star" />
                        <?php elseif ($averageRating - $i > 0) : ?>
                            <img src="/IMG/half_filled_star.png" alt="Star" />
                        <?php else : ?>
                            <img src="/IMG/empty_star.png" alt="Star" />
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="level">
                <label>Votre statut: <?php echo $statut ?></label>
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
                <label for="photo_profil">Photo de profil:</label>
                <input type="url" id="photo_profil" name="photo_profil" accept=".jpg, .png" value="<?php echo $user['photo_profil']; ?>">
            </div>
            <div>
                <label for="info_paiement">Numéro de votre carte bancaire:</label>
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
                <a href="./api/User/logoutUser.php">Deconnecter</a>
                <a href="./api/User/deleteUser.php" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le compte?');">Supprimer le compte</a>
            </div>
        </div>

        <div class="column3"></div>
    </form>
</body>

</html>