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

    if(isset($_GET['p'])) $page = $_GET['p']; else $page = 1;
    if(isset($_POST['q'])&&!empty($_POST['q'])){if(true) redirecWithParams('adm-search','q='.$_POST['q'].'&frompage='.$_POST['frompage']);}
    $nbTotalActifs = Cas::getNombreCasActif($connexion);
    $nbActifsParPage = 15;
    $nbPageTotal = ceil($nbTotalActifs/$nbActifsParPage);

    /*requete suppression finder dans la bd*/
    if(isset($_GET['action'])&&isset($_GET['status'])&&$_GET['status']==="ok"&&$_GET['action']==='del') {
        if (isset($_GET['cas_hash']) && !empty($_GET['cas_hash'])){
            Cas::supprimerCas($connexion, $_GET['cas_hash']);
        }
        redirecTo('cas_actifs_liste');
    }

    //recuperation de la liste des cas actifs
    $texte = "SELECT * FROM cas, finder, objet WHERE cas.id_finder=finder.id_finder AND cas.id_objet=objet.id_objet AND ";
    $texte.= "cas.statut_cas=0 ORDER BY cas.datenaiss_cas DESC LIMIT :debut, :fin";
    $request = $connexion->prepare($texte);
    $request->bindValue(':debut', intval(($page-1)*$nbActifsParPage), PDO::PARAM_INT);
    $request->bindValue(':fin', intval($nbActifsParPage), PDO::PARAM_INT);
    $request->execute();

    //on recupere le nombre de finder trouvés dans la bd
    $nbOwner = $request->rowCount();
    $numero = 1;

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
                        <li class="dropdown active">
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
                <h3 style="display: inline-block">Liste des cas actifs<i class="fa fa-fire fa-fw"></i> |</h3> <a href="#">Tout afficher</a>
                <form class="pull-right" style="margin-top: 20px;margin-bottom: 10px;" method="POST">
                    <input type="text" style="width:200px" class="form-control" placeholder="Rechercher" name="q">
                    <input type="hidden" name="frompage" value="actifs">
                </form>
                <hr style="clear: both">
            </header>
            <div class="txt-intro">
                <?php while($donnees = $request->fetch(PDO::FETCH_ASSOC)){ ?>
                    <div class="col-lg-2" id="sys-info-block">
                        <div style="">
                            <div><label>Crée : </label><span><?=$donnees['datenaiss_cas']?></span></div>
                            <div><label>Nature : </label><span><?=$donnees['nature_objet']?></span></div>
                            <div><label>Statut : </label><span class="green-fonce-color"><?=status($donnees['statut_cas'])?></span></div>
                        </div>
                        <div>
                            <footer class="pull-left">
                                <label class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plus<i class="fa fa-caret-down fa-fw"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a data-toggle="modal" href="#finder<?=$numero?>"><i class="fa fa-eye fa-fw blue-color"></i>Consulter</a></li>
                                        <li><a href="cas_modif_file.php?action=modif&status=ok&cas_hash=<?=$donnees['id_cas']?>&from=actifs"><i class="fa fa-edit fa-fw orange-color"></i>Modifier</a></li>
                                        <li><a href="javascript:;" data-toggle="modal" data-target="#confirmSuppression<?=$numero?>"><i class="fa fa-trash fa-fw red-color"></i>Supprimer</a></li>
                                    </ul>
                                    <label>
                            </footer>
                        </div>
                    </div>
                    <!-- Modal de confirmation de suppresion d'un cas -->
                    <div class="modal fade no-round" id="confirmSuppression<?=$numero?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog no-round">
                            <div class="modal-content no-round">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" class="red-color">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Voulez-vous vraiment supprimer le cas : <?=$donnees['id_cas']?> ?</h4>
                                </div>
                                <div class="modal-footer">
                                    <a href="cas_actifs_liste.php?action=del&status=ok&cas_hash=<?=$donnees['id_cas']?>" class="btn btn-success no-round">Oui</a>
                                    <button type="button" class="btn btn-warning no-round" data-dismiss="modal">Non</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    echo "<div class=\"modal fade\" id=\"finder".$numero."\">
                        <div class=\"modal-dialog\">
                            <div class=\"modal-content\">
                                <div class=\"modal-header\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\">x</button>
                                    <h4 class=\"modal-title blue-color\">Cas n° ".$donnees['id_cas']."</h4>
                                </div>
                                <div class=\"modal-body row\">
                                    <div class=\"row\">
                                        <div class=\"col-md-4\">
                                            <div class=\"photo\">Photo</div>
                                        </div>
                                        <div class=\"col-md-8\">
                                            <div class=\"row\">
                                                <div class=\"col-md-12\">Naissance Cas : ".$donnees['datenaiss_cas']."</div>
                                                <div class=\"col-md-12\">Expire le : ".$donnees['dureevie_cas']."</div>
                                                <div class=\"col-md-12\">Statut : ".status($donnees['statut_cas'])."</div>

                                                <div class=\"col-md-12\">Nature : ".html_entity_decode($donnees['nature_objet'])."</div>
                                                <div class=\"col-md-12\">Adresse retrouvé : ".$donnees['addr_objet']."</div>
                                                <div class=\"col-md-12\">Détails : ".$donnees['details_objet']."</div>

                                                <div class=\"col-md-12\">Nom Complet : ".$donnees['prenom_finder']."</div>
                                                <div class=\"col-md-12\">Adresse ramasseur : ".$donnees['addr_finder']."</div>
                                                <div class=\"col-md-12\">Téléphone : ".$donnees['tel_finder']."</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-md-offset-4 col-md-8\">
                                            <div class=\"trait\"></div>
                                            <div class=\"badge jourest\">20<span class=\"glyphicon glyphicon-arrow-down\"></span></div>
                                            <div class=\"badge vie\"><span class=\"glyphicon glyphicon-fire\"></span> Actif</div>
                                            <div class=\"badge plus\"><span class=\"glyphicon glyphicon-plus\"></span> Autres</div>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>";
                    $numero++;
                    }
                ?>
<!--                <div class="sys_amdin-pagination" align="center">
                </div>-->
            </div>
            <div class="row home-middle-content">
                <div class="col-lg-12" align="center">
                    <?=ctrl_pagine($nbTotalActifs, $page, $nbActifsParPage, '?p=')?>
                </div>
            </div>
            <div class="">

            </div>
        </div>
    </body>
</html>