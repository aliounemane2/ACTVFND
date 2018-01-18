<?php 
	/*function __autoload($class_name) {
    	include $class_name . '.php';
	}*/
	
	require_once("Personne.php");

	class Finder extends Personne{
		// ici $_profil = 'F'

		//notre constructeur d'initialisation
		function __construct($nom, $pnom, $tel, $addr, $mail) {
			$this->_id = uniqid();
			$this->_nom = $nom;
			$this->_prenom = $pnom;
			$this->_tel = $tel;
			$this->_addr = $addr;
			$this->_mail = $mail;
			$this->_profil = "F";
		}
		
		/* implémentation méthodes héritées */
		//former un finder avec les infos recus d'une requete sql
		public static function parseFinder($id, $nom, $pnom, $tel, $addr, $mail){
			$finderTmp = new Finder($nom, $pnom, $tel, $addr, $mail);
			$finderTmp->setId($id);
			return $finderTmp;
		}

		//Cette méthode permet d'afficher toutes les informations concernant l'Owner
		public function informations(){
			echo "<br><br>Id : ".$this->getId()."<br>Prénom : ".$this->getPrenom()."<br>Nom : ".$this->getNom().
			"<br>Profil : ".$this->getProfil()."<br>Tel : ".$this->getTel()."<br>Adresse : ".$this->getAddr().
			"<br>Mail : ".$this->getMail();
		}
		
		//Insertion d'un Owner dans notre BD en ligne
		public function insertion($connexion){
            $feedback = false;
			if($connexion!=null){
				$insertion = $connexion->prepare('INSERT INTO finder(id_finder,nom_finder,prenom_finder,tel_finder,addr_finder,mail_finder,profil) VALUES 
				 (:id_finder,:nom_finder,:prenom_finder,:tel_finder,:addr_finder,:mail_finder,:profil)');
                $insertion->bindValue(":id_finder", $this->getId(), PDO::PARAM_STR);
                $insertion->bindValue(":nom_finder", $this->getNom(), PDO::PARAM_STR);
                $insertion->bindValue(":prenom_finder", $this->getPrenom(), PDO::PARAM_STR);
                $insertion->bindValue(":tel_finder", $this->getTel(), PDO::PARAM_INT);
                $insertion->bindValue(":addr_finder", $this->getAddr(), PDO::PARAM_STR);
                $insertion->bindValue(":mail_finder", $this->getMail(), PDO::PARAM_STR);
                $insertion->bindValue(":profil", $this->getProfil(), PDO::PARAM_STR);
                $insertion->execute();
                if($insertion->rowCount()>=1) $feedback = true;
			}
            return $feedback;
        }
		
		//Suppression du owner à partir de son id
		public function suppression($connexion){
			$resultat = false;
			if($connexion!=null){
				$requete = $connexion->prepare("DELETE FROM finder WHERE id_finder = :id");
				$requete->bindValue(":id", $this->_id, PDO::PARAM_STR);
				$requete->execute();
				if($requete->rowCount()==1) $resultat = true;
			}
			return $resultat;
		}

        public static function suppressionRapide($connexion, $id_f){
            $resultat = false;
            if($connexion!=null){
                $requete = $connexion->prepare("DELETE FROM finder WHERE id_finder = :id");
                $requete->bindValue(":id", $id_f, PDO::PARAM_STR);
                $requete->execute();
                if($requete->rowCount()==1) $resultat = true;
            }
            return $resultat;
        }

        /*function qui test si un ce owner se trouve deja dans notre bd*/
        public static function isFinderExistDeja($connexion, $call_f){
            $exist = false;
            if($connexion!=null){
                $requete = $connexion->prepare("SELECT COUNT(id_finder) AS nbFois FROM finder WHERE finder.tel_finder = :phone");
                $requete->bindValue(":phone", $call_f, PDO::PARAM_INT);
                $requete->execute();
                $donnee = $requete->fetch(PDO::FETCH_ASSOC);
                $nbre = $donnee['nbFois'];
                if($nbre>=1) $exist = true;
            }
            return $exist;
        }

        public static function getIdFinderByNumTel($connexion, $call_f){
            $numTel = 0;
            if($connexion!=null){
                $requete = $connexion->prepare("SELECT id_finder FROM finder WHERE finder.tel_finder = :phone");
                $requete->bindValue(":phone", $call_f, PDO::PARAM_INT);
                $requete->execute();
                $donnee = $requete->fetch(PDO::FETCH_ASSOC);
                $numTel = $donnee['id_finder'];
            }
            return $numTel;
        }

		//Modification du owner à partir de son id
		public static function modification($connexion, $tableau){
            $feedback = false;
			if($connexion!=null){
				$modification = $connexion->prepare("UPDATE finder SET nom_finder = :nom_finder, prenom_finder = :prenom_finder,
					tel_finder = :tel_finder WHERE id_finder = :id_finder");
                $modification->bindValue(":id_finder", $tableau['id_finder'], PDO::PARAM_STR);
                $modification->bindValue(":nom_finder", $tableau['nom_finder'], PDO::PARAM_STR);
                $modification->bindValue(":prenom_finder", $tableau['prenom_finder'], PDO::PARAM_STR);
                $modification->bindValue(":tel_finder", $tableau['tel_finder'], PDO::PARAM_INT);
                $modification->execute();
                if($modification->rowCount()>=1) $feedback = true;
            }
            return $feedback;
		}
        /*calculer le bombre de finder dans la bd*/
        public static function getNombreFinder($connexion){
            $texte = "SELECT COUNT(cas.id_finder) AS nbFinder FROM finder, cas WHERE cas.statut_cas=0 ";
            $texte.= "AND cas.id_finder=finder.id_finder";
            $requete = $connexion->prepare($texte);
            $requete->execute();
            $ressources = $requete->fetch(PDO::FETCH_ASSOC);
            return $ressources['nbFinder'];
        }

        public static function modelAffichage($tab){
            return "<div class=\"col-lg-2\" id=\"sys-info-block\">
                <div>
                    <div><label>Nom : </label><span>".$tab['nom_finder']."</span></div>
                    <div><label>Prénom : </label><span>".$tab['prenom_finder']."</span></div>
                    <div><label>Tél : </label><span>".$tab['tel_finder']."</span></div>
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
	}
?>