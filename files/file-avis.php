<?php
    //@session_start();
    require_once '../app_core/Methodes.php';
    require_once('../app_core/Connexion.php');
    $con = new ConnexionBd();
    $connexion = $con->getConnexion();
    $success = false;

	if(isset($_POST['bt_envoyer'])){
        $requete = $connexion->prepare('INSERT INTO avis VALUES (:id,:nom_comp,:email,:message)');
        $requete->execute(array(
            'id' => 'NULL',
            'nom_comp' => nettoyer($_POST['nom_complet']),
            'email' => nettoyer(trim($_POST['email'])),
            'message' => nettoyer($_POST['message'])
        ));
        /*feedback execution requete*/
        if($requete->rowCount()==1)
            $success = true;

        header("Location:../public/");
	}

?>
		<style type="text/css">
			form{width:100%; padding: 0.5em;}
			textarea.ta_avis{resize:none;}
		</style>
		<div class="avis_form">
			<form method="POST" action="../files/file-avis.php">
				<fieldset>
					<legend>Avis / Suggestions</legend>
					<div class="form-group">
						<span>Nom Complet</span>
						<input type="text" name="nom_complet" class="form-control" placeholder="Nom complet ou pseudo" required/>
					</div>
					<div class="form-group">
						<span>E-mail</span>
						<input type="email" name="email" class="form-control" placeholder="Votre email pour vous y répondre" required/>
					</div>
					<div class="form-group">
						<span>Votre message</span>
						<textarea rows="4" name="message" class="ta_avis form-control" placeholder="Que pensez-vous de la plateforme ?" required></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success form-control" name="bt_envoyer">Envoyer <span class="glyphicon 
						glyphicon-ok-sign" style="color:white;"></span></button>
					</div>
				</fieldset>
			</form>
		</div>