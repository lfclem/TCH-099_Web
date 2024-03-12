<?php
require("./config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sell-it!</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/style.css" />
  <link rel="stylesheet" href="/normalize.css" />
  <script src="/scriptNewPublication.js"></script>
</head>

<body>
<header class="headerInfos">
    <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
    <h1 class="title">Sell-it!</h1>
    <div class="icons">
      <?php if (isset($_SESSION['usager'])) : ?>
        <?php
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT photo_profil FROM Profil WHERE id_profil = ?');
        $stmt->execute([$_SESSION['usager']]);
        $user = $stmt->fetch();
        $photo_profil = $user['photo_profil'];
        if (!$photo_profil) {
          $photo_profil = "/IMG/profil.png";
        }
        ?>
        <a href=""><img src="/IMG/messages.png" alt="Messages" /></a>
        <a href=""><img src="/IMG/cart.png" alt="Panier" /></a>
        <a href="/editUser"><img class="pfp" src="<?php echo $photo_profil; ?>" alt="Profil" /></a>
      <?php else : ?>
        <a href="/login"><img class="pfp" src="/IMG/profil.png" alt="Profil" /></a>
      <?php endif; ?>
    </div>
  </header>
  <main class="newPublicationsw">
        <section id="nouvellePublications" class="newPublications">
            <h2>Créer une Publication</h2>
            <form method="post">
                <div class="form-group">
                    <label for="titre">Title:</label>
                    <input type="text" id="titre" name="titre" class="form-control" required placeholder="Entrez le titre de votre publication" />
                </div>

                <div class="form-group">
                  <label for="prix">Price:</label>
                  <input type="number" id="prix" name="prix" class="form-control" required placeholder="Entrez le prix de votre publication"/>
                </div>

                <div class="form-group">
                  <label for="description">Description:</label>
                  <input type="text" id="description" name="description" placeholder="Entrez une description de votre publication" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="video">Video:</label>
                    <input type="url" id="video" name="video"  placeholder="Entrez le lien de la vidéo de votre publication" class="form-control" />
                </div>

                <div class="form-group image-upload">
                    <label for="img">Image:</label>
                    <input type="url" id="img" name="img" class="form-control" accept="image/*" required />
                </div>

                <div class="form-group">
                  <label for="categories">Categories:</label>
                  <select name="categories" id="categories" required>
                    <option value="" disabled selected>Choisissez une catégorie</option>
                    <option value="vetement">Vêtements</option>
                    <option value="chaussures">Chaussures</option>
                    <option value="accessoires">Accessoires</option>
                    <option value="electroniques">Électroniques</option>
                    <option value="livres">Livres</option>
                    <option value="meubles">Meubles</option>
                    <option value="jouets">Jouets</option>
                    <option value="vehicules">Véhicules</option>
                  </select>
            </div>

                <button type="button" onclick="newPub()" id="creerPub">Créer</button>


            </form>
        </section>
    </main>
</body>