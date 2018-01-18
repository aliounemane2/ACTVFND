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

    if(isset($_POST['bt_modif'])){
        $destination  = "";
        $finderDatas = array('id_finder' => $_POST['finder_hash'], 'nom_finder' => $_POST['nom_f'], 'prenom_finder' => $_POST['pren_f'], 'tel_finder' => $_POST['tel_f']);
        $objetDatas = array('id_objet' => $_POST['objet_hash'], 'nature_objet' => $_POST['nature_ob'], 'addr_objet' => $_POST['addr_retrv'], 'details_objet' => $_POST['details'],);
        $casDatas = array('id_cas' => $_POST['cas_hash'], 'dns' => $_POST['dns_cas'], 'ddv' => $_POST['ddv_cas'], 'statut' => $_POST['stat_cas'],);
        Finder::modification($connexion, $finderDatas);
        Objet::modifierObjet($connexion, $objetDatas);
        Cas::modifierCas($connexion, $casDatas);
        if($_POST['from']==='actifs')
            $destination = "cas_actifs_liste";
        else
            $destination = "cas_exp_liste";

        redirecTo($destination);
    }

    /*requete suppression finder dans la bd*/
    if(isset($_GET['action'])&&isset($_GET['status'])&&$_GET['status']==="ok"&&$_GET['action']==='modif') {
        if (isset($_GET['cas_hash']) && !empty($_GET['cas_hash'])){
            $texte = "SELECT * FROM cas, finder, objet WHERE cas.id_finder=finder.id_finder AND cas.id_objet=objet.id_objet ";
            $texte.= "AND cas.id_cas=:id_cas";
            $request = $connexion->prepare($texte);
            $request->bindParam(":id_cas", $_GET['cas_hash'], PDO::PARAM_STR);
            $request->execute();
            $donnee = $request->fetch(PDO::FETCH_ASSOC);

            $tabIds = Cas::getAllIdsInCas($connexion, $_GET['cas_hash']);
        }
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
                <h3 style="display: inline-block">Modification cas<i class="fa fa-angle-double-right fa-fw"></i><span class="blue-color"><?=$_GET['cas_hash']?></span></h3>
                <hr style="clear: both">
            </header>
            <div class="txt-intro col-xs-12 col-sm-12 col-md-6">
                <form method="POST" class="form-horizontal">
                    <input type="hidden" class="form-control" name="cas_hash" value="<?=$_GET['cas_hash']?>">
                    <input type="hidden" class="form-control" name="finder_hash" value="<?=$tabIds['id_finder']?>">
                    <input type="hidden" class="form-control" name="objet_hash" value="<?=$tabIds['id_objet']?>">
                    <input type="hidden" class="form-control" name="from" value="<?=$_GET['from']?>">

                    <table class="table table-responsive table-striped table-condensed">
                        <tr><td><label>Date naissance cas</label></td><td><input type="datetime" class="form-control" name="dns_cas" value="<?=$donnee['datenaiss_cas']?>"></td></tr>
                        <tr><td><label>Durée de vie cas</label></td><td><input type="date" class="form-control" name="ddv_cas" value="<?=$donnee['dureevie_cas']?>"></td></tr>
                        <tr><td><label>Statut cas</label></td>
                            <td>
                                <select name="stat_cas" class="form-control">
                                    <option value="0" <?php if($donnee['statut_cas']==0) echo 'selected'?>>En cours</option>
                                    <option value="1" <?php if($donnee['statut_cas']==1) echo 'selected'?>>Expiré</option>
                                </select>
                            </td>
                        </tr>
                        <tr><td><label>Prénom du finder</label></td><td><input type="text" class="form-control" name="pren_f" value="<?=$donnee['prenom_finder']?>"></td></tr>
                        <tr><td><label>Nom du finder</label></td><td><input type="text" class="form-control" name="nom_f" value="<?=$donnee['nom_finder']?>"></td></tr>
<!--                        <tr><td><label>Adresse du finder</label></td><td><input type="text" class="form-control" name="adr_f" value="<?/*=$donnee['addr_finder']*/?>"></td></tr>
-->                        <tr><td><label>Téléphone du finder</label></td><td><input type="text" class="form-control" name="tel_f" value="<?=$donnee['tel_finder']?>"></td></tr>

                        <tr><td><label>Nature de l'ojet</label></td><td><input type="text" class="form-control" name="nature_ob" value="<?=$donnee['nature_objet']?>"></td></tr>
                        <tr><td><label>Adresse retrouvée</label></td><td><input type="text" class="form-control" name="addr_retrv" value="<?=$donnee['addr_objet']?>"></td></tr>
                        <tr>
                            <td><label>Détails sur l'objet</label></td><td>
                                <textarea class="form-control" name="details"><?=$donnee['details_objet']?></textarea>
                            </td>
                        </tr>
                    </table>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for=""></label>
                        <div class="col-md-8">
                            <button name="bt_modif" class="btn btn-success">Enregistrer <span class="glyphicon glyphicon-ok-sign"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>