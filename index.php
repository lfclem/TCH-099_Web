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
  <script src="/script.js"></script>
</head>

<body class="grid">
  <header>
    <a href=""><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>

    <h1 class="titre">Sell-it!</h1>

    <div class="icons">
      <a href=""><img src="/IMG/messages.png" alt="Messages" /></a>
      <a href=""><img src="/IMG/cart.png" alt="Panier" /></a>
      <a href=""><img src="/IMG/notifications.png" alt="Notifications" /></a>
      <a href=""><img src="/IMG/profil.png" alt="Profil" /></a>
    </div>
  </header>

  <nav>
    <form action="/search" method="GET" class="navbar">
      <div>
        <input type="text" class="textSearchbar" name="searchbar" placeholder="Rechercher..." />
        <button type="submit" class="buttonSearchbar">Rechercher</button>
      </div>

      <div>
        <label for="category">Catégorie :</label>
        <select id="category" name="category" class="choiceCategory">
          <option value="all">Toutes les catégories</option>
          <option value="clothes">Vêtements</option>
          <option value="shoes">Chaussures</option>
          <option value="accessories">Accessoires</option>
          <option value="electronics">Électronique</option>
          <option value="books">Livres</option>
          <option value="furniture">Meubles</option>
          <option value="toys">Jouets</option>
          <option value="vehicles">Véhicules</option>
        </select>
      </div>

      <div>
        <label for="condition">État de l'objet :</label>
        <select id="condition" name="condition" class="choiceCondition">
          <option value="new">Neuf</option>
          <option value="used">Occasion</option>
          <option value="refurbished">Reconditionné</option>
        </select>
      </div>

      <div>
        <label for="maxPrice">Prix maximal :</label>
        <input type="number" id="maxPrice" name="maxPrice" class="textMaxPrice" placeholder="Entrez le prix maximal" />
      </div>

      <div>
        <label for="minPrice">Prix minimal :</label>
        <input type="number" id="minPrice" name="minPrice" class="textMinPrice" placeholder="Entrez le prix minimal" />
      </div>
    </form>
  </nav>

  <main></main>
</body>

</html>