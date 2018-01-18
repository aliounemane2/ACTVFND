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

    if(isset($_GET['action_user']) && $_GET['action_user']==='logout')
        redirecWithParams('sysAdminInOutPage', 'status=disconnecting&current='.sha1($_SESSION['identifier']).'&code=ok');
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
                        <li class="active"><a href="./">Accueil<i class="fa fa-home fa-fw"></i></a></li>
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
            <header><h3>Accueil</h3><hr></header>
            <div class="txt-intro">

            </div>
            <div class="home-middle-content">

            </div>
            <div class="">

            </div>
        </div>
    </body>
</html>