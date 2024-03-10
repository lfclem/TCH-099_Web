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
      user = data.usagers;
      renderPub();
    })
    .catch((error) =>
      console.error("Erreur lors de la récupération des données:", error)
    );
};

function renderPub() {
  const main = document.querySelector("main.listingsContainer");

  for (let i = 0; i < publications.length; i++) {
    const article = document.createElement("article");

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

    main.appendChild(article);
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
  }, 2000);
}
window.onload = function () {
  const errorMessage = document.body.getAttribute("data-error-message");
  const reload = document.body.getAttribute("data-reload") === "true";
  if (errorMessage) {
    showErrorMessage(errorMessage, reload);
  }
};
