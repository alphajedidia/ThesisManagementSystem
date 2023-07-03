// Récupération des boutons de suppression
const editBtns = document.querySelectorAll('.editBtn');

// Recuperer les info de l'URL
let getPageURL = window.location.href;  
let pageUrl = getPageURL.split('/');

// Boucle sur les boutons
editBtns.forEach(button => {
  // Ajout d'un écouteur d'événements pour le clic
  button.addEventListener('click', event => {
        // Récupération de l'élément sur lequel le clic a été effectué (le bouton)
        const target = event.target;
        
        // Récupération de la valeur de l'attribut 'data-id'
        const id = target.dataset.num;

        //Determiner a quelle page renvoyer
        let destinationURL;

        if(pageUrl[pageUrl.length-1].split('?')[0] === 'afficheEtudiant.php'){
            destinationURL = './editerEtudiant.php'; 
        } else if(pageUrl[pageUrl.length-1].split('?')[0] === 'afficheProf.php'){
            destinationURL = './editerProf.php'; 
        } else if(pageUrl[pageUrl.length-1].split('?')[0] === 'afficheOrganisme.php'){
            destinationURL = './editerOrganisme.php'; 
        } else if(pageUrl[pageUrl.length-1].split('?')[0] === 'afficheSoutenance.php'){
            destinationURL = './editerSoutenance.php'; 
        }
        
        // console.log(tab);
        window.location.href = destinationURL+"?id="+id;
    })
})


  

