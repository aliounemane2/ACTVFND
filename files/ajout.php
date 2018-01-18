<?php
require_once('../app_core/Connexion.php');
require_once('../app_core/Finder.php');
require_once('../app_core/Objet.php');
require_once('../app_core/Owner.php');
require_once('../app_core/Cas.php');

$con = new ConnexionBd();
$connexion = $con->getConnexion();
if (isset($_POST['bt_valider'])) {
    /*validation des data*/
    $etat = 'ok';
    /**
     * ok : tout bien
     * bad : pb de transaction
     * ko : mauvaise validation des donnees du form
     */
    $checksum = WoutiFormChecksum($_POST);
    if ($checksum['sommeDeControl'] == $checksum['total']) {
        /*starting transaction*/
        try {
            $connexion->beginTransaction();

            /*test si un finder avec le mm num tel exist au deja dans notre sys*/
            $finder_existance = Finder::isFinderExistDeja($connexion, trim($_POST['tel_finder']));
            if ($finder_existance) {
                /*recup id du finder qui se trouvai deja dans notre sys*/
                $id_finder = Finder::getIdFinderByNumTel($connexion, trim($_POST['tel_finder']));
                if(strlen($id_finder)>0) $insert_f = true;
            } else {
                /*nous som en presence d'un nvo finder --> on l'ajoute dans le system*/
                $finder = new Finder($_POST['nom_finder'], $_POST['prenom_finder'], trim($_POST['tel_finder']), $_POST['addr_finder'], $_POST['mail_finder']);
                $id_finder = $finder->getId();
                $insert_f = $finder->insertion($connexion);
            }

            $objet = new Objet(htmlentities($_POST['nature_objet']), $_POST['addr_objet'], $_POST['details_objet']);
            /*$owner = new Owner();*/
            $cas = new Cas($id_finder, $objet->getIdObjet(), null);
            $insert_ob = $objet->InsertionObjet($connexion);
            //$insert_ow = $owner->insertion($connexion);
            $insert_c =  $cas->insertionCas($connexion);
            unset($_POST);
            //Afficher message de succes
            //Attendre quelques secondes
            //Rediriger le site vers la déclaration

            if($insert_c && $insert_ob && $insert_f){
                $connexion->commit();
                ?>
                <div class="container" style="padding-top:0">
                    <div class="row bigLogo vertical-center">
                        <img class="img-responsive" src="images/logo/wouti_90_902.png"/>
                    </div>
                    <div class="row vertical-center">
                        <div class="alert span2 alert-info" style="width:70%;text-align: center">
                            <h3>Déclaration réussie !</h3>

                            <p class="decl-success">Attendez-vous à être contacté.<br>
                                Merci d'avoir accomplie ce geste citoyen <i class='fa fa-smile-o fa-lg'></i>.<br>
                                <!--                Patientez s.v.p, vous allez être redirigé dans quelques secondes...</p>-->
                        </div>
                    </div>
                    <div class="row vertical-center">
                        <div class="alert span2 alert-danger" style="width:70%;text-align: center">
                            <h3>ATTENTION</h3>

                            <p class="" style="text-align: left">
                                <i class="fa fa-exclamation-circle fa-fw"></i>PRENEZ LA PEINE DE VOUS DONNER RENDEZ VOUS
                                DANS UNE PLACE PUBLIQUE afin de réduire les risques de corruption ou d'agressions.<br>
                                <i class="fa fa-exclamation-circle fa-fw"></i>Veuillez-vous assurer que celui qui a pris
                                contact avec vous est bel et bien le propriétaire en lui posant des questions sur des
                                détails précis que seul(e) lui ou elle devrait savoir!<br>
                                <i class="fa fa-exclamation-circle fa-fw"></i>Si l'objet est accompagné de références (nom,
                                numero ou n'importe quel information permettant d'identifier directement le propriétaire)
                                questionnez le sur ces references.<br>
                                <i class="fa fa-exclamation-circle fa-fw"></i>Si quiconque vous appelle pour vous dire qu'il
                                fait partie des gérants du site WOUTI, ne lui donnez aucune infos sur l'objet sachez que
                                c'est de l'arnaque.
                            </p>
                        </div>
                    </div>
                </div>
                <?php
                    waitBeforeRedirecWithParams(180,'../public/index','todo=generated&f=declarer&sdfnlsd741');
                    //header("Refresh: 180;../public/index.php?sksjdnsdset_cookie=hosted&todo=generated&f=declarer&sdfnlsd741");
            }else{
                $connexion->rollBack();
                //redirecTo('index.php?zzdxc14fer5&f=declarer&feedback=error');
                echo 'bad validation';
                $etat = 'bad';
            }
        }catch(Exception $e){
            //on annule la transation
            $connexion->rollback();
            //redirecTo('index.php?zzdxc14fer5&f=declarer&feedback=error');
            echo 'bad validation';
            $etat = 'bad';
        }
    }else{
        //redirecTo('index.php?zzdxc14fer5&f=declarer&feedback=error');
        echo 'bad validation';
        $etat = 'ko';
    }
}
?>