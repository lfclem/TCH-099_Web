const URL = "http://localhost:8000/";

let publications = [];
let categories = [];
let   = [];
let favoris = [];
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
      favoris = data.favoris;
      if (window.location.href == URL) {
        renderPub();

        //* Fetch categorie
        fetch("./api/Categories/getCategories.php")
          .then((response) => response.json())
          .then((data) => {
            const select = document.getElementById("category");
            data.forEach((item) => {
              const option = document.createElement("option");
              option.value = item.id_categorie;
              option.textContent = item.nom;
              select.appendChild(option);
            });
          });

        //* Fetch onglet
        fetch("./api/Onglets/getOnglets.php")
          .then((response) => response.json())
          .then((data) => {
            const select = document.getElementById("tab");
            data.forEach((item) => {
              const option = document.createElement("option");
              option.value = item.id_onglet;
              option.textContent = item.nom;
              select.appendChild(option);
            });
          });

        //* Fetch etat
        fetch("./api/Etats/getEtats.php")
          .then((response) => response.json())
          .then((data) => {
            const select = document.getElementById("condition");
            data.forEach((item) => {
              const option = document.createElement("option");
              option.value = item.id_etat;
              option.textContent = item.nom;
              select.appendChild(option);
            });
          });
      }

      if (user) {
        fetch("./api/User/getPhotoProfil.php?id=" + user)
          .then((response) => {
            if (!response.ok) {
              throw new Error("Failed to fetch user photo");
            }
            return response.json();
          })
          .then((data) => {
            const photo = document.getElementById("photoProfil");
            photo.src = data.photo;
            photo.href = "./pageProfil.php?id=" + user;
          })
          .catch((error) => {
            console.error("Error fetching user photo:", error);
            const defaultPhotoUrl = "./IMG/profil.png";
            const photo = document.getElementById("photoProfil");
            photo.src = defaultPhotoUrl;
          });
      } else {
        const defaultPhotoUrl = "./IMG/profil.png";
        const photo = document.getElementById("photoProfil");
        photo.src = defaultPhotoUrl;
      }
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
    if (user !== publications[i]["id_profil"]) creerArticle(i);
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
if (window.location.href == "http://localhost:8000/") {
  document.addEventListener("DOMContentLoaded", (event) => {
    document
      .querySelector(".buttonSearchbar")
      .addEventListener("click", function (event) {
        console.log("click");
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

        switch (onglet) {
          case "1":
            for (let i = 0; i < publications.length; i++) {
              if (
                publications[i]["titre"]
                  .toLowerCase()
                  .includes(searchbar.toLowerCase()) &&
                prixMin <= publications[i]["prix"] &&
                prixMax >= publications[i]["prix"] &&
                (categorie == publications[i]["id_categorie"] ||
                  categorie == "1") &&
                (etat == publications[i]["id_etat"] || etat == "1") &&
                user != publications[i]["id_profil"]
              ) {
                creerArticle(i);
              }
            }
            break;

          case "2":
            // Abonnements
            break;

          case "3":
            // Favoris
            for (let i = 0; i < publications.length; i++) {
              if (
                publications[i]["titre"]
                  .toLowerCase()
                  .includes(searchbar.toLowerCase()) &&
                prixMin <= publications[i]["prix"] &&
                prixMax >= publications[i]["prix"] &&
                (categorie == publications[i]["id_categorie"] ||
                  categorie == "1") &&
                (etat == publications[i]["id_etat"] || etat == "1")
              ) {
                for (let j = 0; j < favoris.length; j++) {
                  if (
                    favoris[j]["id_profil"] == user &&
                    favoris[j]["id_publication"] ==
                      publications[i]["id_publication"]
                  ) {
                    creerArticle(i);
                    break;
                  }
                }
              }
            }
            break;

          case "4":
            for (let i = 0; i < publications.length; i++) {
              if (
                publications[i]["titre"]
                  .toLowerCase()
                  .includes(searchbar.toLowerCase()) &&
                prixMin <= publications[i]["prix"] &&
                prixMax >= publications[i]["prix"] &&
                (categorie == publications[i]["id_categorie"] ||
                  categorie == "1") &&
                (etat == publications[i]["id_etat"] || etat == "1") &&
                user == publications[i]["id_profil"]
              ) {
                creerArticle(i);
              }
            }
            break;
        }
      });
  });
}

//* Fonction pour creer un article
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
  prix.textContent = "Prix: " + publications[i]["prix"] + "$";
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
