<?php
	// on se connecte à notre base
	$connexion = new PDO('mysql:host=localhost;dbname=ecole','root','');
	
	//recuperation du nombre de ressource dans la bd
	$requete1 = $connexion->prepare('SELECT COUNT(id) AS nbCatalogue FROM catalogue');
	$requete1->execute();
	$donnes = $requete1->fetch(PDO::FETCH_ASSOC);
	$nbCatalogue = $donnes['nbCatalogue'];

	//définistion des variables necessaires
	$nbElementParPage = 12;
	$nbTotalPage = ceil($nbCatalogue/$nbElementParPage);
	$pageCourrante = 1;

	//définition de la variable url page
	if(isset($_GET['page'])&&($_GET['page']>0&&$_GET['page']<$nbTotalPage+1))
		$pageCourrante = $_GET['page'];
	else
		$pageCourrante = 1; 

	//selection toutes les ressources dans la bd	
	$requete = $connexion->prepare("SELECT * FROM catalogue LIMIT :debut, :fin");// WHERE id_objet = :id');
	$requete->bindValue(':debut', intval(($pageCourrante-1)*$nbElementParPage), PDO::PARAM_INT);
	$requete->bindValue(':fin', intval($nbElementParPage), PDO::PARAM_INT);
	$requete->execute();
?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Les livres de la bibliothèque</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

		<script src="js/jquery-dev.js"></script>
		<script src="js/bootstrap.js"></script>
		<style>
		  /* le padding et les bordure n'augmente pas la largeur de l'element */
			*, *:before, *:after {
			  -moz-box-sizing: border-box;
			  -webkit-box-sizing: border-box;
			  box-sizing: border-box;
			}

			/* Disposition */
			.container ul {
				list-style: none;
				margin: 0 0 0 0;
				padding: 0 0 0 0;
				clear: both;
			}

			.container ul .item_objet {
			  	width: 100%;
			  	height: 12em;
				position: relative;
				float: left;
				margin: 0 0 0 0;
				padding: 0 0 15% 0;
				transition: 0.8s ease;
				//box-shadow: 0px 1px 1px 0px #ddd; 
				box-shadow: 0 1px 2px rgba(0,0,0,.2);
				margin-right: 2em;
				margin-bottom: 3em;
				
			}

			.container ul .item_objet:hover span {
			 	height: 60%;
			 	white-space :normal ;  /*remettre le retour à la ligne à la normal*/
			}

			.container ul .item_objet img {
			   	max-width: none;
			    width: 100%;
			  	position: absolute;
			  	top: 0;
			  	left: 0;
			}

			.container ul .item_objet span {
			    white-space : nowrap;     /*//permet de forcer le non retour à la ligne*/
			    overflow : hidden;        /*//permet de masquer si ça dépasse*/
			    text-overflow : ellipsis; /*//permet de rajouter ... si ça dépasse*/

			    width: 100%;
			    //height: 0.2rem;
			    height: 2.5rem;
			    line-height: 2rem;
			    position: absolute;
			    bottom: 0;
			    left: 0;
			    padding: 0 0.5rem;
			    font-size: 1.5rem;
			    color: #fff;
			    background: rgba(0, 0, 0, 0.2);
			    transition: 0.4s ease;
			}
			/*****Find de notre grille********/

			.jourest{background-color:#4cae4c ;}
			.vie{background-color:#d58512 ;}
			.plus{background-color: #2e6da4;}

			.retour{clear: both;}
			.item{margin-right: 5px;}
			li>a.back{margin-right: 5px;}
			.item:hover{color: #fff;}

			.photo{width: 150px;height: 18%;text-align: center;line-height: 75px;background-color: #efe;}
			div.modal-body>div.last{width: 50%;height: 50px;}
		</style>
	</head>

	</body>
		<div class="container">
			Les différents livres de la bibliothèque :<br /><br /><br /><br />
			<!--<table border="0" cellspacing="2" width="600px" height="200px">
				<tr style="background-color:#ddd;"><th>Titre</th><th>Description</th></tr>
				<?php
					/*
					while ($ressources = $requete->fetch(PDO::FETCH_ASSOC)) {
						echo '<tr>
							<td>'.htmlentities(trim($ressources['titre'])).'</td>
							<td>'.htmlentities(trim($ressources['description'])).'</td>
						</tr>';
					}
				*/?>
			</table>-->

			<?php
				/////// ------ Définition de notre grille d'affichage ----/////>
				$nbreParLigne = 6;
				$numero = 1;
				echo "<div class=\"row\">";
				echo "<ul class=\"list-inline\">";
				while ($ressources = $requete->fetch(PDO::FETCH_ASSOC)) {

					if($numero%$nbreParLigne==1&&$numero!=1){ // s'il rest 1 --> c'est le nombre juste apres $nbParLigne
						echo "<div class=\"col-md-2 col-sm-3 col-xs-4 cadr".$numero.
						" retour\">
						<li class=\"item_objet\">
							<a data-toggle=\"modal\" href=\"#infos".$numero."\">
								<img src=\"images/item_object.png\" />
								<span>".htmlentities(trim($ressources['titre']))."</span>
							</a>
						</li>	
						</div>";					
						
					}else{
						echo "<div class=\"col-md-2 col-sm-3 col-xs-4 cadr".$numero.
						"\">
						<li class=\"item_objet\">
							<a data-toggle=\"modal\" href=\"#infos".$numero."\">
								<img src=\"images/item_object.png\" />
								<span>".htmlentities(trim($ressources['titre']))."</span>
							</a>
						</li>
						</div>";
					}
			
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
												<div class=\"col-md-12\">Id : ".htmlentities(trim($ressources['id']))."</div>
												<div class=\"col-md-12\">Titre : ".htmlentities(trim($ressources['titre']))."</div>
												<div class=\"col-md-12\">Description : ".htmlentities(trim($ressources['description']))."</div>
												<div class=\"col-md-12\">Description : ".htmlentities(trim($ressources['description']))."</div>
												<div class=\"col-md-12\">Description : ".htmlentities(trim($ressources['description']))."</div>
											</div>
										</div>
									</div>
									<div class=\"row\">
										<div class=\"col-md-offset-4 col-md-8\">
											<div class=\"trait\"></div>	
											<div class=\"badge jourest\"><span class=\"glyphicon glyphicon-arrow-down\"></span> 27jours</div>
											<div class=\"badge vie\"><span class=\"glyphicon glyphicon-fire\"></span> Actif</div>
											<div class=\"badge plus\"><span class=\"glyphicon glyphicon-plus\"></span> Autres</div>
										</div>
									</div>
									<div class=\"last\">sde est tout</div>
								</div>
							</div>
						</div>
					</div>";
					$numero++;
				}
				echo "</ul>";
				echo "</div>";
			?>
			
			<?php
				///////--------- Définition de notre controleur de navigation ----//////
				echo "<ul class=\"pagination\">";
				echo $pageCourrante;

				//concerant notre click sur le bouton précédent
				if ($pageCourrante==1)
					echo "<li class=\"previous\"><a class=\"back\" href=\"mur.php?page=".
					($nbTotalPage)."\"><span class=\"glyphicon glyphicon-backward\"></span> Précédent</a></li>";
				elseif($pageCourrante>1){
					echo "<li class=\"previous\"><a class=\"back\" href=\"mur.php?page=".
					($pageCourrante-1)."\"><span class=\"glyphicon glyphicon-backward\"></span> Précédent</a></li>";
				}

				for ($i=1; $i <= $nbTotalPage; $i++) {
					if($i==$pageCourrante)
						echo "<li class=\"active\"><a class=\"item\" href=\"mur.php?page=$i\">$i</a></li>";
					else
						echo "<li><a class=\"item\" href=\"mur.php?page=$i\">$i</a></li>";
				}

				//concerant notre click sur le bouton suivant
				if ($pageCourrante==$nbTotalPage)
					echo "<li class=\"next\"><a href=\"mur.php?page=1\">Suivant <span class=\"glyphicon glyphicon-forward\"></span></a></li>";
				elseif ($pageCourrante<$nbTotalPage)
					echo "<li class=\"next\"><a href=\"mur.php?page=".($pageCourrante+1)."\">Suivant <span class=\"glyphicon glyphicon-forward\"></span></a></li>";

				echo "</div>";
			?>
			</div>
		</div>
	</body>
</html>