console.log("USER ID : " + userID);
let infoUser;

//* FETCH LES DONNEES DU USER
fetch("/api/getUser/" + userID, {
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
    displayUser(data);
    infoUser = data;
  });

//*DISPLAY LES INFOS DU USER
function displayUser(user) {
  document.querySelector(
    ".balance label"
  ).textContent = `Votre solde: ${user.montant_balance}$`;
  document.querySelector(
    ".rating label"
  ).textContent = `Vos Évaluations (${user.nb_rating}):`;

  const stars = document.querySelector(".rating div");
  stars.innerHTML = "";
  let averageRating = Math.round((user.rating_total / user.nb_rating) * 2) / 2;
  for (let i = 0; i < 5; i++) {
    const star = document.createElement("img");
    star.alt = "Star";
    if (averageRating - i >= 1) {
      star.src = "/IMG/filled_star.png";
    } else if (averageRating - i > 0) {
      star.src = "/IMG/half_filled_star.png";
    } else {
      star.src = "/IMG/empty_star.png";
    }
    stars.appendChild(star);
  }

  document.getElementById("username").value = user.username;
  document.getElementById("email").value = user.email;
  document.getElementById("photo_profil").value = user.photo_profil;
  document.getElementById("info_paiement").value = user.info_paiement;
  document.getElementById("adresse").value = user.adresse;
  document.getElementById("bio").value = user.bio;
}

//* FETCH LES ABONNEMENTS DU USER
fetch("/api/getAbonnements/" + userID, {
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
    data.forEach((item) => {
      creerAbonnement(item);
    });
  });

//* CREE LA LISTE D'ABONNEMENTS
function creerAbonnement(item) {
  const ul = document.querySelector(".column3 ul");
  const li = document.createElement("li");

  const button = document.createElement("button");

  const img = document.createElement("img");
  img.src = item["photo_profil"];
  img.alt = item["username"];
  button.appendChild(img);

  const h2 = document.createElement("h2");
  h2.textContent = item["username"];
  button.appendChild(h2);

  button.onclick = function (event) {
    event.preventDefault();
    console.log("click");
    window.location.href = "/pageUser.php?user_id=" + item["id_profil"];
  };

  li.appendChild(button);
  ul.appendChild(li);
}

// add/retirer de l'argent
let dialog;
let valider = 0;
window.onload = function () {
  dialog = document.getElementById("dialog");
};

function openDialog(type) {
  valider = type;
  document.getElementById(
    "solde"
  ).textContent = `Votre solde: ${infoUser.montant_balance}$`;
  const montant = document.getElementById("label");
  if (type == 1) {
    montant.textContent = "Montant à ajouter:";
  } else if (type == 2) {
    montant.textContent = "Montant à retirer:";
  }
  dialog.showModal();
}

function changeSolde() {
  let montant = document.getElementById("montant").value;
  let newSolde;
  if (!isNaN(montant)) {
    if (valider == 1) {
      newSolde = parseFloat(infoUser.montant_balance) + parseFloat(montant);
    } else if (valider == 2) {
      newSolde = parseFloat(infoUser.montant_balance) - parseFloat(montant);
    }
    if (newSolde >= 0) {
      fetch("/api/editUserMontant/" + user, {
        method: "PUT", // Méthode HTTP
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(newSolde), // Convertir l'objet de données en chaîne JSON
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error(
              "La requête a échoué avec le statut " + response.status
            );
          }
          return response.json(); // Convertir la réponse en JSON
        })
        .then((data) => {
          infoUser.montant_balance = newSolde.toFixed(2);
          displayUser(infoUser);
          dialog.close();
        })
        .catch((error) => {
          alert("Erreur lors de l'edit du montant: " + error);
          console.error("Erreur lors de la requête:", error);
        });
    } else {
      //pop up
      window.alert(
        "Le montant que vous voulez retirer est plus grand que votre solde."
      );
    }
    valider == 0;
  } else {
    //pop up
    window.alert(
      "Assurez vous que la valeur soit un nombre sans text ni symbole (ex: -, $, ...)."
    );
  }
}
