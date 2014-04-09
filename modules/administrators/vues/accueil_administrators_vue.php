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

			foreach ($reponse as $key => $donnees) {
			?>
				<tr id="tr_<?php echo $donnees['uti_id'];?>">
					<td>
						<!-- Effectuer le traitement AJAX pour afficher les données de la ligne coché dans le formulaire ci-dessous-->
						<input validid="<?php echo $donnees['uti_id'];?>" type="checkbox" />
					<td id='uti_nom_<?php echo $donnees['uti_id'];?>'>
						<?php echo $donnees['uti_nom']; ?>
					</td>
					<td id='uti_prenom_<?php echo $donnees['uti_id'];?>'>
						<?php echo $donnees['uti_prenom']; ?>
					</td>
					<td id='uti_mail_<?php echo $donnees['uti_id'];?>'>
						<?php echo $donnees['uti_mail']; ?>
					</td>
					<td id='uti_login_<?php echo $donnees['uti_id'];?>'>
						<?php echo $donnees['uti_login']; ?>
					</td>
					<td class="td_valide">
						<?php
						if ($donnees['uti_is_valide'])
						{ echo 'Validé'; }
						else { echo 'Non validé';}
						?>
					</td>
					<td>
						<button class='td_btn_modifier' onclick="setCreateForm(<?php echo $donnees['uti_id'];?>);" >Modifier</button>
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

	<!-- Bouttons -->
	<button id="valide_multi_user" onclick="valider_plusieurs_users();">Valider sélection</button>
	<button id="add_btn"  onclick="setDeleteForm();">Nouveau</button>
	<button id="delete_multi_user" onclick="delete_plusieurs_users();">Supprimer sélection</button>

<?php if (DEBUG_AUTO_UTI){ ?>
	<form id= "insert_auto_uti" action="index.php?module=administrators&action=insert_auto_uti_debug" method="post">
		<input type="text" name="Nb_Uti" value="" size="3" />
		<input type="submit" value="Auto Utilisateur" />
	</form>
<?php } ?>

<form id="dataUti" method="post" action="index.php?module=administrators&action=traite_administrators">
	<fieldset><legend id="creation_from_legend">Création:</legend>
		<p>
			<h2 id="creation_from_title">Nouvel utilisateur :</h2>

		<!-- Affichage des donn&egrave;es de l'utilisateur s&egrave;lectionn&egrave; -->
			Nom
			<input id="creation_from_nom" type="text" name="Nom" size="30" ></input>
			<br>
			Pr&egrave;nom
			<input id="creation_from_prenom" type="text" name="Prenom" size="30" ></input>
			<br>
			Email
			<input id="creation_from_mail" type="text" name="Email" size="30" ></input>
			<br>
			Confirmation de l'adresse mail
			<input id="creation_from_mailverif" type="text" name="EmailVerif" size="30" ></input>
			<br>
			Login
			<input id="creation_from_login" type="text" name="Login" size="30" ></input>
			<br>
			<input id="creation_from_uti_id" type="hidden" name="Uti_id" ></input>

		<!-- Affichage les ue de l'utilisateur -->
			<table id="tableauUE">
			<thead><tr><th></th><th>Nom UE</th></tr></thead>
			<tbody>
			<?php
			$reponse = lectureUE();

			foreach ($reponse as $donnees) {
			?>
			<tr id="tr_ue_"<?php echo $donnees['ue_id'];?> value="<?php echo $donnees['ue_id'];?>" >
				<td><input id="<?php echo $donnees['ue_id']; ?>" type="checkbox" validid_check_ue="<?php echo $donnees['ue_id']; ?>" /></td>
				<td><label for="ue" class="float"><?php echo $donnees['ue_nom']; ?></label></td>
			</tr>
			<?php
			}
			?>
			</tbody>
			</table>
		</p>
		<input id="creation_from_uti_submit" type="submit" value="Créer" />
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

					// Modifier le tableau pour cocher les éléments
					alert('Une erreur survenue, merci de réessayer');
				},
		});
	}

	/**
	 * Fonction appelée en cas de succès de validation par requête ajax/
	 */
	function successValide(data) {

			// Popup à l'utilisateur pour lui dire que tout c'est bien passé
			alert(data.message);

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

		alert(data.message);

		// Modifier le tableau pour cocher les éléments
		for (var x = 0; x < data.users_id_uti.length; x++) {

			// Supprimer du tableau les lignes sélectionné
			$('table#tableauUti tr_'+data.users_id_uti[x]).hide();

		}
		window.location = "<?php echo LOGIN_REDIRECT_ADMIN; ?>";
	}

	/**
	 * Set creation formulaire utilisateur
	 */
	function setCreateForm(id) {

		var nom = $('td#uti_nom_'+id).html();
		var prenom = $('td#uti_prenom_'+id).html();
		var mail = $('td#uti_mail_'+id).html();
		var login = $('td#uti_login_'+id).html();

		$('#creation_from_title').html('Modification de l\'utilisateur '+login);
		$('#creation_from_nom').val($.trim(nom));
		$('#creation_from_prenom').val($.trim(prenom));
		$('#creation_from_mail').val($.trim(mail));
		$('#creation_from_mailverif').val($.trim(mail));
		$('#creation_from_login').val($.trim(login));
		$('#creation_from_uti_id').val($.trim(id));
		$('#creation_from_uti_submit').val('Modifier');
		$('#creation_from_legend').html('Modification');

		// Appel ajax avec l'id en hidden donné en paramètre
		$.ajax({
			 	type: "POST",
				url: 'index.php?module=administrators&action=tabUE_administrators_ajax',
				data: {
					ue_id_uti : id
				},
				dataType: 'json',
				success : successCreateForm,
				error : function() {
					alert(data.message);
				},
		});

		$('#dataUti').show("slow");

	}

	// Onclick button, toggle form and clean
	function setDeleteForm() {

		$('#creation_from_title').html('Nouvel utilisateur');
		$('#creation_from_nom').val("");
		$('#creation_from_prenom').val("");
		$('#creation_from_mail').val("");
		$('#creation_from_mailverif').val("");
		$('#creation_from_login').val("");
		$('#creation_from_uti_id').val("");
		$('#creation_from_uti_submit').val('Créer');
		$('#creation_from_legend').html('Création');

		// Modifier le tableau d'ue pour décocher les éléments
		$('table#tableauUE input[type=checkbox]').each(function(){
			// Décoche les checkbox des ue
			$(this).removeAttr('checked');
		});

		// hide / show form
		$('#dataUti').show("slow");
	};

	/**
	* Fonction appelée en cas de succès de création / modification par requête ajax/
	*/
	function successCreateForm(data) {

		// Message pour le bon déroulemant de l'opération
		// alert(data.message);

		// Modifier le tableau pour cocher les éléments
		for (var x = 0; x < data.ue_id_uti.length; x++) {

			// Coche les checkbox correspondant au ue obtenu
			$('table#tableauUE input[type=checkbox][validid_check_ue='+data.ue_id_uti[x]+']').prop('checked', true);

		}
	}


</script>
