<?php
	require_once("../app_core/Finder.php");
	require_once("../app_core/Objet.php");
	require_once("../app_core/Owner.php");
	require_once("../app_core/Cas.php");
    require_once("../app_core/Methodes.php");

    // on se connecte à notre base
	$connexion = new PDO('mysql:host=localhost;dbname=activfinddb','root','');
    if(isset($_GET['hash']) && $_GET['hash']=="quick")
        $mot_cle = $_GET['mot'];
    else
        $mot_cle = htmlentities($_SESSION['mot_cle']);
?>
<div class="rech_facile_up row">
	<div class="col-lg-12 vertical-center">
		<img class="img-responsive" src="../public/images/wouti_400_80.png" />
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 rech_facile_up_input vertical-center">
		<form method="POST" class="res-front-form" action="index.php?78dfvg552&f=rechercher#00derf">
			<input type="text" id="recsherche" name="champ_rech" autocomplete="on" value="<?php echo $mot_cle;?>" placeholder="Qu'avez-vous perdu ?"/>
			<button type="submit" name="btn_rech" class="btn btn-default visible-sm-inline visible-md-inline visible-lg-inline">Go</button>
		</form>
	</div>
</div>
<?php
	//recuperation du nombre de ressource dans la bd
	if($mot_cle=="all"){
		$texte  = "SELECT COUNT(id_cas) AS nbResultat FROM cas, objet, finder WHERE ";
		$texte .= "objet.id_objet = cas.id_objet AND cas.id_finder = finder.id_finder";	
	}
	else{
		$texte  = "SELECT COUNT(id_cas) AS nbResultat FROM cas, objet, finder WHERE objet.nature_objet LIKE :mot ";
		$texte .= "AND objet.id_objet=cas.id_objet AND cas.id_finder=finder.id_finder";
	}
	$requete1 = $connexion->prepare($texte);
    $requete1->bindValue(':mot','%'.$mot_cle.'%', PDO::PARAM_STR);
    $requete1->execute();
	$donnes = $requete1->fetch(PDO::FETCH_ASSOC);
	$nbResultat = $donnes['nbResultat'];
	if ($nbResultat==0) {
		echo "<img id=\"no_resultats_img\" alt=\"pas de résultats\" src=\"../public/images/no_resultats.png\" />";
		echo "<div class=\"alert alert-danger no_resultats_text\">Votre objet <strong>$mot_cle</strong> n'a pas été trouvé ! Gardez confiance et venez revoir dans quelques jours ...</div>";
	}elseif($nbResultat>0){
		
		//définistion des variables necessaires
		$nbElementParPage = 12;
		//$nbTotalPage = ceil($nbResultat/$nbElementParPage);
        //echo $nbTotalPage;
		//$pageCourrante = 1;
		
		//définition de la variable url page
		if(isset($_GET['page']))//&&($_GET['page']>0&&$_GET['page']<$nbTotalPage+1))
			$pageCourrante = $_GET['page'];
		else
			$pageCourrante = 1; 

		//selection toutes les ressources dans la bd
		//$mot_cle = $_POST['champ_rech'];
		if($mot_cle=="all"){
			$texte  = "SELECT * FROM cas, objet, finder WHERE cas.id_objet=objet.id_objet AND ";
			$texte .= "cas.id_finder=finder.id_finder LIMIT :debut, :fin";
		}else{
			$texte  = "SELECT * FROM cas, objet, finder WHERE cas.id_objet=objet.id_objet AND ";
			$texte .= "cas.id_finder=finder.id_finder AND objet.nature_objet LIKE :mot LIMIT :debut, :fin";
		}
		$requete = $connexion->prepare($texte);
        if($mot_cle!="all") $requete->bindValue(':mot','%'.$mot_cle.'%', PDO::PARAM_STR);
        $requete->bindValue(':debut', intval(($pageCourrante-1)*$nbElementParPage), PDO::PARAM_INT);
		$requete->bindValue(':fin', intval($nbElementParPage), PDO::PARAM_INT);
		$requete->execute();

		echo "<span class=\"help-block vertical-center\"><strong class='w_activeMenu'>".$nbResultat." Objet";if($nbResultat>1) echo 's';
        echo"</strong>&nbsp;correspondant";if($nbResultat>1) echo 's';
        echo " à votre recherche<br></span>";

		/////// ------ Définition de notre grille d'affichage ----/////>
		$nbreParLigne = 6;
		$numero = 1;
		echo "<div class=\"row\">";
		echo "<ul class=\"list-inline col-lg-12\">";
		while ($ressources = $requete->fetch(PDO::FETCH_ASSOC)) {

			/*-- Formation des differents objets --*/
			$nvObjet = Objet::parseObjet(htmlentities(trim($ressources['id_objet'])), htmlentities(trim($ressources['nature_objet'])), htmlentities(trim($ressources['addr_objet'])), htmlentities(trim($ressources['details_objet'])));
			
			$nvFinder = Finder::parseFinder(htmlentities(trim($ressources['id_finder'])), htmlentities(trim($ressources['nom_finder'])), htmlentities(trim($ressources['prenom_finder'])), htmlentities(trim($ressources['tel_finder'])), 
			htmlentities(trim($ressources['addr_finder'])), htmlentities(trim($ressources['mail_finder'])));
			
			/*nvOwner = Owner::parseOwner(htmlentities(trim($ressources['id_finder'])), htmlentities(trim($ressources['nom_finder'])), htmlentities(trim($ressources['prenom_finder'])), htmlentities(trim($ressources['tel_finder'])), htmlentities(trim($ressources['addr_finder'])), htmlentities(trim($ressources['mail_finder'])));*/
			
			$nvCas = Cas::parseCas(htmlentities(trim($ressources['id_cas'])), htmlentities(trim($ressources['datenaiss_cas'])),
				htmlentities(trim($ressources['dureevie_cas'])), htmlentities(trim($ressources['statut_cas'])),
				htmlentities(trim($ressources['id_finder'])), htmlentities(trim($ressources['id_objet'])),
				htmlentities(trim($ressources['id_owner'])));

/*			if($numero%$nbreParLigne==0&&$numero!=1){ // s'il rest 1 --> c'est le nombre juste apres $nbParLigne
				echo "<div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 cadr".$numero." retour\">
				<li class=\"item_objet\">
					<a data-toggle=\"modal\" href=\"#infos".$numero."\">
						<img src=\"images/item_object.png\" />
						<span>".$nvObjet->getNatureObjet()."<br>
							retrouvé vers : quartier 
						</span>
					</a>
				</li>	
				</div>";
				
			}else{*/
				echo "<div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2 cadr".$numero."\">
				<li class=\"item_objet\">
					<a data-toggle=\"modal\" href=\"#infos".$numero."\">
						<img src=\"images/item_object.png\" />
						<span>".html_entity_decode($nvObjet->getNatureObjet())."<br> retrouvé vers <strong>".$nvObjet->getAddrObjet()."</strong></span>
					</a>
				</li>
				</div>";
			//}

			echo "<div class=\"modal fade\" id=\"infos".$numero."\">
				<div class=\"modal-dialog\">
					<div class=\"modal-content\">
						<div class=\"modal-header\">
							<button type=\"button\" class=\"close\" data-dismiss=\"modal\">x</button>
							<h3 class=\"modal-title\">Informations</h3>
						</div>
						<div class=\"modal-body row\">
							<div class=\"row\">
								<div class=\"col-md-4\">
									<div class=\"photo\">Photo</div>
								</div>
								<div class=\"col-md-8\">
									<div class=\"row\">
										<div class=\"col-md-12\">Naissance Cas : ".$nvCas->getDdnCas()."</div>
										<div class=\"col-md-12\">Expire le : ".$nvCas->getDdvCas()."</div>
										<div class=\"col-md-12\">Statut : ".$nvCas->getStatutCas()."</div>
					
										<div class=\"col-md-12\">Nature : ".html_entity_decode($nvObjet->getNatureObjet())."</div>
										<div class=\"col-md-12\">Adresse retrouvé : ".$nvObjet->getAddrObjet()."</div>
										<div class=\"col-md-12\">Détails : ".$nvObjet->getDetailsObjet()."</div>

										<div class=\"col-md-12\">Nom Complet : ".$nvFinder->getPrenom()." ".$nvFinder->getNom()."</div>
										<div class=\"col-md-12\">Adresse ramasseur : ".$nvFinder->getAddr()."</div>
										<div class=\"col-md-12\">Télephone : ".$nvFinder->getTel()."</div>
									</div>
								</div>
							</div>
							<div class=\"row\">
								<div class=\"col-md-offset-4 col-md-8\">
									<div class=\"trait\"></div>	
									<div class=\"badge jourest\">".$nvCas->nbJoursRestants()."<span class=\"glyphicon glyphicon-arrow-down\"></span> 
									</div>
									<div class=\"badge vie\"><span class=\"glyphicon glyphicon-fire\"></span> Actif</div>
									<div class=\"badge plus\"><span class=\"glyphicon glyphicon-plus\"></span> Autres</div>
								</div>
							</div>
							<br>
						</div>
					</div>
				</div>
			</div>";
			$numero++;
		}
		echo "</ul>";
		echo "</div>";

			///////--------- Définition de notre controleur de navigation ----//////
        echo '<div class="row vertical-center">'.
            ctrl_pagine($nbResultat, $pageCourrante, $nbElementParPage, 'index.php?78dfvg552&f=results&page=')
        .'</div>';
	}
?>