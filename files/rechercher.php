<?php
    require_once('../app_core/Methodes.php');
    if(isset($_POST['btn_rech'])){
        /*validation de la recherche*/
        if(!ctype_space($_POST['champ_rech']) && strlen($_POST['champ_rech'])>2) {
            $_SESSION['mot_cle'] = $_POST['champ_rech'];
            header("location: index.php?78dfvg552&f=results&mot=" . $_SESSION['mot_cle']);
        }
	}
?>
<div class="row vertical-center">
    <div class="col-lg-8 alert alert-info" style="border-radius: 0;text-align: center">
        En poursuivant votre navigation dans notre site web vous certifiez avoir lu et accepté toutes nos condition d'utilisations.
        Si vous ne les acceptez pas allez vous faire foutre s'il vous plait. Wouti !<br>
        <a href="index.php?redirect64564dde7a&f=charte&bvcn57">Lire nos <strong>Conditions Générales d'Utilisation</strong></a>
    </div>
</div>
<div class="row vertical-center">
	<div class="col-lg-6 bigLogo bigLogoRech">
		<img class="img-responsive" src="../public/images/glo.png" />
	</div>
</div>
<div class="row vertical-center">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 searchbox ">
		<form method="POST" action="index.php?78dfvg552&f=rechercher" class="">
			<input type="text" name="champ_rech" id="recherche" class="rechercher" autocomplete="on" placeholder="<?=_("Qu'avez-vous perdu")?> ?"/>
			<button type="submit" name="btn_rech" class="bttn">Go</button>
		</form>
	</div>
</div>
<!--<div class="row">
	<div class="panel panel-default plusrecherches">
		<div class="panel-heading">
			<h3 class="panel-title">Les +recherchés</h3>
		</div>
		<div class="panel-body">
			<span class="badge"><a href="index.php?78dfvg552&f=results&mot=carte identité&hash=quick">Carte identité</a></span>
			<span class="badge"><a href="index.php?78dfvg552&f=results&mot=argent&hash=quick">Argent</a></span>
			<span class="badge"><a href="index.php?78dfvg552&f=results&mot=portable&hash=quick">Portable</a></span>
			<span class="badge"><a href="index.php?78dfvg552&f=results&mot=document&hash=quick">Document</a></span>
			<span class="badge"><a href="index.php?78dfvg552&f=results&mot=passeport&hash=quick">Passeport</a></span>
			<span class="badge"><a href="index.php?78dfvg552&f=results&mot=clef&hash=quick">Clef</a></span>
			
		</div>
	</div>
</div>-->
<br />