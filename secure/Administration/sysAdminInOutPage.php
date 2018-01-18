<?php
    @session_start();
    require_once '../../app_core/Methodes.php';
    sysConnectedUserControl();
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
        <!-- Connexion à notre Espace Admin -->
        <div class="container">
            <?php
                if(isset($_GET['status']) && $_GET['status'] === 'connected') {
                    echo '<div class="" style="width:20%;margin:0 auto;padding-top: 15%">
                    <p style="text-align: center">
                    <i class="fa fa-spinner fa-pulse fa-4x fa-fw" style="color:#3498db"></i>
                    <label style="display: block">Connexion en cours...</label></p>
                </div>';
                    waitBeforeRedirecTo(rand(1, 5), 'index-old');
                }
            ?>
        </div>
        <!-- DeConnexion de notre Espace Admin -->
        <div class="container">
            <?php
            if(isset($_GET['status']) && $_GET['status'] === 'disconnecting') {
                echo '<div class="" style="width:20%;margin:0 auto;top:0;padding-top: 0px">
                    <p style="text-align: center">
                    <i class="fa fa-spinner fa-spin fa-4x fa-fw" style="color:firebrick"></i>
                    <label style="display: block">Patientez, déconnexion en cours...</label></p>
                </div>';
                sysDeconnect();
                waitBeforeRedirecTo(rand(1, 5), 'index');
            }
            ?>
        </div>
    </body>
</html>