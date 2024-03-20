<?php
require("./config.php");

$db = Database::getInstance();
$stmt = $db->prepare('SELECT * FROM Categorie');
$stmt->execute();
$categorie = $stmt->fetchAll();

$stmt = $db->prepare('SELECT * FROM Onglet');
$stmt->execute();
$onglet = $stmt->fetchAll();

$stmt = $db->prepare('SELECT * FROM Etat');
$stmt->execute();
$etat = $stmt->fetchAll();
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
        <a href="/editUser"><img class="pfp" src="<?php echo $photo_profil; ?>" alt="Profil" /></a>
      <?php else : ?>
        <a href="/login"><img class="pfp" src="/IMG/profil.png" alt="Profil" /></a>
      <?php endif; ?>
    </div>
  </header>

  <form method="GET" class="navbarOptions">
    <div>
      <label for="category">Catégorie :</label>
      <select id="category" name="category" class="choiceCategory">
        <?php foreach ($categorie as $cat) : ?>
          <option value="<?php echo $cat['id_categorie']; ?>"><?php echo $cat['nom']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label for="condition">État de l'objet :</label>
      <select id="condition" name="condition" class="choiceCondition">
        <?php foreach ($etat as $et) : ?>
          <option value="<?php echo $et['id_etat']; ?>"><?php echo $et['nom']; ?></option>
        <?php endforeach; ?>
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
        <?php foreach ($onglet as $ong) : ?>
          <option value="<?php echo $ong['id_onglet']; ?>"><?php echo $ong['nom']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <?php if (isset($_SESSION['usager'])) : ?>
      <a href="/newPublication" class="buttonAddListing">Créer une annonce</a>
    <?php endif; ?>
  </div>
  <main class="listingsContainer"></main>
</body>
</html>