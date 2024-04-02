let user;
window.onload = function(){
    fetch('/jsonConverter', { methode: "GET"})
        .then(response => response.json())
        .then(data => {
            tabCategories = data.categories;
            user = data.usager;
        })
        .catch(error => console.error('Erreur lors de la récupération des données:', error));
}


function newPub(){
    const titre = document.getElementById('titre');
    const prix = document.getElementById('prix');
    const desc = document.getElementById('description');
    const img = document.getElementById('image');
    const etat = document.getElementById('etat');
    const categorie = document.getElementById('categorie');

    if(!(titre.value === "") && !(prix.value === "") && !(img.value === "")){
        let pubTemp = {
            id_publication : -1,
            titre : titre.value,
            prix : prix.value,
            description : desc.value,
            image : img.value,
            id_profil : user,
            id_etat : etat.value,
            id_categorie : categorie.value
        };
        console.log(pubTemp);
        fetch("/api/postPublication/postPublication.php", {
            method: 'POST', // Méthode HTTP
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(pubTemp) // Convertir l'objet de données en chaîne JSON
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
    
            alert("Erreur lors de l'ajout de la publication: "+error);
            console.error('Erreur lors de la requête:', error);
        });
    }
}
function editPub(id_pub){
    const titre = document.getElementById('titre');
    const prix = document.getElementById('prix');
    const desc = document.getElementById('description');
    const img = document.getElementById('image');
    const etat = document.getElementById('etat');
    const categorie = document.getElementById('categorie');
    

    if(!(titre.value === "") && !(prix.value === "") && !(img.value === "")){
        let pubTemp = {
            id_publication : id_pub,
            titre : titre.value,
            prix : prix.value,
            description : desc.value,
            image : img.value,
            id_profil : user,
            id_etat : etat.value,
            id_categorie : categorie.value
        };
        console.log(pubTemp);
        fetch("/api/putPublication/" + id_pub, {
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
            //window.location.href = 'http://localhost:8000/'; // a changer
        })
        .catch(error => {
    
            alert("Erreur lors de l'edit de la publication: "+error);
            console.error('Erreur lors de la requête:', error);
        });
    }
}
function deletePub(id_pub){
    fetch("/api/deletePublication/" + id_pub, {
        method: 'DELETE', // Méthode HTTP
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
    
        alert("Erreur lors de la suppression de la publication: "+error);
        console.error('Erreur lors de la requête:', error);
    });
}