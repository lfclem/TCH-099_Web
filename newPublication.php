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
    <a href=""><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
    <h1 class="title">Sell-it!</h1>
    <div class="icons">
      <a href='/index.php'><img class="exit" src="/IMG/exit.png" alt="Profil" /></a>
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
                    <input type="file" id="img" name="img" class="form-control" accept="image/*" required />
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