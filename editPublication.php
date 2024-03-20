<?php
require './config.php';

$_SESSION['message'] = "";
$db = Database::getInstance();
$stmt = $db->prepare('SELECT * FROM Profil WHERE id_profil = ?');
$stmt->execute([$_SESSION['usager']]);
$user = $stmt->fetch();

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

$editCat;
foreach ($categorie as $cat){
    if ($cat['id_categorie'] == $pub['id_categorie']){
        $editCat = $cat;
    }
}

if (isset($_GET['delete'])) {
    $stmt = $db->prepare('DELETE FROM Publication WHERE id_publication = ?');
    $stmt->execute([$publicationId]);
    header('Location: /');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST['titre']);
    $prix = htmlspecialchars($_POST['prix'],);
    $description = htmlspecialchars($_POST['description']);
    $image = filter_var($_POST['img'], FILTER_SANITIZE_URL);
    //$video = filter_var($_POST['video'], FILTER_SANITIZE_URL);
    $id_categorie = htmlspecialchars($_POST['categories']);
    
    try{
        $stmt = $db->prepare("UPDATE `Publication` SET `titre`=:titre, `prix`=:prix, `description`=:descrip, `image`=:img, `id_categorie`=:id_cat  WHERE `id_publication`=:id");
        $stmt->bindValue(":titre", $titre);
        $stmt->bindValue(":prix", $prix);
        $stmt->bindValue(":descrip", $description);
        $stmt->bindValue(":img", $image);
        //$stmt->bindValue(":vid", $video);
        $stmt->bindValue(":id_cat", $id_categorie); 
        $stmt->bindValue(":id", $publicationId); 
        $stmt->execute(); 
        $_SESSION['message'] = "Informations modifiées avec succès.";
    }catch (PDOException $e){
        http_response_code(500);
        echo "Erreur lors de l'update en BD: ".$e->getMessage();
    }
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
</head>

<body data-error-message="<?php echo $_SESSION['message'] ?>" data-reload="false">
    <header class="headerInfos">
        <a href="/"><img class="logo" src="/IMG/logo.png" alt="Logo" /></a>
        <h1 class="title">Sell-it!</h1>
        <div class="icons">
            <a href=""><img src="/IMG/messages.png" alt="Messages" /></a>
            <?php
            $photo_profil = $user['photo_profil'];
            ?>
            <?php if ($photo_profil) : ?>
                <a href=""><img class="pfp" src="<?php echo $photo_profil; ?>" alt="Photo_Profil" /></a>
            <?php else : ?>
                <a href=""><img class="pfp" src="/IMG/profil.png" alt="Profil" /></a>
            <?php endif; ?>
        </div>
    </header>
  <main class="newPublicationsw">
        <section id="nouvellePublications" class="newPublications">
            <h2>Modifier la Publication</h2>
            <form method="post">
                <div class="form-group">
                    <label for="titre">Title:</label>
                    <input type="text" id="titre" name="titre" value="<?php echo $pub['titre']; ?>" class="form-control" required placeholder="Entrez le titre de votre publication" />
                </div>

                <div class="form-group">
                  <label for="prix">Price:</label>
                  <input type="number" id="prix" name="prix" value="<?php echo $pub['prix']; ?>" class="form-control" required placeholder="Entrez le prix de votre publication"/>
                </div>

                <div class="form-group">
                  <label for="description">Description:</label>
                  <input type="text" id="description" name="description" value="<?php echo $pub['description']; ?>" placeholder="Entrez une description de votre publication" class="form-control"/>
                </div>

                <div class="form-group image-upload">
                    <label for="img">Image:</label>
                    <input type="url" id="img" name="img" class="form-control" accept="image/*" value="<?php echo $pub['image']; ?>" required />
                </div>

                <div class="form-group">
                  <label for="categories">Categories:</label>
                  <select name="categories" id="categories">
                    <?php foreach($categorie as $cat) {
                        if ($cat['id_categorie'] == $pub['id_categorie']) : ?>
                            <option value="<?php echo $cat['id_categorie']; ?>" selected><?php echo $cat['nom']; ?></option>
                        <?php else : ?>
                            <option value="<?php echo $cat['id_categorie']; ?>"><?php echo $cat['nom']; ?></option>
                        <?php endif; ?>
                    <?php } ?>
                  </select>
                </div>
                <button type="submit">Modifier mes informations</button>
                <a href="?delete=1" onclick="return confirm('Êtes-vous sûr de vouloir supprimer la publication?');">Delete</a>
            </form>
        </section>
    </main>
</body>