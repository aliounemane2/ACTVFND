<?php
	require_once("Finder.php");
	require_once("Objet.php");
	require_once("Owner.php");
    require_once("Methodes.php");

    Class Cas {
		/*Variables d'instances */
		private $_id_cas;
		private $_ddn_cas;
		private $_ddv_cas;
		private $_statut_cas;
		private $_idFinder;
		private $_idObjet;
		private $_idOwner;
		
		/* Déclaration de notre constructeur d'initialisation */
		function __construct($idFinder, $idObjet, $idOwner) {
			$this->_id_cas = uniqid();
			$this->_ddn_cas = $this->todayDateTime();
			$this->_ddv_cas = $this->dateExpiration($this->getDdnCas());
			$this->_statut_cas = false;
			$this->_idFinder = $idFinder;
			$this->_idObjet = $idObjet;
			$this->_idOwner = $idOwner;
		}
	
		/*GETTERS & SETTERS*/
		public function getIdCas() {return $this ->_id_cas;}
		public function getDdnCas() {return $this->_ddn_cas;}
		public function getDdvCas() {return $this->_ddv_cas;}
		public function getStatutCas() {return $this->_statut_cas;}
		public function getIdFinder() {return $this->_idFinder;}
		public function getIdObjet() {return $this->_idObjet;}
		public function getIdOwner() {return $this->_idOwner;}
		
		public function setIdCas($newId) {$this->_id_cas = $newId;}
		public function setDdnCas($newDdn) {$this->_ddn_cas = $newDdn;}
		public function setDdvCas($newDdv) {$this->_ddv_cas = $newDdv;}
		public function setStatutCas($newStatut) {$this->_statut_cas = $newStatut;}
		
		/* MEHTODES ET SERVICES */
		//permet de former un cas automatiquement avec les données recues d'une requete
		public static function parseCas($id, $naissnace, $ddv, $statut, $idFinder, $idObjet, $idOwner){
			$casTmp = new Cas($idFinder, $idObjet, $idOwner);
			$casTmp->setIdCas($id); $casTmp->setDdnCas($naissnace);
			$casTmp->setDdvCas($ddv); $casTmp->setStatutCas($statut);
			return $casTmp;
		}

		//permet d'inserer notre cas dans notre BD en ligne
		public function insertionCas($connexion) {
            $feedback = false;
			if($connexion!=null){
				$insertion2 = $connexion->prepare('INSERT INTO cas(id_cas,datenaiss_cas,dureevie_cas,statut_cas,id_finder,
					id_objet,id_owner) VALUES(:id_cas,CURRENT_TIMESTAMP(),:dureevie_cas,:statut_cas,:id_finder,:id_objet,:id_owner)');
                $insertion2->bindValue(":id_cas", $this->getIdCas(), PDO::PARAM_STR);
                $insertion2->bindValue(":dureevie_cas", $this->getDdvCas(), PDO::PARAM_STR);
                $insertion2->bindValue(":statut_cas", $this->getStatutCas(), PDO::PARAM_STR);
                $insertion2->bindValue(":id_finder", $this->getIdFinder(), PDO::PARAM_STR);
                $insertion2->bindValue(":id_objet", $this->getIdObjet(), PDO::PARAM_STR);
                $insertion2->bindValue(":id_owner", $this->getIdOwner(), PDO::PARAM_STR);
                $insertion2->execute();
                if($insertion2->rowCount()>=1) $feedback = true;
			}
            return $feedback;
        }
		
		//permet donc de recuperer l'objet qui se trouve dans le cas
		public function getObjetInCas($connexion) {
			$objetRecupere = 0;
			$requete = $connexion->prepare('SELECT * FROM objet WHERE id_objet = :id');
			$requete->bindValue(':id', $this->_idObjet, PDO::PARAM_STR);
			$requete->execute();
			$ressources = $requete->fetch(PDO::FETCH_ASSOC);

			if (!empty($ressources)){
				$objetRecupere = new Objet($ressources['nature_objet'],$ressources['addr_objet'],$ressources['details_objet']);
			    $objetRecupere->setIdObjet($ressources['id_objet']);
			}
			return $objetRecupere;
		}
		
		//permet de recuperer le finder qui se trouve dans le cas
		public function getFinderInCas($connexion) {
			$finderRecupere = 0;
			$requete = $connexion->prepare('SELECT * FROM finder WHERE id_finder = :id');
			$requete->bindValue(':id', $this->_idFinder, PDO::PARAM_STR);
			$requete->execute();
			$ressources = $requete->fetch(PDO::FETCH_ASSOC);

			if (!empty($ressources)){
				$finderRecupere = new Finder($ressources['nom_finder'],$ressources['prenom_finder'], 
                $ressources['tel_finder'], $ressources['addr_finder'], $ressources['mail_finder']);
			    $finderRecupere->setId($ressources['id_finder']);
			}
			return $finderRecupere;
		}
		
		//permet de recuperer l'owner qui se trouve dans le cas
		public function getOwnerInCas($connexion) {
			$ownerRecupere = 0;
			$requete = $connexion->prepare('SELECT * FROM owner WHERE id_owner = :id');
			$requete->bindValue(':id', $this->_idOwner, PDO::PARAM_STR);
			$requete->execute();
			$ressources = $requete->fetch(PDO::FETCH_ASSOC);

			if (!empty($ressources)){
				$ownerRecupere = new Owner($ressources['nom_owner'],$ressources['prenom_owner'], 
                $ressources['tel_owner'], $ressources['addr_owner'], $ressources['mail_owner']);
		        $ownerRecupere->setId($ressources['id_owner']);
			}
			return $ownerRecupere;		
		}

        /*recuperation de tous les id dans le cas*/
        public static function getAllIdsInCas($connexion, $id_cas){
            $res = 'NULL';
            if($connexion!=null){
                $requete = $connexion->prepare("SELECT id_finder, id_objet, id_owner FROM cas WHERE id_cas = :id");
                $requete->bindValue(":id", $id_cas, PDO::PARAM_STR);
                $requete->execute();
                $res = $requete->fetch(PDO::FETCH_ASSOC);
            }
            return $res;
        }

        /*function test si finder dans le cas nest pas lié a un autre cas en cours*/
        public static function isFinderInCasLieAutreCas($connexion, $id_f){
            $linked = false;
            if($connexion!=null){
                $requete = $connexion->prepare("SELECT COUNT(id_cas) AS nbCasLie FROM cas WHERE cas.id_finder = :finder AND cas.statut_cas=0");
                $requete->bindValue(":finder", $id_f, PDO::PARAM_STR);
                $requete->execute();
                $donnee = $requete->fetch(PDO::FETCH_ASSOC);
                $nbre = $donnee['nbCasLie'];
                if($nbre>1) $linked = true;
            }
            return $linked;
        }
		
		//permet de détruire le cas apres archivage de cette derniere
		public static function supprimerCas($connexion, $idASupprimer) {
			$resultat = false;
			if($connexion!=null){

				//d'abord on archive le cas avnt de le supprimer
				//$this->archiverCas($connexion);

                /*recup des id qui sont dans le cas*/
                $tab_id = self::getAllIdsInCas($connexion, $idASupprimer);
                if($tab_id!='NULL') {
                    //suppression du cas en tant que tel
                    $requete = $connexion->prepare("DELETE FROM cas WHERE id_cas = :id");
                    $requete->bindValue(":id", $idASupprimer, PDO::PARAM_STR);
                    $requete->execute();

                    if ($requete->rowCount()==1) {
                        //suppression du finder, owner, et de l'objet qui etaient dans notre cas
                        if(!self::isFinderInCasLieAutreCas($connexion, $tab_id['id_finder'])) {
                            Finder::suppressionRapide($connexion, $tab_id['id_finder']);
                        }
                        Owner::suppressionRapide($connexion, $tab_id['id_owner']);
                        Objet::suppressionRapide($connexion, $tab_id['id_objet']);
                        $resultat = true; // true suppression ok
                    } else
                        echo "<br /><br /> => Le cas ne peut pas être supprimé de la base de données !";
                }
			}
			//**** Important toujours reload la page apres suppression ****//
			return $resultat;
		}

		//permet d'archiver notre cas dans notre bd local (cloud)
		public function archiverCas($connexion) {
			$resultat=0;
			
			return $resultat; //0 = erreur / 1 = succes	
		}
		
		//permet de modifier les elements composants notre cas
		public static function modifierCas($connexion, $tableau) {
            if($connexion!=null){
                $modification = $connexion->prepare('UPDATE cas SET datenaiss_cas = :dns,dureevie_cas = :ddv,statut_cas = :statut WHERE id_cas = :id_cas');
                $modification->execute(array(
                    ':id_cas' => $tableau['id_cas'],
                    ':dns' => $tableau['dns'],
                    ':ddv' => $tableau['ddv'],
                    ':statut' => $tableau['statut'],
                ));
            }
        }
		
		//permet de décrire un cas, cad afficher toutes les infos contenues dans le cas
		public function informationsCas() {
			echo "<br><br>".$this->getIdCas()."<br>".$this->getDdnCas()."<br>".$this->getDdvCas().
			"<br>".$this->getStatutCas()."<br>".$this->getIdFinder()."<br>".$this->getIdObjet().
			"<br>".$this->getIdOwner()."<br> Date expiration : ".$this->dateExpiration($this->getDdnCas()).
			"<br>".$this->nbJoursRestants()." Jours restants";
		}
		
		//verification etat du cas ce qui nous permettra de l'archiver et de la detruire en cas d'expiration
		public function nbJoursRestants() {
			$dateExp = new DateTime($this->getDdvCas());
			$dateNaiss = new DateTime($this->getDdnCas());
			$restant = $dateNaiss->diff($dateExp);
			return ($restant->format('%R%a'));
		}

		//calcul et retourne la date d'expiration du cas
		public function dateExpiration($naissance){ //2015-02-11 00:00:00
			$creation = substr($naissance, 0, 10);  // extraction de la date 2015-02-11
			$dateNaiss = new DateTime($creation);	//string -> DateTime
			$dateNaiss->add(new DateInterval('P30D')); //Plus 30 Days
			return ($dateNaiss->format('Y-m-d')); //formattage de la date
		}

		//retourne date & heure UTC
		public function todayDateTime(){
			date_default_timezone_set("UTC");
			return date("Y-m-d H:i:s", time());
		}

        /*calcul du nombre de cas valides dans la bd*/
        public static function getNombreCasActif($connexion){
            $requete = $connexion->prepare("SELECT COUNT(id_cas) AS nbCas FROM cas WHERE cas.statut_cas=0");
            $requete->execute();
            $ressources = $requete->fetch(PDO::FETCH_ASSOC);
            return $ressources['nbCas'];
        }

        //cas expires
        public static function getNombreCasExpires($connexion){
            $requete = $connexion->prepare("SELECT COUNT(id_cas) AS nbCas FROM cas WHERE cas.statut_cas=1");
            $requete->execute();
            $ressources = $requete->fetch(PDO::FETCH_ASSOC);
            return $ressources['nbCas'];
        }

        public static function modelAffichage($tab, $numero){
            return "<div class=\"col-lg-2\" id=\"sys-info-block\">
                <div>
                    <div><label>Id Cas : </label><span>".$tab['id_cas']."</span></div>
                    <div><label>Objet : </label><span>".$tab['nature_objet']."</span></div>
                    <div><label>Finder : </label><span class=\"green-fonce-color\">".$tab['prenom_finder']."</span></div>
                </div>
                <div>
                    <footer class=\"pull-left\">
                        <label class=\"dropdown\">
                            <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Plus<i class=\"fa fa-caret-down fa-fw\"></i></a>
                            <ul class=\"dropdown-menu\">
                                <li><a data-toggle=\"modal\" href=\"#finder".$numero."\"><i class=\"fa fa-eye fa-fw blue-color\"></i>Consulter</a></li>
                                <li><a href=\"cas_modif_file.php?action=modif&status=ok&cas_hash=".$tab['id_cas']."&from=actifs\"><i class=\"fa fa-edit fa-fw orange-color\"></i>Modifier</a></li>
                                <li><a href=\"cas_actifs_liste.php?action=del&status=ok&cas_hash=".$tab['id_cas']."\"><i class=\"fa fa-trash fa-fw red-color\"></i>Supprimer</a></li>
                            </ul>
                        <label>
                    </footer>
                </div>
            </div>";
        }
		
	} // Fin de la classe Cas
?>