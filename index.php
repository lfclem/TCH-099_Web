<?php
session_start();
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
    <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
    <h1 class="title">Sell-it!</h1>
    <div class="icons">
      <a href=""><img src="/IMG/messages.png" alt="Messages" /></a>
      <a href="<?php echo isset($_SESSION['usager']) ? './profil' : './login'; ?>">
        <img class="pfp" src="/IMG/profil.png" alt="Profil" id="photoProfil" />
      </a>
    </div>
  </header>

  <form method="GET" class="navbarOptions">
    <div>
      <label for="category">Catégorie :</label>
      <select id="category" name="category" class="choiceCategory">
      </select>
    </div>

    <div>
      <label for="condition">État de l'objet :</label>
      <select id="condition" name="condition" class="choiceCondition">
      </select>
    </div>

    <div>
      <label for="minPrice">Prix minimal :</label>
      <input type="number" id="minPrice" name="minPrice" class="textMinPrice" />
    </div>

    <div>
      <label for="maxPrice">Prix maximal :</label>
      <input type="number" id="maxPrice" name="maxPrice" class="textMaxPrice" />
    </div>
  </form>

  <div method="GET" class="mainOptions">
    <div>
      <input type="text" class="textSearchbar" name="searchbar" placeholder="Rechercher..." />
      <button type="submit" class="buttonSearchbar">Rechercher</button>

      <?php if (isset($_SESSION['usager'])) : ?>
        <label for="tab" class="labelChoiceTab">Onglet :</label>
        <select id="tab" name="tab" class="choiceTab">
        </select>
      <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['usager'])) : ?>
      <a href="/newPublication" class="buttonAddListing">Créer une annonce</a>
    <?php endif; ?>
  </div>
  <main class="listingsContainer"></main>
</body>

</html>