const URL = "http://localhost:8000/";

let publications = [];
let categories = [];
let = [];
let favoris = [];
let type_usager;

window.onload = function () {
  fetch("/jsonConverter", { method: "GET" })
    .then((response) => response.json())
    .then((data) => {
      publications = data.publication;
      categories = data.categories;
      profils = data.profil;
      user = data.usager;
      favoris = data.favoris;
      console.log(user);

      if (window.location.href == URL) {
        if (user == 0) {
          fetch("/api/getAllPublications", {
            method: "GET",
            headers: {
              "Content-Type": "application/json",
            },
          })
            .then((response) => {
              if (!response.ok) {
                throw new Error(
                  "La requête a échoué avec le statut " + response.status
                );
              }
              return response.json();
            })
            .then((data) => {
              let itemVendus = [];
              data.forEach((item) => {
                console.log(item);
                if (item['id_etat'] == 5){
                  console.log(item);
                  itemVendus.push(item);
                } else{
                  creerArticle(item);
                }
              });
              itemVendus.forEach((item) => {
                creerArticle(item);
              });

            });
        } else {
          fetchData(
            "getPublicationsFiltresPubliques",
            "",
            0,
            Infinity,
            1,
            1,
            user
          );
        }

        //* Fetch categorie
        fetch("/api/getCategories")
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

        if (user != 0) {
          //* Fetch onglet
          fetch("./api/getOnglets")
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
        }
        //* Fetch etat
        fetch("./api/getEtats")
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

//*Fonction pour qui filtre la recherche (searchbar, onglets, filtres, prix)
if (window.location.href == URL) {
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

        switch (onglet) {
          case "1":
            //Publiques
            fetchData(
              "getPublicationsFiltresPubliques",
              searchbar,
              prixMin,
              prixMax,
              etat,
              categorie,
              user
            );
            break;

          case "2":
            // Abonnements
            fetchData(
              "getPublicationsFiltresAbonnes",
              searchbar,
              prixMin,
              prixMax,
              etat,
              categorie,
              user
            );
            break;

          case "3":
            // Favoris
            fetchData(
              "getPublicationsFiltresFavoris",
              searchbar,
              prixMin,
              prixMax,
              etat,
              categorie,
              user
            );
            break;

          case "4":
            // Mes publications
            fetchData(
              "getPublicationsFiltresPrivees",
              searchbar,
              prixMin,
              prixMax,
              etat,
              categorie,
              user
            );
        }
      });
  });
}

//* Fonction pour creer un article
function creerArticle(item) {
  const article = document.createElement("article");
  const main = document.querySelector("main.listingsContainer");
  const image = document.createElement("img");
  image.src = item["image"];
  image.alt = "Placeholder";
  article.appendChild(image);

  const titre = document.createElement("h2");
  if(item['id_etat'] == 5){
    titre.textContent = " VENDU : " + item["titre"];
    titre.style.color = "red";
  } else {
    titre.textContent = item["titre"];
  }
  article.appendChild(titre);

  const prix = document.createElement("p");
  prix.textContent = "Prix: " + item["prix"] + "$";
  article.appendChild(prix);

  article.addEventListener("click", (event) => {
    if (user != 0 && user == item["id_profil"]) {
      const publicationId = item["id_publication"];
      const url = `/editPublication.php?publicationId=${publicationId}`;
      window.location.href = url;
    } else {
      const publicationId = item["id_publication"];
      const url = `/pageArticle.php?publicationId=${publicationId}`;
      window.location.href = url;
    }
  });
  main.appendChild(article);
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

function fetchData(
  endpoint,
  searchbar,
  prixMin,
  prixMax,
  etat,
  categorie,
  user
) {
  return fetch(
    `./api/${endpoint}/` +
      searchbar +
      "/" +
      prixMin +
      "/" +
      prixMax +
      "/" +
      etat +
      "/" +
      categorie +
      "/" +
      user,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    }
  )
    .then((response) => {
      if (!response.ok || response.status === 204) {
        return [];
      }
      return response.json();
    })
    .then((data) => {
      let itemVendus = [];
      data.forEach((item) => {
        if (item['id_etat'] == 5){
          console.log(item);
          itemVendus.push(item);
        } else{
          creerArticle(item);
        }
      });
      itemVendus.forEach((item) => {
        creerArticle(item);
      });
    });
}
