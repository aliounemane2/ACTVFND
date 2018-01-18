<?php 
	require_once("Personne.php");
	require_once("Connexion.php");

	class Owner extends Personne{
		// ici $_profil = 'O'
		
		/* constructeur d'initialisation */
		function __construct($nom, $pnom, $tel, $addr, $mail){
			$this->_id = uniqid();
			$this->_nom = $nom;
			$this->_prenom = $pnom;
			$this->_tel = $tel;
			$this->_addr = $addr;
			$this->_mail = $mail;
			$this->_profil = "O";
		}

		/* implémentation méthodes héritées */
		//former un Owne automatiquement issu requete sql
		public static function parseOwner($id, $nom, $pnom, $tel, $addr, $mail){
			$ownerTmp = new Owner($nom, $pnom, $tel, $addr, $mail);
			$ownerTmp->setId($id);
			return $ownerTmp;
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
			if($connexion!=null) {
				$insertion = $connexion->prepare('INSERT INTO owner(id_owner,nom_owner,prenom_owner,tel_owner,addr_owner,mail_owner,profil) VALUES 
				 (:id_owner,:nom_owner,:prenom_owner,:tel_owner,:addr_owner,:mail_owner,:profil)');
                $insertion->bindParam(":id_owner", $this->getId(), PDO::PARAM_STR);
                $insertion->bindParam(":nom_owner", $this->getNom(), PDO::PARAM_STR);
                $insertion->bindParam(":prenom_owner", $this->getPrenom(), PDO::PARAM_STR);
                $insertion->bindParam(":tel_owner", $this->getTel(), PDO::PARAM_INT);
                $insertion->bindParam(":addr_owner", $this->getAddr(), PDO::PARAM_STR);
                $insertion->bindParam(":mail_owner", $this->getMail(), PDO::PARAM_STR);
                $insertion->bindParam(":profil", $this->getProfil(), PDO::PARAM_STR);
                $insertion->execute();
                if($insertion->rowCount()>=1) $feedback = true;
			}
            return $feedback;
		}
		
		//Suppression du owner à partir de son id
		public function suppression($connexion){
			$resultat = false;
			if($connexion!=null){
				$requete = $connexion->prepare("DELETE FROM owner WHERE id_owner = :id");
				$requete->bindParam(":id", $this->_id, PDO::PARAM_STR);
				$requete->execute();
				if($requete->rowCount()==1) $resultat = true;
			}
			return $resultat; //return 0 false ou 1 true
		}

        public static function suppressionRapide($connexion, $id_ow){
            $resultat = false;
            if($connexion!=null){
                $requete = $connexion->prepare("DELETE FROM owner WHERE id_owner = :id");
                $requete->bindParam(":id", $id_ow, PDO::PARAM_STR);
                $requete->execute();
                if($requete->rowCount()==1) $resultat = true;
            }
            else
                echo "Aucune connexion établie";
            return $resultat;
        }

		//Modification du owner à partir de son id
		public static function modification($connexion, $tableau){
            $resultat = false;
			if($connexion!=null){
				$modification = $connexion->prepare('UPDATE owner 
					SET nom_owner = :nom_owner, 
					prenom_owner = :prenom_owner,
					tel_owner = :tel_owner,
					addr_owner = :addr_owner,
					mail_owner = :mail_owner 
					WHERE id_owner = :id_owner'
				);
                $modification->bindParam(":id_owner", $tableau[''], PDO::PARAM_STR);
                $modification->bindParam(":nom_owner", $tableau[''], PDO::PARAM_STR);
                $modification->bindParam(":prenom_owner", $tableau[''], PDO::PARAM_STR);
                $modification->bindParam(":tel_owner", $tableau[''], PDO::PARAM_INT);
                $modification->bindParam(":addr_owner", $tableau[''], PDO::PARAM_STR);
                $modification->bindParam(":mail_owner", $tableau[''], PDO::PARAM_STR);
                $modification->execute();
                if($modification->rowCount()==1) $resultat = true;
            }
            return $resultat;
		}

        /*calculer le bombre de owner dans la bd*/
        public static function getNombreOwner($connexion){
            $texte = "SELECT COUNT(cas.id_owner) AS nbOwner FROM owner, cas WHERE cas.statut_cas=0 ";
            $texte.= "AND cas.id_owner=owner.id_owner";
            $requete = $connexion->prepare($texte);
            $requete->execute();
            $ressources = $requete->fetch(PDO::FETCH_ASSOC);
            return $ressources['nbOwner'];
        }

        public static function modelAffichage($tab){
            return "<div class=\"col-lg-2\" id=\"sys-info-block\">
                <div>
                    <div><label>Nom : </label><span>".$tab['nom_owner']."</span></div>
                    <div><label>Prénom : </label><span>".$tab['prenom_owner']."</span></div>
                    <div><label>Tél : </label><span>".$tab['tel_owner']."</span></div>
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