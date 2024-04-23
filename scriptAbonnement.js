let etat;
let btnName;
window.onload = async function(){

    fetch('/jsonConverter', { methode: "GET"})
        .then(response => response.json())
        .then(data => {
            user = data.usager;

            fetch("/api/getAbonnement/" + user + "/" + id_profil, {
                method: 'GET', // Méthode HTTP
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La requête a échoué avec le statut ' + response.status);
                }
                return response.json(); 
            })
            .then(data => {
                const btnAbn = document.getElementById('abn');
                btnAbn.setAttribute('name', data.name);
                btnAbn.textContent = data.msg;
                btnName = data.name;
            })
            .catch(error => {

                alert("Erreur lors de la recherche de favoris: "+error);
                console.error('Erreur lors de la requête:', error);
            });
        })
        .catch(error => console.error('Erreur lors de la récupération des données:', error));
}

function Abonner(){
    if (user == 0){
        window.location.href = 'http://localhost:8000/login.php'; // a changer
    } else{
        if (btnName == "add_abonne"){
            console.log("add");
            let infoAbn = {
                id_profil : user,
                id_abonne : id_profil,
            };
            console.log(infoAbn);
            fetch("/api/postAbonnement", {
                method: 'POST', // Méthode HTTP
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(infoAbn) // Convertir l'objet de données en chaîne JSON
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La requête a échoué avec le statut ' + response.status);
                }
                return response.json(); 
            })
            .then(data => {
                const btnAbn = document.getElementById('abn');
                btnAbn.setAttribute('name', 'delete_abonne');
                btnAbn.textContent = "Desabonner";
                btnName = 'delete_abonne';
                console.log("add reussi");
            })
            .catch(error => {
    
                alert("Erreur lors de l'ajout de l'abonnement: "+error);
                console.error('Erreur lors de la requête:', error);
            });
        } 
        if (btnName == "delete_abonne"){
            console.log("delete");
            fetch("/api/deleteAbonnement/"  + user + "/" + id_profil, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La requête a échoué avec le statut ' + response.status);
                }
                return response.json(); // Convertir la réponse en JSON
            })
            .then(data => {
                if(data.error){
                    throw new Error('Erreur lors de la suppression: '+data.error);
                } 
                const btnAbn = document.getElementById('abn');
                btnAbn.setAttribute('name', 'add_abonne');
                btnAbn.textContent = 'Abonner';
                btnName = 'add_abonne';
                console.log("delete reussi");
            })
            .catch(error => {
        
                alert("Erreur lors de la suppression de l'abonnement: "+error);
                console.error('Erreur lors de la requête:', error);
            });
        }
    }
}