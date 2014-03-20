function showDataUti(){
	// Revoir l'utilisation du AJAX pour sélectionner les donnée de la checkbox et les afficher dans le formualire pour la gestion utilisateur
	var formu = document.forms["dataUti"];
	var data = 'id='+id;
	var xhr = getXhr();
	xhr.onreadystatechange=function()
	{ 
    		if(xhr.readyState == 4)
    		{
			if(xhr.status  == 200){
				var retour = xhr.responseText.split('|');
				if(retour[0] == "echec") {
					erreur(retour[1]);
				} else if(retour[0] == "succes") {
					document.getElementById("connexion_contenu").innerHTML =  "<div class='bienvenue'>Bienvenue !</div><div class='right'><a href='deconnexion.php?page="+retour[2]+"'>Se d&eacute;connecter</a></div>";
				} else
					alert("Resultat invalide !");
			} else
            			alert(xhr.status);
    		}
  	}; 
	xhr.open("POST", "accueil_administrators.php", true);		
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(data); 
}