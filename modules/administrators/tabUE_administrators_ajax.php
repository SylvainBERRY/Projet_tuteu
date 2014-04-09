<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page tabUE_administrators_ajax.php
*
*Page effectuant les traitement sur la table utilisateurs_ue
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

// Traitement sur le tableau d'ue des utilisateurs:
include_once (CHEMIN_MODELE.'administrators_modele.php');

// Si des données sont postés ici des uti_id
if (isset($_POST['ue_id_uti']))
{
	// Récupère l'id de l'utilisateur sélectionné
	$user_id = $_POST['ue_id_uti'];

	// Erreur retrouvées
	$errors_array = array();

	// Récupère les UE de cet utilisateur
	$tableau_ue_arrays = lectureUEUti($user_id);


	if($tableau_ue_arrays === false)
	{
		// Ajout message d'erreur
		$errors_array[] = $tableau_ue_arrays;
	}

	// Si il n'y a aucune erreure
	if (empty($errors_array))
	{
		// retourn json
		header('Content-type: application/json');

		// Formatage des données
		$tableau_ue = array();
		foreach ($tableau_ue_arrays as $aCoupeUe) {
			array_push($tableau_ue, intval($aCoupeUe['ue_id']));
		}

		// résultat
		$array_result = array();
		$array_result['message'] = "Le(s) ue ont bien été récupérés.";
		$array_result['ue_id_uti'] = $tableau_ue;
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
		$array_result['message'] = "Une erreur est survenue, le(s) ue suivant(s) n'ont pas été récupérés.";
		$array_result['ue_id_uti'] = $errors_array;
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
