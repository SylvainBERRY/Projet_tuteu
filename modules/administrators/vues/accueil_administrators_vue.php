<?php
/**
*BERRY Sylvain & El-Hocine Takouert
*Page accueil_administrators_vue.php
*
*Page d'accueil de l'administrateur.
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
?>
<!-- Panneau de configuration utilisateurs -->
<p class="listeUti">
	<h1>
		Utilisateurs
	</h1>

	<!-- Affichage de la liste des utilisateurs avec choix possible -->
	<table id="tableauUti">

			<thead>
				<tr>
					<th></th>
					<th>Nom</th>
					<th>Pr&egrave;nom</th>
					<th>Email</th>
					<th>Login</th>
					<th>Valide</th>
					<th>Opérations</th>
				</tr>
			</thead>

			<tbody>
			<?php
			$reponse = lectureUti();

			foreach ($reponse as $donnees) {
			?>
				<tr id="tr_<?php echo $donnees['uti_id'];?>">
					<td>
						<!-- Effectuer le traitement AJAX pour afficher les données de la ligne coché dans le formulaire ci-dessous-->
						<input validid="<?php echo $donnees['uti_id'];?>" type="checkbox" />
					<td >
						<?php echo $donnees['uti_nom']; ?></td>
					<td >
						<?php echo $donnees['uti_prenom']; ?></td>
					<td >
						<?php echo $donnees['uti_mail']; ?></td>
					<td >
						<?php echo $donnees['uti_login']; ?></td>
					<td class="td_valide">
						<?php
						if ($donnees['uti_is_valide'])
						{ echo 'Validé'; }
						else { echo 'Non validé';}
						?>
					</td>
					<td>
						<button class='td_btn_modifier'>Modifier</button>
						<button <?php echo ($donnees['uti_is_valide'])?' disabled ':''; ?>class='td_btn_valider' onclick="valider_un_user(<?php echo $donnees['uti_id'];?>)">Valider</button>
						<button class='td_btn_delete' onclick="delete_un_user(<?php echo $donnees['uti_id'];?>)">Supprimer</button>
					</td>
				</tr>

			<?php
			}
			?>
		</tbody>

	</table>
</p>

	<button id="valide_multi_user" onclick="valider_plusieurs_users();">Valider sélection</button>
	<button id="add_btn">Nouveau</button>
	<button id="delete_multi_user" onclick="delete_plusieurs_users();">Supprimer sélection</button>
<?php if (DEBUG_AUTO_UTI){ ?>
	<form id= "insert_auto_uti" action="index.php?module=administrators&action=insert_auto_uti_debug" method="post">
		<input type="text" name="Nb_Uti" value="" size="3" />
		<input type="submit" value="Auto Utilisateur" />
	</form>
<?php } ?>

<form id="dataUti" method="post" action="index.php?module=administrators&action=traite_administrators">
	<fieldset><legend>Création:</legend>
		<p>
			<h2>Nouvel utilisateur :</h2>
		<!-- Affichage des donn&egrave;es de l'utilisateur s&egrave;lectionn&egrave; -->
			Nom
			<input type="text" name="Nom" value="" size="15" />
			<br>
			Pr&egrave;nom
			<input type="text" name="Prenom" value="" size="15" />
			<br>
			Email
			<input type="text" name="Email" value="" size="15" />
			<br>
			Confirmation de l'adresse mail
			<input type="text" name="EmailVerif" value="" size="15" />
			<br>
			Login
			<input type="text" name="Login" value="" size="15" />
			<br>
			<input type="hidden" name="Uti_id" value="">
		<!-- Affichage les ue de l'utilisateur -->
			<table name="tableauUE">
			<thead><tr><th></th><th>Nom UE</th></tr></thead>
			<tbody>
			<?php
			$reponse = lectureUE();
			$compteurUE = 1;

			foreach ($reponse as $donnees) {
			?>
			<tr>
				<td><input type="checkbox" name="<?php echo $compteurUE; ?>"/></td>
				<td><label for="ue" class="float"><?php echo $donnees['ue_nom']; ?></label></td>
			</tr>
			<?php
			$compteurUE ++;
			}
			?>
			</tbody>
			</table>
		</p>
		<input type="submit" value="Créer" />
	</fieldset>
</form>


<script type="text/javascript">

	// Valide un utilisateur via ajax
	function valider_un_user(id){

		// appel ajax avec l'id en post
		$.ajax({
			 	type: "POST",
				url: 'index.php?module=administrators&action=valide_administrators_ajax',
				data: {
					users_id_uti : [id]
				},
				dataType: 'json',
				success : successValide,
				error : function() {

					// Faire une popup à l'utilisateur pour lui dire que tout c'est bien passé
					// Modifier le tableau pour cocher les éléments
					alert('Une erreur survenue, merci de réessayer');
				},
		});

	}

	// Valider plusieurs utilisateurs
	function valider_plusieurs_users() {
		// Récupérer les cochés
		var tabid = new Array();
		var i = 0;

		// Parcours les checkboxs
		$('table#tableauUti input[type=checkbox]:checked').each(function(){
				// Récupère l'id de la checkbox
				tabid[i] = $(this).attr('validid');
				i++;
		});

		// appel ajax avec l'id en post
		$.ajax({
			 	type: "POST",
				url: 'index.php?module=administrators&action=valide_administrators_ajax',
				data: {
					users_id_uti : tabid
				},
				dataType: 'json',
				success : successValide,
				error : function() {

					// Faire une popup à l'utilisateur pour lui dire que tout c'est bien passé
					// Modifier le tableau pour cocher les éléments
					alert('Une erreur survenue, merci de réessayer');
				},
		});


	}
	
	// Supprimer un utilisateur via ajax
	function delete_un_user(id){
		// appel ajax avec l'id en post
		$.ajax({
			 	type: "POST",
				url: 'index.php?module=administrators&action=delete_administrators_ajax',
				data: {
					users_id_uti : [id]
				},
				dataType: 'json',
				success : successDelete,
				error : function() {

					// Faire une popup à l'utilisateur pour lui dire que tout c'est bien passé
					// Modifier le tableau pour cocher les éléments
					alert('Une erreur survenue, merci de réessayer');
				},
		});

	}
	
	// Supprimer plusieurs utilisateurs
	function delete_plusieurs_users() {
		// Récupérer les cochés
		var tabid = new Array();
		var i = 0;

		// Parcours les checkboxs
		$('table#tableauUti input[type=checkbox]:checked').each(function(){
				// Récupère l'id de la checkbox
				tabid[i] = $(this).attr('validid');
				i++;
		});

		// appel ajax avec l'id en post
		$.ajax({
			 	type: "POST",
				url: 'index.php?module=administrators&action=delete_administrators_ajax',
				data: {
					users_id_uti : tabid
				},
				dataType: 'json',
				success : successDelete,
				error : function() {

					// Faire une popup à l'utilisateur pour lui dire que tout c'est bien passé
					// Modifier le tableau pour cocher les éléments
					alert('Une erreur survenue, merci de réessayer');
				},
		});


	}

	/**
	 * Fonction appelée en cas de succès de validation par requête ajax/
	 */
	function successValide(data) {

			// Faire une popup à l'utilisateur pour lui dire que tout c'est bien passé
			// alert(data.message);

			// Modifier le tableau pour cocher les éléments
			for (var x = 0; x < data.users_id_uti.length; x++) {

				// Affecte validé
				$('#tr_'+data.users_id_uti[x]+' > td.td_valide').html('Validé');
				// Désactiver le bouton
				$('#tr_'+data.users_id_uti[x]+' > td > .td_btn_valider').attr('disabled',true);
				// Décoche les checkebox
				$('table#tableauUti input[type=checkbox][validid='+data.users_id_uti[x]+']').removeAttr('checked');


      }
	}
	
	/**
	 * Fonction appelée en cas de succès de suppression par requête ajax/
	 */
	function successDelete(data) {

		// Faire une popup à l'utilisateur pour lui dire que tout c'est bien passé
		// alert(data.message);

		// Modifier le tableau pour cocher les éléments
		for (var x = 0; x < data.users_id_uti.length; x++) {
		
			// Supprimer du tableau les lignes sélectionné
			$('table#tableauUti tr_'+data.users_id_uti[x]).hide();
		
		}
		window.location = "<?php echo LOGIN_REDIRECT_ADMIN; ?>";
	}

	// Onclick button, toggle form
	$('#add_btn').click(function() {

		// hide / show form
		$('#dataUti').toggle("slow");

	});


</script>
