<?php require_once('../app_core/Methodes.php');?>
<style type="text/css">
	textarea.boxDet{resize:none;}
</style>
<div class="row">
	<div class="col-lg-6 bigLogo bigLogoDeclar vertical-center">
		<img class="img-responsive" src="../public/images/glo.png" />
	</div>
</div>
<form method="POST" action="index.php?eeffws017&f=ajout#77dfzzz" class="declareForm">
	<div class="row declarebox">
		<div class="col-xs-12 col-sm-11 col-md-6 col-lg-5">
			<div class="etape_1">
				<header class="page-header"><?=_("Quelques informations sur vous")?></header>
				<input type="hidden" name="id_finder" />
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-group boxNom" autofocus autocomplete="off" name="nom_finder" placeholder="<?=_("Nom")?>"   />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-group boxPrenom" name="prenom_finder" placeholder="<?=_("Prénom")?>" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-group boxAddr" name="addr_finder" placeholder="<?=_("Où habitez-vous")?> ?" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-group boxTel" autocomplete="off" name="tel_finder" placeholder="<?=_("Numero de tél.")?> ex: 77 - 78 - 70 - 76 - 33"  />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="mail" class="form-control form-group boxMail" autocomplete="off" name="mail_finder" placeholder="Email" />
                    </div>
                </div>
            </div>
		</div>
		<div class="sseparate"></div>
		<div class="col-xs-12 col-sm-11 col-md-6 col-lg-5" >
			<div class="etape_2">
				<header class="page-header"><?=_("Quelques informations sur l'objet")?></header>
				<input type="hidden" name="id_objet">
				<div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="nature_objet" id="recherche" autocomplete="on" class="form-control form-group boxNat" placeholder="<?=_("Nature, Type de l'objet")?>"    />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="addr_objet" autocomplete="off" class="form-control form-group boxAddrObj" placeholder="<?=_("Où l'avez-vous ramassé")?> ?" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <textarea rows="6" name="details_objet" autocomplete="off" class="form-control form-group boxDet" placeholder="<?=_("Quelques détails sur l'objet")?>"  ></textarea>
                    </div>
                </div>
            </div>
		</div>
	</div>

	<div class="row bt_div vertical-center">
        <div align="center" style="margin-top: 3rem">
            <div class="col-sm-12" style="/*margin-left:-4%*/">
                <button type="submit" name="bt_valider" class="btn btn-success" id="valDeclFormByn"><?=_("Enregistrer")?>
                <span class="glyphicon glyphicon-ok"></span></button>
            </div>
        </div>
    </div>
    <?php
        if(isset($_GET['feedback']) && !empty($_GET['feedback'])) {
            $retour = cleanStringWData($_GET['feedback']);
            if($retour==='error'){
                echo '<div class="error-form" style="text-align: center;color: firebrick">
                    <h5><i class="fa fa-exclamation-triangle"></i>Vous avez mal saisie vos données, réessayez s.v.p
                        <i class="fa fa-exclamation-triangle"></i>
                    </h5>
                </div>';
            }
        }
    ?>
</form>
<br />
		