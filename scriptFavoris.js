let publication;
let etat;
let user;
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
                desc.textContent = publication[0]['description'];

                const etat = document.getElementById('etat');
                let nomEtat;
                for (let i = 0; i < etat.length; i++){
                    if (etat[i]['id_etat'] == publication[0]['id_etat']){
                        nomEtat = etat[i]['nom'];
                    }
                }
                etat.textContent = nomEtat;

                const prix = document.getElementById('prix');
                prix.textContent = "Prix: " + publication[0]['prix'];
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
                window.location.href = 'http://localhost:8000/'; // a changer
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
                window.location.href = 'http://localhost:8000/'; // a changer
            })
            .catch(error => {
        
                alert("Erreur lors de la suppression du favoris: "+error);
                console.error('Erreur lors de la requête:', error);
            });
        }
    }
}