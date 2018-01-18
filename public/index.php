<?php
	@session_start();
	require_once("../app_core/Navigation.php");

    /*wouti traduction*/
    if(isset($_POST['lang']) && $_POST['lang']!=""){$_SESSION['userLang'] = $_POST['lang'];
    }if(!isset($_SESSION['userLang']) || empty($_SESSION['userLang'])) $_SESSION['userLang'] = 'fr_FR';
    require_once '../files/i18n.php';
    //if(isset($_GET['wouti_fnav'])) echo 'Ile es resfdd';
    /*navigation de user*/

    if(isset($_GET['f'])){$file = $_GET['f'];}else{$file = "accueil";}
	ob_start();
	Navigation::naviguerA($file);
    $datas = Navigation::recupInfosPage($file);
    $titrePage = $datas[0];
    $menuSelected = $datas[1];
	$informations_a_afficher = ob_get_clean();
	require_once("../files/Models/basic_model.php");
?>
