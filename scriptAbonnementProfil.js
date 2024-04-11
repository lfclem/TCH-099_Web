console.log("fetching abonnements");

console.log("user : " + user);

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