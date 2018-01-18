<?php
	Class Objet{
		
		/*Variables d'instance*/
		private $_id_objet;
		private $_nature_objet;
		private $_addr_objet;
		private $_details_objet;
		
		function __construct($nature, $addr, $details){
			$this->_id_objet = uniqid();
			$this->_nature_objet = $nature;
			$this->_addr_objet = $addr;
			$this->_details_objet = $details; 
		}

		/*GETTERS & SETTERS*/
		public function getIdObjet(){return $this->_id_objet;}
		public function getNatureObjet(){return $this->_nature_objet;}
		public function getAddrObjet(){return $this->_addr_objet;}
		public function getDetailsObjet(){return $this->_details_objet;}
		
		public function setIdObjet($newId){$this->_id_objet = $newId;}
		public function setNatureObjet($newNature){$this->_nature_objet = $newNature;}
		public function setAddrObjet($newAddr){$this->_addr_objet = $newAddr;}
		public function setDetailsObjet($newDetails){$this->_details_objet = $newDetails;}
		

		/* METHODES ET SERVICES */
		//permet de former automtiquement un objet avec des elts issu d'une requete select
		public static function parseObjet($id, $nature, $addr, $details){
			$objetTmp = new Objet($nature, $addr, $details);
			$objetTmp->setIdObjet($id);
			return $objetTmp;
		}

		//inserer dans un nouvel objet dans notre BD en ligne
		public function InsertionObjet($connexion){
			$resultat = false;
            if($connexion!=null){
				$insertion1 = $connexion->prepare('INSERT INTO objet(id_objet,nature_objet,addr_objet,details_objet) VALUES
					(:id_objet,:nature_objet,:addr_objet,:details_objet)');
                $insertion1->bindValue(":id_objet", $this->getIdObjet(), PDO::PARAM_STR);
                $insertion1->bindValue(":nature_objet", $this->getNatureObjet(), PDO::PARAM_STR);
                $insertion1->bindValue(":addr_objet", $this->getAddrObjet(), PDO::PARAM_STR);
                $insertion1->bindValue(":details_objet", $this->getDetailsObjet(), PDO::PARAM_STR);
                $insertion1->execute();
                if($insertion1->rowCount()==1) $resultat = true;
			}
            return $resultat;
        }

		//fournit toutes les informations sur l'objet appelant
		public function informationsObjet(){
			echo "<br><br>Id : ".$this->_id_objet."<br>Nature : ".$this->_nature_objet.
			"<br>Adresse : ".$this->_addr_objet."<br>Détails : ".$this->_details_objet;
		}

		//modification de l'objet appelant de notre BD online
		public static function modifierObjet($connexion, $tableau){
            $resultat = false;
			if($connexion!=null){
				$modification = $connexion->prepare('UPDATE objet SET nature_objet = :nature_objet, addr_objet = :addr_objet, details_objet = :details_objet WHERE id_objet = :id_objet');
                $modification->bindValue(":id_objet", $tableau['id_objet'], PDO::PARAM_STR);
                $modification->bindValue(":nature_objet", $tableau['nature_objet'], PDO::PARAM_STR);
                $modification->bindValue(":addr_objet", $tableau['addr_objet'], PDO::PARAM_STR);
                $modification->bindValue(":details_objet", $tableau['details_objet'], PDO::PARAM_STR);
                $modification->execute();
                if($modification->rowCount()==1) $resultat = true;
            }
            return $resultat;
		}
		
		//suppression de l'objet appelant de notre bd online
		public function supprimerObjet($connexion){
			$resultat = false;
			if($connexion!=null){
				$requete = $connexion->prepare("DELETE FROM objet WHERE id_objet = :id");
				$requete->bindValue(":id", $this->_id_objet, PDO::PARAM_STR);
				$requete->execute();
				if($requete->rowCount()==1) $resultat = true;
			}
            return $resultat;
		}

        public static function suppressionRapide($connexion, $id_ob){
            $resultat = false;
            if($connexion!=null){
                $requete = $connexion->prepare("DELETE FROM objet WHERE id_objet = :id");
                $requete->bindValue(":id", $id_ob, PDO::PARAM_STR);
                $requete->execute();
                if($requete->rowCount()==1) $resultat = true;
            }
            return $resultat;
        }

		/*calcul le nombre d'objet valides dans le systeme*/
        public static function getNombreObjets($connexion){
            $texte = "SELECT COUNT(objet.id_objet) AS nbObjets FROM objet, cas WHERE cas.statut_cas=0 ";
            $texte.= "AND cas.id_objet=objet.id_objet";
            $requete = $connexion->prepare($texte);
            $requete->execute();
            $ressources = $requete->fetch(PDO::FETCH_ASSOC);
            return $ressources['nbObjets'];
        }

        public static function modelAffichage($tab){
            return "<div class=\"col-lg-2\" id=\"sys-info-block\">
                <div>
                    <div><label>Nature : </label><span>".$tab['nature_objet']."</span></div>
                    <div><label>Adresse : </label><span>".$tab['addr_objet']."</span></div>
                    <div><label>Détails : </label><span>".$tab['details_objet']."</span></div>
                </div>
                <div>
                    <footer class=\"pull-left\">
                        <label class=\"dropdown\">
                            <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Plus<i class=\"fa fa-caret-down fa-fw\"></i></a>
                            <ul class=\"dropdown-menu\">
                                <li><a href=\"#\"><i class=\"fa fa-eye fa-fw blue-color\"></i>Consulter</a></li>
                            </ul>
                        <label>
                    </footer>
                </div>
            </div>";
        }

        public static function telechargerPhoto(){
            $etat = false;



            return $etat;
        }
	}
?>