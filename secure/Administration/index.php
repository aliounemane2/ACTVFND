<?php
    @session_start();
    require_once '../../app_core/Methodes.php';
    require_once('../../app_core/Connexion.php');
    require_once('../../app_core/Cas.php');
    require_once('../../app_core/Objet.php');
    require_once('../../app_core/Finder.php');
    require_once('../../app_core/Owner.php');
    $con = new ConnexionBd();
    $connexion = $con->getConnexion();
    $erreur = "";

    if(isset($_POST['WoutiOAuthRun'])){
        $texte  = "SELECT COUNT(id_util) AS nbResultat FROM utilisateurs WHERE util_login = :log AND util_password = :pass";
        $request = $connexion->prepare($texte);
        $request->bindValue(':log', $_POST['nomutilisateur'], PDO::PARAM_STR);
        $request->bindValue(':pass', $_POST['motdepasse'], PDO::PARAM_STR);
        $request->execute();
        $donnee = $request->fetch(PDO::FETCH_ASSOC);
        $nbResultat = $donnee['nbResultat'];

        if($nbResultat==0)
            $erreur = "FALSE";
        else{
            $erreur = "TRUE";
            //ce compte existe bien
            $in  = "SELECT * FROM utilisateurs WHERE util_login = :log AND util_password = :pass";
            $requete = $connexion->prepare($in);
            $requete->bindValue(':log', $_POST['nomutilisateur'], PDO::PARAM_STR);
            $requete->bindValue(':pass', $_POST['motdepasse'], PDO::PARAM_STR);
            $requete->execute();
            $data = $requete->fetch(PDO::FETCH_ASSOC);

            /*init our var sess*/
            $_SESSION['utilisateur'] = $data['util_login'];
            $_SESSION['token'] = $data['token'];
            $_SESSION['identifier'] = $data['id_util'];
            $_SESSION['connected'] = "connected";
            redirecWithParams('sysAdminInOutPage','status=connected&current='.sha1($_SESSION['identifier']).'&to='.md5('woutiAdminPanel'));
        }
    }
?>
<!Doctype html>
<html lang="en">
    <head>
        <title>Wouti ░ OAuth</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="css/design.css">
        <script src="js/jquery-dev.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <style>
            span.adm_connect_text{
                font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                font-size: 1.2em;
                color: #fff;
                font-weight: 800;
            }
            .container-login {
                min-height: 0;
                width: 400px;
                color: #333333;
                margin: 50px 0;
            }
            img.adm_img-logo2{
                width:48px;
                left: 0;
            }
            .center-block {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
            .container-login > section {
                margin-left: 0;
                margin-right: 0;
                padding-bottom: 10px;
            }
            #top-bar {
                display: inherit;
            }
            .nav-tabs.nav-justified {
                border-bottom: 0 none;
                width: 100%;
            }
            .nav-tabs.nav-justified > li {
                display: table-cell;
                width: 1%;
                float: none;
            }
            .nav-tabs.nav-justified > li >a{
                width: 50%;
                margin:15px;
                font-size : 22px;
                height : 50px;
                text-align : center;
                padding : 2px;
            }
            .container-login .nav-tabs.nav-justified > li > a,
            .container-login .nav-tabs.nav-justified > li > a:hover,
            .container-login .nav-tabs.nav-justified > li > a:focus {
                background-color : rgb(0,162,232);
                border: medium none;
                color: #ffffff;
                margin-bottom: 0;
                margin-right: 0;
                border-radius: 0;
            }
            .container-login .nav-tabs.nav-justified > .active > a,
            .container-login .nav-tabs.nav-justified > .active > a:focus {
                background-color : rgb(0,162,232);
                color : #fff;
            }
            .container-login .nav-tabs.nav-justified > .active > a:hover {
                background-color : rgb(0,162,232);
            }
            .container-login .nav-tabs.nav-justified > li > a:hover,
            .container-login .nav-tabs.nav-justified > li > a:focus {
                background-color : rgb(0,162,232);
            }
            .tabs-login {
                background: #ffffff;
                border: medium none;
                margin-top: -1px;
                padding: 10px 30px;
            }
            .container-login h2 {
                color : rgb(0,162,232);
            }
            .form-control {
                background-color: #ffffff;
                background-image: none;
                border: 1px solid #999999;
                border-radius: 0;
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
                color: #333333;
                display: block;
                font-size: 14px;
                height: 34px;
                line-height: 1.42857;
                padding: 6px 12px;
                transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
                width: 100%;
            }
            .container-login .checkbox {
                margin-top: -15px;
            }
            .container-login button {
                color: #ffffff;
                border-radius: 0;
                font-size: 18px;
                line-height: 1.33;
                padding: 10px 16px;
                width: 100%;
            }
            button.zzz{background-color: rgb(0,162,232)}
            /* -----Fin de notre section login -------*/
        </style>
    </head>
    <body>
        <div class="global-zone"><div role="navigation" class="navbar navbar-inverse navbar-fixed-top"></div></div>
        <div class="container">
            <div>
                <?php
                    if(isset($erreur) && $erreur==='FALSE')
                        echo '<br>
                        <div class="alert alert-danger" style="width:35%;margin:0 auto;"><i class="fa fa-exclamation-triangle"></i>
                            <strong>Erreur</strong> avec le <strong>nom d\'utilisateur</strong> ou le <strong>mot de passe</strong>
                        </div>';
                ?>
            </div>
            <div class="login-body">
                <article class="container-login center-block">
                    <section>
                        <ul id="top-bar" class="nav nav-tabs nav-justified">
                            <li class="active">
                                <a href="#login-access" >
                                    <img class="adm_img-logo2" src="../../public/images/wout.png" style="width:48px;" />
                                    <span class="adm_connect_text">WOUT'I</span>
                                </a>
                            </li>
                        </ul>
                        <br />
                        <div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12">
                            <div id="login-access" class="tab-pane fade active in">
                                <form method="post" accept-charset="utf-8" autocomplete="off" role="form" class="form-horizontal">
                                    <div class="form-group ">
                                        <label for="login" class="sr-only">Email</label>
                                        <div class="input-group input-group">
                                            <input type="text" class="form-control" name="nomutilisateur" placeholder="Email" tabindex="1" value="" required />
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="password" class="sr-only">Mot de passe</label>
                                        <div class="input-group input-group">
                                            <input type="password" class="form-control" name="motdepasse" placeholder="Mot de passe" value="" tabindex="2" required />
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="form-group ">
                                        <button type="submit" name="WoutiOAuthRun" tabindex="5" class="btn btn-info zzz">
                                            Se connecter <i class="glyphicon glyphicon-log-in"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </article>
            </div>
        </div>
    </body>
</html>