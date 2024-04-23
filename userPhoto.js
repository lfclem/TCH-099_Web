document.addEventListener("DOMContentLoaded", function () {
    if (userID != 0) {
        fetch("/api/getPhotoProfil/" + userID, {
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
                const photoProfil = document.getElementById("photoProfil");
                photoProfil.src = data.photo_profil;
                const lien = document.getElementById("linkPfp");
                lien.href = "/profil";
            });
    } else {
        const photoProfil = document.getElementById("photoProfil");
        photoProfil.src = "./IMG/profil.png";
        const lien = document.getElementById("linkPfp");
        lien.href = "/login";
    }
});
