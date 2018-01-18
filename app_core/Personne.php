<?php 
	abstract class Personne{
		
		/*variable d'instances*/
		protected $_id;
		protected $_nom;
		protected $_prenom;
		protected $_tel;
		protected $_addr; 
		protected $_mail;
		protected $_profil; /* nous permettra de savoir si cette personne est un finder ou un owner*/
		
		/*Getters & Setters*/
		public function getId(){return $this->_id;}
		public function getNom(){return $this->_nom;}
		public function getPrenom(){return $this->_prenom;}
		public function getTel(){return $this->_tel;}
		public function getAddr(){return $this->_addr;}
		public function getMail(){return $this->_mail;}
		public function getProfil(){return $this->_profil;}

		public function setId($newId){$this->_id = $newId;}
		public function setNom($newNom){$this->_nom = $newNom;}
		public function setPrenom($newPrenom){$this->_prenom = $newPrenom;}
		public function setTel($newTel){$this->_tel = $newTel;}
		public function setAddr($newAddr){$this->_addr = $newAddr;}
		public function setMail($newMail){$this->_mail = $newMail;}
		public function setProfil($newProfil){$this->_profil = $newProfil;}
		
		
		/***** METHODES BASIQUES ******/
		public abstract function informations();
		public abstract function insertion($connexion);
		public abstract function suppression($connexion);
        public static function suppressionRapide($connexion, $id){}
		public static function modification($connexion, $tab){}

		/* les autres services ou méthodes devront être implémentées dans les classe ayant besoin*/
	}
?>