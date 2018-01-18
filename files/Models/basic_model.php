<?php @session_start();require_once '../app_core/Methodes.php';?>
<!DOCTYPE html>
<html class="full">
	<head>
<!--		<title>Wouti | <?/*=_('Accueil ');*/?></title>
-->
        <title>Wouti | <?=_($titrePage)?></title>
        <link rel="shortcut icon" href="../public/images/fav/favicon.ico" type="image/x-icon">
        <link rel="icon" href="../public/images/fav/favicon.png">
        <link rel="icon" sizes="57x57" href="../public/images//favicon-32x32.png">
        <link rel="icon" sizes="57x57" href="../public/images//favicon-57x57.png">
        <link rel="icon" sizes="72x72" href="../public/images//favicon-72x72.png">
        <link rel="icon" sizes="76x76" href="../public/images//favicon-76x76.png">
        <link rel="icon" sizes="114x114" href="../public/images//favicon-114x114.png">
        <link rel="icon" sizes="120x120" href="../public/images//favicon-120x120.png">
        <link rel="icon" sizes="144x144" href="../public/images//favicon-144x144.png">
        <link rel="icon" sizes="152x152" href="../public/images//favicon-152x152.png">
        <meta name="msapplication-TileColor" content="#FFFFFF">
        <meta name="msapplication-TileImage" content="../public/images//favicon-144x144.png">
        <meta name="application-name" content="Wouti">

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../public/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../public/css/netJq.css">
		<link href="../public/js/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="../public/css/design.css">
        <link rel="stylesheet" type="text/css" href="../public/css/jquery-ui.min.css">

        <link rel="stylesheet" type="text/css" href="../public/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="../public/css/font-awesome-animation.min.css">
        <link rel="stylesheet" href="../public/css/formValidation.min.css">
        <link rel="stylesheet" href="../public/css/vendor/formValidation.min.css">

        <!--<link href="../public/js/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>-->

		<script src="../public/js/jquery-dev.js"></script>
		<!--<script src="../public/js/facebox/facebox.js"></script>-->
        <script src="../public/js/jquery-ui.min.js"></script>
        <script src="../public/js/bootstrap.js"></script>
        <script src="../public/js/vendor/formValidation.min.js"></script>
        <script src="../public/js/vendor/bootstrap.min.js"></script>

        <script src="../public/js/link.js"></script>
		<script src="../public/js/jquery-dev-colors.js"></script>
        <script src="../public/js/prefixfree.min.js" defer></script>
        <script src="../public/js/modernizr.custom.js" defer></script>

        <script>
            $(window).load(function(){
                $('#dvLoading').fadeOut(1000);
            });
        </script>
    </head>
	<body>
        <div id="dvLoading"></div>
        <div class="conteneur">
			<div id="share-wrapper" class="">
			    <ul class="share-inner-wrp">
			        <li class="facebook button-wrap"><a href="#">Facebook</a></li>
			        <li class="twitter button-wrap"><a href="#">Tweet</a></li>
			        <li class="digg button-wrap"><a href="#">YouTube</a></li>
			        <li class="stumbleupon button-wrap"><a href="#">Instagram</a></li>
			    </ul>
			</div>
			<div class="img-flag img-responsive"><img src="../public/images/flag10.png" class="img-responsive"></div>
            <div class="">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <!-- Its all about da first components -->
                        <div class="navbar-header">
                            <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#wouti_menu">
                                <span class="fa fa-bars fa-fw fa-lg" style="color:dodgerblue;"></span>
                            </button>-->

                            <button style="color:dodgerblue;" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#wouti_menu" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar top-bar"></span>
                                <span class="icon-bar middle-bar"></span>
                                <span class="icon-bar bottom-bar"></span>
                            </button>
                            <a class="navbar-brand" style="padding:7px">
                                <div class="col-lg-4 logo">
                                    <div class="col-lg-offset-4 col-lg-5" style="padding: 0;margin:0">
                                        <div class="pulse1"></div>
                                        <div class="pulse2"></div>
                                        <div class="icon"></div>
                                    </div>
                                </div>
                            </a>
                            <div class="wouti visible-sm visible-md visible-lg"></div>
                        </div>
                        <!-- Our navigation menu -->
                        <div class="collapse navbar-collapse" id="wouti_menu">
                            <div class="menuObject" style="margin-left:20%">
                                <ul class="nav navbar-nav" style="margin-top:3%;margin-right: 7%">
                                    <li><a href="index.php?eeffws017&f=accueil#77dfzzz" id="navig"><span class="glyphicon
                                            glyphicon-home<?=menuCourant($menuSelected, 'Accueil')?>"></span> <strong class="<?=menuCourant($menuSelected, 'Accueil')?>"><?=_("Accueil")?></strong></a></li>
                                    <li><a class="test" href="index.php?78dfvg552&f=rechercher#00derf" id="navig"><span class="glyphicon
                                            glyphicon-search<?=menuCourant($menuSelected, 'Rechercher')?>"></span> <strong class="<?=menuCourant($menuSelected, 'Rechercher')?>"><?=_("Rechercher")?></strong></a></li>
                                    <li><a href="index.php?zzdxc14fer5&f=declarer#sdfsdfile" id="navig"><span class="glyphicon
                                            glyphicon-pencil<?=menuCourant($menuSelected, 'Declarer')?>"></span> <strong class="<?=menuCourant($menuSelected, 'Declarer')?>"><?=_("Déclarer")?></strong></a></li>
                                    <li><a href="index.php?wes478dfq&f=modeemploi#sdfsdfile" id="navig"><span class="glyphicon
                                            glyphicon-file<?=menuCourant($menuSelected, 'Manuel')?>"></span><strong class="<?=menuCourant($menuSelected, 'Manuel')?>"><?=_("Mode d'emploi")?></strong></a></li>
                                    <li><a>
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                            <span class="glyphicon glyphicon-globe" style="padding:0;margin-left:0.5em;margin-top:0;"></span>
                                        </div>
                                        <div class="col-xs-5 col-sm-5 col-md-7 col-lg-7">
                                            <form method="POST">
                                                <select name="lang" class="form-control" style="margin-top: -0.8rem;padding: 6px 2px" onchange='this.form.submit()'>
                                                    <option value="fr_FR" <?=ifSelected($_SESSION['userLang'], "fr_FR")?>>Fr</option>
                                                    <option value="en_US" <?=ifSelected($_SESSION['userLang'], "en_US")?>>Us</option>
                                                </select><!--<noscript><input type="submit" value="Go"></noscript>-->
                                            </form>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <a href="../files/file-avis.php" data-target="#avis_section" data-toggle="modal" class="niceBouton" style="margin-top: -2.15rem">Avis
                                                <span class="glyphicon glyphicon-comment"></span>
                                            </a>
                                            <div class="modal fade" id="avis_section">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">x</button>
                                                            <h3 class="modal-title">Avis / Suggestions</h3>
                                                        </div>
                                                        <div class="modal-body row">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
			<div class="row conteneurInterne">
                <?= $informations_a_afficher ?>
			</div>
		</div>
		<br />
		<footer class="col-lg-12 panel-footer footer">
			<label id="copyright pied">&copy;WOUTI, <?=_('développé par')?> <span style="color:forestgreen">Daaray</span><span style="color: dodgerblue">01</span> - 2015</label>
			<ul class="list-inline pull-right">
				<li id="about"><a id="last" href="index.php?page=zzz&do=zzfilex744&f=apropos&get=hksdfnosd"><?=_('A propos')?></a></li>
				<li id="contacts"><a id="pieds" href="index.php?page=zzz&do=zzfilex744&f=contact&get=hksdfnosd"><?=_('Contacts')?></a></li>
				<li id="confidentialites"><a id="pieds" href="index.php?redirect64564dde7a&f=charte&bvcn57"><?=_('Mentions')?></a></li>
			</ul>
		</footer>
	</body>
</html>
<!---->