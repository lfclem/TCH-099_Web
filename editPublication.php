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
} else{
    //echo "pas de id_publication";
}
$publicationId = $_SESSION['publicationId'];

$stmt = $db->prepare('SELECT * FROM Publication WHERE id_publication = ?');
$stmt->execute([$publicationId]);
$pub = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titre = $_POST['titre'];
  $prix = $_POST['prix'];
  $description = $_POST['description'];
  $image = $_POST['img'];
  $etat = $_POST['etat'];
  $categorie = $_POST['categorie'];

  $stmt = $db->prepare('UPDATE Publication SET titre = ?, prix = ?, description = ?, image = ?, id_etat = ?, id_categorie = ? WHERE id_publication = ?');
  $stmt->execute([$titre, $prix, $description, $image, $etat, $categorie, $publicationId]);

  $_SESSION['message'] = "Publication modifiée avec succès!";
  header("Location: /");
  exit();
}
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
        <input type="text" id="titre" name="titre" value="<?php echo $pub['titre']; ?>" class="form-control" required placeholder="Entrez le titre de votre publication" />
      </div>
      <div>
        <label for="prix">Prix:</label>
        <input type="number" id="prix" name="prix" value="<?php echo $pub['prix']; ?>" class="form-control" required placeholder="Entrez le prix de votre publication"/>
      </div>
      <div>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo $pub['description']; ?>" placeholder="Entrez une description de votre publication" class="form-control"/>
      </div>
      <div>
        <label for="image">Image:</label>
        <input type="url" id="img" name="img" class="form-control" accept="image/*" value="<?php echo $pub['image']; ?>" required />
      </div>
      <div>
        <label for="etat">État:</label>
        <select id="etat" name="etat" required onfocus="this.options[0].hidden = true;">
        <?php foreach ($etat as $e) : ?>
          <option value="<?php echo $e['id_etat']; ?>" <?php if ($e['id_etat'] == $pub['id_etat']) echo 'selected'; ?>><?php echo $e['nom']; ?></option>
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
        <button type="submit">Modifier la publication</button>
      </div>
      <div>
        <a href="?delete=1" onclick="return confirm('Êtes-vous sûr de vouloir supprimer la publication?');">Supprimer la publication</a>
      </div>
    </form>
  </main>
</body>