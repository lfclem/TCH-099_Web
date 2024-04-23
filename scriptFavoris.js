let publication;
let etat;
let user;
let infoUser;
let btnName;
let publicationId


window.onload = async function(){
    fetch('/jsonConverter', { methode: "GET"})
        .then(response => response.json())
        .then(data => {
            user = data.usager;
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            publicationId = urlParams.get('publicationId');
            fetch("./api/Etats/getEtats.php")
                .then((response) => response.json())
                .then((data) => {
                    etat = data;
                });


            fetch("/api/getPublication/" + publicationId, {
                method: 'GET', // Méthode HTTP
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La requête a échoué avec le statut ' + response.status);
                }
                return response.json(); 
            })
            .then(data => {
                publication = data;
                const titre = document.getElementById('titre');
                titre.textContent = publication[0]['titre'];

                const image = document.getElementById('image');
                image.setAttribute('src', publication[0]['image']);

                const desc = document.getElementById('description');
                if (publication[0]['description'] == ""){
                    desc.textContent = "Acune description";
                } else {
                    desc.textContent = publication[0]['description'];
                }

                const textEtat = document.getElementById('etat');
                let nomEtat;
                for (let i = 0; i < etat.length; i++){
                    if (etat[i]['id_etat'] == publication[0]['id_etat']){
                        nomEtat = etat[i]['nom'];
                        if (etat[i]['id_etat'] == 5){
                            textEtat.style.color = "red";
                        }
                    }
                }
                textEtat.textContent = nomEtat;

                const prix = document.getElementById('prix');
                prix.textContent = "Prix: " + publication[0]['prix'];

                if (publication[0].id_etat == 5) {
                    document.getElementById("buy").hidden = true;
                } 
            })
            .catch(error => {

                alert("Erreur lors de la recherche de la publication: "+error);
                console.error('Erreur lors de la requête:', error);
            });

            fetch("/api/getFavoris/" + user + "/" + publicationId, {
                method: 'GET', // Méthode HTTP
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La requête a échoué avec le statut ' + response.status);
                }
                return response.json(); 
            })
            .then(data => {
                const fav = document.getElementById('fav');
                fav.setAttribute('name', data.name);
                fav.textContent = data.msg;
                btnName = data.name;
            })
            .catch(error => {

                alert("Erreur lors de la recherche de favoris: "+error);
                console.error('Erreur lors de la requête:', error);
            });

            fetch("/api/getUser/" + user, {
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
                infoUser = data;
            });
        })
        .catch(error => console.error('Erreur lors de la récupération des données:', error));
}

function favoris(){
    if (user == 0){
        window.location.href = 'http://localhost:8000/login.php'; // a changer
    } else{
        if (btnName == "add_favorite"){
            console.log("add");
            let infoFav = {
                id_publication : publicationId,
                id_profil : user,
            };
            console.log(infoFav);
            fetch("/api/postFavoris", {
                method: 'POST', // Méthode HTTP
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(infoFav) // Convertir l'objet de données en chaîne JSON
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La requête a échoué avec le statut ' + response.status);
                }
                return response.json(); 
            })
            .then(data => {
                const fav = document.getElementById('fav');
                fav.setAttribute('name', "delete_favorite");
                fav.textContent = "Enlever des favoris";
                btnName = "delete_favorite";
            })
            .catch(error => {
    
                alert("Erreur lors de l'ajout du Favorie: "+error);
                console.error('Erreur lors de la requête:', error);
            });
        }
        if (btnName == "delete_favorite"){
            console.log("delete");
            fetch("/api/deleteFavoris/"  + user + "/" + publicationId, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La requête a échoué avec le statut ' + response.status);
                }
                return response.json(); // Convertir la réponse en JSON
            })
            .then(data => {
                if(data.error){
                    throw new Error('Erreur lors de la suppression: '+data.error);
                }
                const fav = document.getElementById('fav');
                fav.setAttribute('name', "add_favorite");
                fav.textContent = "Ajouter en favoris";
                btnName = "add_favorite";
            })
            .catch(error => {
        
                alert("Erreur lors de la suppression du favoris: "+error);
                console.error('Erreur lors de la requête:', error);
            });
        }
    }
}

let newSolde
function payer(){
    if (publication[0].id_etat != 5) {
        newSolde = parseFloat(infoUser.montant_balance) - parseFloat(publication[0].prix);
        console.log(parseFloat(newSolde));

        if (newSolde >= 0) {
            document.getElementById(
            "label"
            ).textContent = `Votre solde après l'achat : ${newSolde}$`;
            dialog.showModal();
        } else {
            window.alert("Vous n'avez pas assez d'argent dans votre compte");
        }
    } else {

    }
    
}
function confirm(){
    fetch("/api/editUserMontant/" + user, {
        method: 'PUT', // Méthode HTTP
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(newSolde) // Convertir l'objet de données en chaîne JSON
    })
    .then(response => {
        if (!response.ok) {
          throw new Error('La requête a échoué avec le statut ' + response.status);
        }
        return response.json(); // Convertir la réponse en JSON
    })
    .then(data => {
        window.alert("item achete");
        dialog.close();

    })
    .catch(error => {
      alert("Erreur lors de l'edit du montant: "+error);
      console.error('Erreur lors de la requête:', error);
    });

    let pubTemp = {
        id_publication : publicationId,
        titre : publication[0].titre,
        prix : publication[0].prix,
        description : publication[0].description,
        image : publication[0].image,
        id_profil : user,
        id_etat : 5,
        id_categorie : publication[0].id_categorie
    };
    fetch("/api/putPublication/" + publicationId, {
        method: 'PUT', // Méthode HTTP
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(pubTemp) // Convertir l'objet de données en chaîne JSON
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('La requête a échoué avec le statut ' + response.status);
        }
        return response.json(); // Convertir la réponse en JSON
    })
    .then(data => {
        window.location.href = 'http://localhost:8000/'; // a changer
    })
    .catch(error => {

        alert("Erreur lors de l'edit de la publication: "+error);
        console.error('Erreur lors de la requête:', error);
    });
}