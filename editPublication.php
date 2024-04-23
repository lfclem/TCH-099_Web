<?php
require './config.php';

$_SESSION['message'] = "";
$db = Database::getInstance();
$stmt = $db->prepare('SELECT * FROM Profil WHERE id_profil = ?');
$stmt->execute([$_SESSION['usager']]);
$user = $stmt->fetch();

$stmt = $db->prepare('SELECT * FROM Etat');
$stmt->execute();
$etat = $stmt->fetchAll();

$stmt = $db->prepare('SELECT * FROM Categorie');
$stmt->execute();
$categorie = $stmt->fetchAll();

if (isset($_GET['publicationId'])) {
  $_SESSION['publicationId'] = $_GET['publicationId'];
} else {
  //echo "pas de id_publication";
}
$publicationId = $_SESSION['publicationId'];

$stmt = $db->prepare('SELECT * FROM Publication WHERE id_publication = ?');
$stmt->execute([$publicationId]);
$pub = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sell-it!</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/style.css" />
  <link rel="stylesheet" href="/normalize.css" />
  <script>
    var userID = "<?php echo isset($_SESSION['usager']) ? $_SESSION['usager'] : 0; ?>";
  </script>
  <script src="/scriptNewPub.js"></script>
  <script src="/userPhoto.js"></script>
</head>

<body>
  <header class="headerInfos">
    <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
    <h1 class="title">Sell-it!</h1>
    <div class="icons">
      <a id="linkPfp" href="">
        <img class="pfp" src="" alt="Profil" id="photoProfil" />
      </a>
    </div>
  </header>

  <main class="newPublication">
    <form method="POST">
      <div>
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" value="<?php echo $pub['titre']; ?>" class="form-control" required placeholder="Entrez le titre de votre publication" />
      </div>
      <div>
        <label for="prix">Prix:</label>
        <input type="number" id="prix" name="prix" value="<?php echo $pub['prix']; ?>" class="form-control" required placeholder="Entrez le prix de votre publication" />
      </div>
      <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description" placeholder="Entrez une description de votre publication" class="form-control">
          <?php echo $pub['description']; ?>
        </textarea>
      </div>
      <div>
        <label for="image">Image:</label>
        <input type="url" id="image" name="img" class="form-control" value="<?php echo $pub['image']; ?>" required />
      </div>
      <div>
        <label for="etat">État:</label>
        <select id="etat" name="etat" required onfocus="this.options[0].hidden = true;">
          <?php
          $count = count($etat);
          foreach ($etat as $index => $e) : ?>
            <option value="<?php echo $e['id_etat']; ?>" <?php if ($e['id_etat'] == $pub['id_etat']) echo 'selected';
                                                          if ($index == $count - 1) echo ' hidden'; ?>><?php echo $e['nom']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label for="categorie">Catégorie:</label>
        <select id="categorie" name="categorie" required>
          <?php foreach ($categorie as $cat) : ?>
            <option value="<?php echo $cat['id_categorie']; ?>" <?php if ($cat['id_categorie'] == $pub['id_categorie']) echo 'selected'; ?>><?php echo $cat['nom']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <button type="button" onclick="editPub(<?php echo $publicationId ?>)">Modifier la publication</button>
      </div>
      <div>
        <button type="button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer la publication?') && deletePub(<?php echo $publicationId ?>);">Supprimer la publication</button>
      </div>
    </form>
  </main>
</body>