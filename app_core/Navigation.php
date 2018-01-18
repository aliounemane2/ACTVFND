<?php
	/**
	* Cette classe permet de recuperer le mot clé dans l'url et d'integer la page requise dans l'index
	*/
	class Navigation
	{
		//méthode static pour l'insertion de la portion de page selon l'url
		public static function naviguerA($file){
			switch ($file) {
				case 'accueil':
					require_once("../files/accueil.php");
					break;
				case 'rechercher':
					require_once("../files/rechercher.php");
					break;
				case 'declarer':
					require_once("../files/declarer.php");
					break;
				case 'modeemploi':
					require_once("../files/modeEmploi.php");
					break;
				case 'ajout':
					require_once("../files/ajout.php");
					break;
				case 'results':
					require_once("../files/resultats_rech.php");
					break;
                case 'apropos':
                    require_once("../files/apropos.php");
                    break;
                case 'charte':
                    require_once("../files/wouti_mentions.php");
                    break;
                case 'contact':
                    require_once("../files/wouti_contact.php");
                    break;
				default:
					require_once("../files/accueil.php");
					break;
			}
		}

        public static function recupInfosPage($page){
            $datas = array();
            switch($page){
                case 'modeemploi';
                    $datas[0] = "Mode d'emploi";
                    $datas[1] = "Manuel";
                    break;
                case 'declarer';
                    $datas[0] = "Déclarer";
                    $datas[1] = "Declarer";
                    break;
                case 'rechercher';
                    $datas[0] = "Rechercher";
                    $datas[1] = "Rechercher";
                    break;
                case 'accueil';
                    $datas[0] = "Accueil";
                    $datas[1] = "Accueil";
                    break;
                default:
                    $datas[0] = "Sn";
                    $datas[1] = "";
                    break;
            }
            return $datas;
        }
	}
	
?>