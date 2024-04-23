console.log("getPublications.js");
console.log("user2: " + id_profil);
fetch("/api/getPublications/" + id_profil, {
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
      creerArticle(item);
    });
  });

function creerArticle(item) {
  const article = document.createElement("article");
  const main = document.querySelector(".userPublications");
  const image = document.createElement("img");
  image.src = item["image"];
  image.alt = "Placeholder";
  article.appendChild(image);

  const titre = document.createElement("h2");
  if (item["id_etat"] == 5) {
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
      console.log("USER" + user)
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
