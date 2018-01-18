<?php
    @session_start();
    require_once '../../app_core/Methodes.php';
    sysConnectedUserControl();
    require_once('../../app_core/Connexion.php');
    require_once('../../app_core/Cas.php');
    require_once('../../app_core/Objet.php');
    require_once('../../app_core/Finder.php');
    require_once('../../app_core/Owner.php');
    $con = new ConnexionBd();
    $connexion = $con->getConnexion();
    $requete = "";
    $modele = $_GET['frompage'];

    switch($modele){
        case 'actifs':
            $requete = "SELECT * FROM cas, finder, objet WHERE cas.id_finder = finder.id_finder AND cas.id_objet = objet.id_objet AND (prenom_finder LIKE :q OR nom_finder ";
            $requete.= "LIKE :q OR addr_finder LIKE :q OR tel_finder LIKE :q OR cas.dureevie_cas LIKE :q OR datenaiss_cas LIKE :q OR id_cas LIKE :q OR objet.nature_objet LIKE :q ";
            $requete.= "OR addr_objet LIKE :q OR  nature_objet LIKE :q) AND cas.statut_cas=0 ORDER BY cas.datenaiss_cas DESC";
            break;
        case 'exps':
            $requete = "SELECT * FROM cas, finder, objet WHERE cas.id_finder = finder.id_finder AND cas.id_objet = objet.id_objet AND (prenom_finder LIKE :q OR nom_finder ";
            $requete.= "LIKE :q OR addr_finder LIKE :q OR tel_finder LIKE :q OR cas.dureevie_cas LIKE :q OR datenaiss_cas LIKE :q OR id_cas LIKE :q OR objet.nature_objet LIKE :q ";
            $requete.= "OR addr_objet LIKE :q OR  nature_objet LIKE :q) AND cas.statut_cas=1 ORDER BY cas.datenaiss_cas DESC";
            break;
        case 'objets':
            $requete = "SELECT objet.id_objet, nature_objet, addr_objet, details_objet FROM objet, cas WHERE cas.id_objet=objet.id_objet AND cas.statut_cas=0 AND ";
            $requete.= "(objet.id_objet LIKE :q OR nature_objet LIKE :q OR details_objet LIKE :q OR addr_objet LIKE :q) ORDER BY cas.datenaiss_cas DESC ";
            break;
        case 'owners':
            $requete = "SELECT DISTINCT owner.id_owner, prenom_owner, nom_owner, tel_owner, addr_owner FROM owner, cas WHERE owner.id_owner=cas.id_owner AND cas.statut_cas=0 AND ";
            $requete.= "(owner.id_owner LIKE :q OR tel_owner LIKE :q OR nom_owner LIKE :q OR addr_owner LIKE :q) ORDER BY cas.datenaiss_cas DESC";
            break;
        case 'finders':
            $requete = "SELECT DISTINCT finder.id_finder, prenom_finder, nom_finder, tel_finder, addr_finder FROM finder, cas WHERE cas.id_finder=finder.id_finder AND cas.statut_cas=0 AND ";
            $requete.= "(finder.id_finder LIKE :q OR tel_finder LIKE :q OR nom_finder LIKE :q  OR addr_finder LIKE :q) ORDER BY cas.datenaiss_cas DESC";
            break;
        default: //we're in bigsearch file
            break;
    }
?>
<!Doctype html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="css/design.css">
        <script src="js/jquery-dev.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="global-zone">
            <div role="navigation" class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="./">WOUTI</a>
                </div>
                <div id="navbarCollapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="./">Accueil<i class="fa fa-home fa-fw"></i></a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Cas<i class="fa fa-caret-down fa-fw"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="cas_actifs_liste.php"><i class="fa fa-fire fa-fw"></i>Liste des cas actifs <span class="badge">
                                                                                <?=Cas::getNombreCasActif($connexion);?>
                                                                            </span></a></li>
                                <li><a href="cas_exp_liste.php"><i class="fa fa-trash fa-fw"></i>Liste des cas expirés <span class="badge">
                                        <?=Cas::getNombreCasExpires($connexion);?></a></li>
                            </ul>
                        </li>
                        <li><a href="owner_liste.php"><i class="fa fa-user fa-fw"></i>Owner</a></li>
                        <li><a href="finder_liste.php"><i class="fa fa-search-plus fa-fw"></i>Finder <span class="badge">
                                                                        <?=Finder::getNombreFinder($connexion);?>
                                                                    </span></a></li>
                        <li><a href="objets_liste.php"><i class="fa fa-cube fa-fw"></i>Objets <span class="badge">
                                                                        <?=Objet::getNombreObjets($connexion);?>
                                                                    </span></a></li>
                        <li><a href="avis_liste.php"><i class="fa fa-comments fa-fw"></i>Avis</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-wrench fa-fw"></i>Actions<i class="fa fa-caret-down fa-fw"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="sys_backup.php"><i class="fa fa-database fa-fw"></i>Archivage BD</a></li>
                                <li><a href="sys_clean.php"><i class="fa fa-cog fa-fw"></i>Nettoyage de cas</a></li>
                                <li class="divider"></li>
                                <li><a href="http://www.gmail.com/wouti"><i class="fa fa-google fa-fw"></i>Compte Gmail</a></li>
                                <li><a href="sys_restore.php"><i class="fa fa-recycle fa-fw"></i>Restaurer BD</a></li>
                            </ul>
                        </li>
                    </ul>
                    <span class="navbar-form pull-right profil-right">
                        <label class="dropdown">
                            <a class="dropdown-toggle usr-ctd-icon" data-toggle="dropdown" href="#">
                                <?=$_SESSION['utilisateur'];?>&nbsp;&nbsp;
                                <img class="img-rounded" src="images/essai.png" style="width:30px"/>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="sys_backup.php"><i class="fa fa-user fa-fw"></i>Consulter mon profil</a></li>
                                <li><a href="sys_clean.php"><i class="fa fa-key fa-fw"></i>Changer mon mot de passe</a></li>
                                <li><a href="index-old.php?action_user=logout"><i class="fa fa-power-off fa-fw"></i>Se déconnecter</a></li>
                            </ul>
                            <label>
                    </span>
                </div>
            </div>
        </div>
        <div class="container">
            <header>
                <h3 style="display: inline-block"><i class="fa fa-search fa-fw fa-rotate-90"></i>vous recherchez<i class="fa fa-angle-double-right fa-fw"></i><span class="green-fonce-color"><?=$_GET['q']?></span></h3>
                <hr style="clear: both">
            </header>
            <div class="txt-intro col-xs-12 col-sm-12 col-md-6" align="center" id="bigsearch_div">
                <form class="form-horizontal well">
                    <input type="text" name="bigsearch" class="form-control" placeholder="Votre recherche ici">
                </form>
            </div>
            <div class="home-middle-content">
                <?php
                    if($requete!="") {
                        $exec = $connexion->prepare($requete);
                        $exec->bindValue(':q', '%'.$_GET['q'].'%', PDO::PARAM_STR);
                        $exec->execute();
                        while ($donnees = $exec->fetch(PDO::FETCH_ASSOC)) {
                            switch($modele){
                                case 'actifs':echo Cas::modelAffichage($donnees, 5);break;
                                case 'exps':echo Cas::modelAffichage($donnees, 5);break;
                                case 'objets':echo Objet::modelAffichage($donnees);break;
                                case 'owners':echo Owner::modelAffichage($donnees);break;
                                case 'finders':echo Finder::modelAffichage($donnees);break;
                                default:break;
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>