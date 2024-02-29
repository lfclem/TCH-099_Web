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
  <header class="headerInfos">
    <a href=""><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
    <h1 class="title">Sell-it!</h1>
    <div class="icons">
      <a href=""><img src="/IMG/messages.png" alt="Messages" /></a>
      <a href=""><img src="/IMG/cart.png" alt="Panier" /></a>
      <a href=""><img src="/IMG/notifications.png" alt="Notifications" /></a>
      <a href=""><img src="/IMG/profil.png" alt="Profil" /></a>
    </div>
  </header>

  <form action="" method="GET" class="navbarOptions">
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

  <form action="" method="GET" class="mainOptions">
    <div>
      <input type="text" class="textSearchbar" name="searchbar" placeholder="Rechercher..." />
      <button type="submit" class="buttonSearchbar">Rechercher</button>
    </div>
    <div>
      <label for="tab" class="labelChoiceTab">Onglet :</label>
      <select id="tab" name="tab" class="choiceTab">
        <option value="public">Publiques</option>
        <option value="following">Abonnements</option>
        <option value="self">Vos Publications</option>
      </select>
    </div>
    <button type="submit" class="buttonAddListing">Ajouter une annonce</button>
  </form>

  <main>
    <div class="listingsContainer">
      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Elegant Chair</h2>
        <p>Price: $99.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Cozy Sofa</h2>
        <p>Price: $249.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Vintage Desk</h2>
        <p>Price: $199.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Modern Lamp</h2>
        <p>Price: $39.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Rustic Table</h2>
        <p>Price: $149.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Luxury Ottoman</h2>
        <p>Price: $299.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Stylish Bookshelf</h2>
        <p>Price: $179.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Chic Coffee Table</h2>
        <p>Price: $129.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Minimalist Chair</h2>
        <p>Price: $79.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Contemporary Rug</h2>
        <p>Price: $199.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Elegant Dining Table</h2>
        <p>Price: $349.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Vintage Armchair</h2>
        <p>Price: $219.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Modern Side Table</h2>
        <p>Price: $69.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Rustic Bench</h2>
        <p>Price: $99.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Luxury Chandelier</h2>
        <p>Price: $499.99</p>
      </article>

      <article>
        <img src="/IMG/peter.jpg" alt="Placeholder" />
        <h2>Stylish Ottoman</h2>
        <p>Price: $179.99</p>
      </article>

    </div>
  </main>
</body>

</html>