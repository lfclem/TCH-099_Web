let publications = [];
let categories = [];
let profils = [];
let type_usager;
window.onload = function(){
    fetch('/jsonConverter',
    { methode: "GET"})
    
        .then(response => response.json())
        .then(data => {
            publications = data.publication;
            categories = data.categories;
            profils = data.profil;
            user = data.usagers;
            renderPub();
        })
        .catch(error => console.error('Erreur lors de la récupération des données:', error));
}

function renderPub(){
    const main = document.querySelector('main.listingsContainer');

    for(let i = 0; i < publications.length; i++){
        const article = document.createElement('article')

        const image = document.createElement('img');
        image.src = publications[i]['image'];
        image.alt = "Placeholder"
        article.appendChild(image);

        const titre = document.createElement('h2');
        titre.textContent = publications[i]['titre'];
        article.appendChild(titre);

        const prix = document.createElement('p')
        prix.textContent = "Price: $" + publications[i]['prix'];
        article.appendChild(prix);

        main.appendChild(article);
    }
}

