<?php
require './config.php';

$_SESSION['error_message'] = "";

if (isset($_GET['publicationId'])) {
    $_SESSION['publicationId'] = $_GET['publicationId'];
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
    <script src="/scriptFavoris.js"></script>
    <script>
        var userID = "<?php echo isset($_SESSION['usager']) ? $_SESSION['usager'] : 0; ?>";
    </script>
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

    <main class="pageArticle">
        <article class="article">
            <h2 id="titre"></h2>
            <img src="" alt="Article Image" class="center" id="image">
            <p id="description"></p>
            <p id="etat"></p>
            <p id="prix"></strong></p>
            <form method="post">
                <button type="button" onclick="favoris()" id="fav" name=""></button>
            </form>
            <button type="button" id="viewProfileButton">Voir le profil du vendeur</button>
            <form method="post">
                <button type="button" onclick="payer()" id="buy" name="buy">Acheter</button>
            </form>
        </article>
    </main>

    <dialog id="dialog">
        <form id="form">
            <label id="solde">Êtes-vous sur de vouloir acheter ce produit?</label>
            <label for="montant" id="label"></label>
            <div>
                <button type="button" onclick="confirm()" id="valide">Valider</button>
                <button type="button" onclick="dialog.close();" id="annule">Annuler</button>
            </div>
        </form>
    </dialog>

    <script>
        document.getElementById('viewProfileButton').addEventListener('click', function() {
            console.log("PUB ID : " + <?php echo $_SESSION['publicationId']; ?>);
            fetch(`/api/getUserID/<?php echo $_SESSION['publicationId']; ?>`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("La requête a échoué avec le statut " + response.status);
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                    window.location.href = "/pageUser.php?user_id=" + data.id_profil;
                });
        });
    </script>
</body>

</html>