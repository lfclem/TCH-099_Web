console.log("USER ID : " + user);

//* FETCH LES DONNEES DU USER
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
    displayUser(data);
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
  let averageRating = user.rating_total / user.nb_rating;
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
fetch("/api/getAbonnements/" + user, {
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

  button.onclick = function () {
    console.log("clicked");
  };

  li.appendChild(button);
  ul.appendChild(li);
}
