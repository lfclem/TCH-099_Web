<?php
require("./config.php");

$db = Database::getInstance();
$stmt = $db->prepare('SELECT * FROM Categorie WHERE id_categorie > 1');
$stmt->execute();
$categorie = $stmt->fetchAll();

$stmt = $db->prepare('SELECT * FROM Etat WHERE id_etat > 1');
$stmt->execute();
$etat = $stmt->fetchAll();


// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   $titre = htmlspecialchars($_POST['titre']);
//   $prix = htmlspecialchars($_POST['prix']);
//   $description = htmlspecialchars($_POST['description']);
//   $image = htmlspecialchars($_POST['image']);
//   $etat = htmlspecialchars($_POST['etat']);
//   $categorie = htmlspecialchars($_POST['categorie']);

//   $db = Database::getInstance();
//   $stmt = $db->prepare('INSERT INTO Publication (titre, prix, description, image, id_etat, id_categorie, id_profil) VALUES (?, ?, ?, ?, ?, ?, ?)');
//   $stmt->execute([$titre, $prix, $description, $image, $etat, $categorie, $_SESSION['usager']]);
//   header('Location: /');
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sell-it!</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/style.css" />
  <link rel="stylesheet" href="/normalize.css" />
  <script src="/scriptNewPub.js"></script>
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
        <a href="/editUser"><img class="pfp" src="<?php echo $photo_profil; ?>" alt="Profil" /></a>
      <?php else : ?>
        <a href="/login"><img class="pfp" src="/IMG/profil.png" alt="Profil" /></a>
      <?php endif; ?>
    </div>
  </header>

  <main class="newPublication">
    <form method="POST">
      <div>
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" required>
      </div>
      <div>
        <label for="prix">Prix:</label>
        <input type="number" id="prix" name="prix" required>
      </div>
      <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
      </div>
      <div>
        <label for="image">Image:</label>
        <input type="text" id="image" name="image" accept=".jpg, .png" required>
      </div>
      <div>
        <label for="etat">État:</label>
        <select id="etat" name="etat" required onfocus="this.options[0].hidden = true;">
          <option value="" selected disabled></option>
          <?php foreach ($etat as $et) : ?>
            <option value="<?php echo $et['id_etat']; ?>"><?php echo $et['nom']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label for="categorie">Catégorie:</label>
        <select id="categorie" name="categorie" required onfocus="this.options[0].hidden = true;">
          <option value="" selected disabled></option>
          <?php foreach ($categorie as $cat) : ?>
            <option value="<?php echo $cat['id_categorie']; ?>"><?php echo $cat['nom']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <button type="button" onclick="newPub()" id="creerPub">Créer la publication</button>
      </div>
    </form>
  </main>
</body>