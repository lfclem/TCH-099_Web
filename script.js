let publications = [];
let categories = [];
let profils = [];
let type_usager;
window.onload = function () {
  fetch("/jsonConverter", { methode: "GET" })
    .then((response) => response.json())
    .then((data) => {
      publications = data.publication;
      categories = data.categories;
      profils = data.profil;
      user = data.usager;
      console.log(user);
      renderPub();
    })
    .catch((error) =>
      console.error("Erreur lors de la récupération des données:", error)
    );

  const errorMessage = document.body.getAttribute("data-error-message");
  const reload = document.body.getAttribute("data-reload") === "true";
  if (errorMessage) {
    showErrorMessage(errorMessage, reload);
  }
};

//*Fonction pour afficher les articles
function renderPub() {
  for (let i = 0; i < publications.length; i++) {
    creerArticle(i);
  }
}

//*Fenetre pour confirmer des changements/creations de compte etc
function showErrorMessage(message, reload = false) {
  const modal = document.createElement("div");
  modal.style.position = "fixed";
  modal.style.zIndex = "1";
  modal.style.left = "0";
  modal.style.top = "0";
  modal.style.width = "100%";
  modal.style.height = "100%";
  modal.style.overflow = "auto";
  modal.style.backgroundColor = "rgba(0,0,0,0.4)";
  const modalContent = document.createElement("div");
  modalContent.style.backgroundColor = "#fefefe";
  modalContent.style.margin = "15% auto";
  modalContent.style.padding = "20px";
  modalContent.style.border = "1px solid #888";
  modalContent.style.width = "20%";
  modalContent.textContent = message;
  modal.appendChild(modalContent);
  document.body.appendChild(modal);
  setTimeout(function () {
    modal.remove();
    if (reload) {
      location.reload();
    }
  }, 1000);
}

//*Fonction pour qui filtre la recherche (searchbar, onglets, filtres, prix)
document.addEventListener("DOMContentLoaded", (event) => {
  document
    .querySelector(".buttonSearchbar")
    .addEventListener("click", function (event) {
      event.preventDefault();
      const searchbar = document.querySelector(".textSearchbar").value;
      const onglet = document.querySelector(".choiceTab").value;
      const etat = document.querySelector(".choiceCondition").value;
      const categorie = document.querySelector(".choiceCategory").value;
      const prixMinInput = document.querySelector(".textMinPrice");
      const prixMaxInput = document.querySelector(".textMaxPrice");
      const main = document.querySelector("main.listingsContainer");
      main.innerHTML = "";

      let prixMin = prixMinInput.value ? parseInt(prixMinInput.value) : 0;
      let prixMax = prixMaxInput.value
        ? parseInt(prixMaxInput.value)
        : Infinity;

      for (let i = 0; i < publications.length; i++) {
        if (
          publications[i]["titre"]
            .toLowerCase()
            .includes(searchbar.toLowerCase()) &&
          prixMin <= publications[i]["prix"] &&
          prixMax >= publications[i]["prix"] &&
          (categorie == publications[i]["categorie"] || categorie == 1) //&& etat == publications[i]["etat"]
        ) {
          creerArticle(i);
        }
      }
    });
});

function creerArticle(i) {
  const article = document.createElement("article");
  const main = document.querySelector("main.listingsContainer");
  const image = document.createElement("img");
  image.src = publications[i]["image"];
  image.alt = "Placeholder";
  article.appendChild(image);

  const titre = document.createElement("h2");
  titre.textContent = publications[i]["titre"];
  article.appendChild(titre);

  const prix = document.createElement("p");
  prix.textContent = "Price: $" + publications[i]["prix"];
  article.appendChild(prix);

  article.addEventListener("click", (event) => {
    if (user != 0 && user == publications[i]["id_profil"]) {
      const publicationId = publications[i]["id_publication"];
      const url = `/editPublication.php?publicationId=${publicationId}`;
      window.location.href = url;
    } else {
      const publicationId = publications[i]["id_publication"];
      const url = `/pageArticle.php?publicationId=${publicationId}`;
      window.location.href = url;
    }
  });
  main.appendChild(article);
}
