<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page delete_administrators_ajax.php
*
*Page effectuant les suppression en ajax des utilisateurs
*
*Quelques indications : (utiliser l'outil de recherche et rechercher les mentions données)
*
*Liste des fonctions :
*--------------------------
*Aucune fonction
*--------------------------
*
*Liste des informations/erreurs :
*--------------------------
*Aucune information/erreur
*--------------------------
*/

// Suppression des utilisateurs:
include_once (CHEMIN_MODELE.'administrators_modele.php');

// Si des données sont postés ici des id_uti
if (isset($_POST['users_id_uti']))
{
	$tableau_id = $_POST['users_id_uti'];
	// Erreur retrouvées
	$errors_array = array();
	foreach ($tableau_id as $user_id => $result) {
		if(!deleteUti($result))
		{
			// Ajout message d'erreur
			$errors_array[] = $result;
		}
	}

	// Si il n'y a aucune erreure
	if (empty($errors_array))
	{
		// retourn json
		header('Content-type: application/json');

		// résultat
		$array_result = array();
		$array_result['message'] = "Le(s) utilisateur(s) ont bien été supprimés.";
		$array_result['users_id_uti'] = $tableau_id;
		$array_result_json = json_encode($array_result);

		// Afficher résultat
		print_r($array_result_json);

	}

	// Si un problème est survenu
	else {

		//retourner un response code error
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		// retourn json
		header('Content-type: application/json');

		//lister dans un tableau les id error
		$array_result = array();
		$array_result['message'] = "Une erreur est survenue, le(s) utilisateur(s) suivants n'ont pas été supprimés.";
		$array_result['users_id_uti'] = $errors_array;
		$array_result_json = json_encode($array_result);

		// Afficher la liste
		print_r($array_result_json);

	}

}
else {
	header("HTTP/1.0 404 Not Found");
}


// Quelque soit le résultat
exit();
?>
