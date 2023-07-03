// Récupération des boutons de suppression
const deleteButtons = document.querySelectorAll('.deleteBtn');

// Recuperer les info de l'URL
const thisPageURL = window.location.href;

// Boucle sur les boutons
deleteButtons.forEach(button => {
  // Ajout d'un écouteur d'événements pour le clic
  button.addEventListener('click', event => {
    // Récupération de l'élément sur lequel le clic a été effectué (le bouton)
    const target = event.target;
    
    // Récupération de la valeur de l'attribut 'data-id'
    const id = target.dataset.num;
    console.log(id);
    
    // Utilisation de la valeur de l'id pour effectuer une requête de suppression par exemple
    
    //Determiner a quelle page renvoyer
    // Récupération du nom de la page
    const pageName = thisPageURL.split('/').pop();

    //Détermination de l'URL de suppression en fonction de la page
    let destinationURL;
    if (pageName === 'afficheEtudiant.php') {
        destinationURL = './deleteEtudiant.php'; 
    } else if (pageName === 'afficheProf.php') {
        destinationURL = './deleteProf.php'; 
    } else if (pageName === 'afficheOrganisme.php') {
        destinationURL = './deleteOrganisme.php'; 
    } else if (pageName === 'afficheSoutenance.php') {
        destinationURL = './deleteSoutenance.php'; 
    }

    // Définition des paramètres de la requête POST
    const params = new URLSearchParams();
    params.append('id', id);

    // Afficher une boîte de dialogue de confirmation
    if (confirm("Voulez-vous vraiment supprimer cet élément ?")) {
        // Exécuter l'action de suppression ici
        // Envoi de la requête POST à l'aide de la méthode fetch()
        fetch(destinationURL, {
            method: 'POST',
            body: params
        })
        .then(response => response.text())
        .then(data => {
            // Traitement de la réponse du script PHP
        })
        .catch(error => {
            console.error('Erreur :', error);
        }) 
        alert("L'élément a été supprimé avec succès !");
        location.reload();
    } else {
        // Annuler l'action de suppression
        alert("Suppression annulée !");
    }
    });
})