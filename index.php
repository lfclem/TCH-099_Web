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
      <?php if (isset($_SESSION['usager'])) : ?>
        <?php
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT photo_profil FROM Profil WHERE id_profil = ?');
        $stmt->execute([$_SESSION['usager']]);
        $user = $stmt->fetch();
        $photo_profil = $user['photo_profil'];
        ?>
        <a href=""><img class="pfp" src="<?php echo $photo_profil; ?>" alt="Profil" /></a>
      <?php else : ?>
        <a href="/login"><img class="pfp" src="/IMG/profil.png" alt="Profil" /></a>
      <?php endif; ?>
    </div>
  </header>

  <form method="GET" class="navbarOptions">
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
      <label for="minPrice">Prix minimal :</label>
      <input type="number" id="minPrice" name="minPrice" class="textMinPrice" placeholder="Entrez le prix minimal" />
    </div>

    <div>
      <label for="maxPrice">Prix maximal :</label>
      <input type="number" id="maxPrice" name="maxPrice" class="textMaxPrice" placeholder="Entrez le prix maximal" />
    </div>
  </form>

  <div method="GET" class="mainOptions">
    <div>
      <input type="text" class="textSearchbar" name="searchbar" placeholder="Rechercher..." />
      <button type="submit" class="buttonSearchbar">Rechercher</button>

      <label for="tab" class="labelChoiceTab">Onglet :</label>
      <select id="tab" name="tab" class="choiceTab">
        <option value="public">Publiques</option>
        <option value="following">Abonnements</option>
        <option value="self">Vos Publications</option>
      </select>
    </div>

    <button onclick="goToNewPub()" class="buttonAddListing">Créer une annonce</button>
  </div>
  
  <script>
    function goToNewPub() {
      window.location.href = '/newPublication.php';
    }
  </script>

  <main class="listingsContainer">

  </main>
</body>

</html>