let tabPublications = [];
let tabCategories = [];
let tabProfils = [];
let user;
let apiPub = "/api/"
window.onload = function(){
    fetch('/jsonConverter',
    { methode: "GET"})
    
        .then(response => response.json())
        .then(data => {
            tabPublications = data.publication;
            tabCategories = data.categories;
            tabProfils = data.profil;
            user = data.usager;
        })
        .catch(error => console.error('Erreur lors de la récupération des données:', error));
}


function newPub(){
    const titre = document.getElementById('titre');
    const prix = document.getElementById('prix');
    const desc = document.getElementById('description');
    const vid = document.getElementById('video');
    const img = document.getElementById('img');
    const categorie = document.getElementById('categories');
    let selectedOptions = categorie.selectedOptions;

    let listeCat = [];
    let pubTemp = [];
    for(let i = 0; i < selectedOptions.length; i++){
        listeCat.push(selectedOptions[i].value);
    }

    if(!(titre.value === "") && !(prix.value === "") && !(img.value === "")){
        pubTemp.push({
            id_publication : -1,
            titre : titre.value,
            prix : prix.value,
            description : desc.value,
            image : img.value,
            //video : vid.value,
            id_profil : user,
            id_categorie : 1
        });
        console.log(pubTemp[0]);
        let apiPub = "/api/postPublication/postPublication.php";
        fetch(apiPub, {
            method: 'POST', // Méthode HTTP
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(pubTemp[0]) // Convertir l'objet de données en chaîne JSON
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('La requête a échoué avec le statut ' + response.status);
            }
            return response.json(); // Convertir la réponse en JSON
        })
        .then(data => {
            pubTemp[0]['id_publication'] = data.id_publication
            tabPublications.push(pubTemp[0]);
            window.location.href = '/index.php';
        })
        .catch(error => {
            tabPublications = tabPublications.filter((p)=>p.id_publication != -1);
            alert("Erreur lors de l'ajout de la publication: "+error);
            console.error('Erreur lors de la requête:', error);
        });
    }
}