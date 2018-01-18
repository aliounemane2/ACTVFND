<?php
	class ConnexionBd{
		private $_Connexion;
		CONST HOST_NAME = 'localhost';
		CONST DB_NAME = 'activfinddb';
		CONST USER_NAME = 'root';
		CONST MDP = '';

		//notre constructeur initialise autom une connexion d son appel
		function __construct(){
			try{	
				/* Connexion au Serveur */
				$this->_Connexion = new PDO('mysql:host='.self::HOST_NAME.';dbname='.self::DB_NAME.'',''.self::USER_NAME.'','');
				
				// On émet une alerte a chaque fois qu'une requette a échoué
				$this->_Connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                $this->_Connexion->exec('SET NAMES utf8');

			}catch(Exception $e){
				die("Impossible d'accéder à la base de données !".$e->getMessage());
			}
		}
		
		//renvoi la connexion cree par le contructeur de la classe
		public function getConnexion(){
			return $this->_Connexion;
		}
	}
?>