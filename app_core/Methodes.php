<?php
    @session_start();

    /*nettoyage d'une chaine de caracteres*/
	function nettoyer($chaine){
        return strip_tags(@mysql_real_escape_string($chaine));
	}
    function status($chaine){if($chaine==0) return 'En cours'; else return 'Expiré';}
    function codeUrlVar($var){return $var+woutiCoreSystem::URVARLKEY;}
    function decodeUrlVar($var){return $var-woutiCoreSystem::URVARLKEY;}
    /*Redirections*/
    function redirecTo($destination){
        header('Location:'.$destination.'.php');
    }
    function waitBeforeRedirecTo($pause, $destintion){
        header('Refresh:'.$pause.', '.$destintion.'.php');
    }
    function redirecWithParams($destination, $params){
        header('Location:'.$destination.'.php?'.$params);
    }
    function waitBeforeRedirecWithParams($pause, $destintion, $params){
        header('Refresh:'.$pause.', '.$destintion.'.php?'.$params);
    }

    /*fonction pour la pagination des pages*/
    function ctrl_pagine($total, $page, $shown, $url) {
        $pages = ceil( $total / $shown );
        $range_start = ( ($page >= 5) ? ($page - 3) : 1 );
        $range_end = ( (($page + 5) > $pages ) ? $pages : ($page + 5) );
        if ( $page > 1 ) {
/*            $r[] = '<span><a href="'. $url .'">&laquo; first</a></span>';*/
            $r[] = '<span><a href="'. $url . ( $page - 1 ) .'"><i class="fa fa-chevron-circle-left fa-fw fa-lg"></i></a></span>';
            $r[] = ( ($range_start > 1) ? ' ... ' : '' );
        }

        if ( $range_end >= 1 ) {
            foreach(range($range_start, $range_end) as $key => $value) {
                if ( $value == ($page) ) $r[] = '<span>'. $value .'</span>';
                else $r[] = '<span><a href="'. $url . ($value) .'">'. $value .'</a></spans>';
            }
        }

        if ( ($page) < $pages ) {
            $r[] = ( ($range_end < $pages) ? ' ... ' : '' );
            $r[] = '<span><a href="'. $url . ( $page + 1 ) .'"><i class="fa fa-chevron-circle-right fa-fw fa-lg"></i></a></span>';
/*            $r[] = '<span><a href="'. $url . ( $pages - 1 ) .'">last &raquo;</a></span>';*/
        }
        return ( (isset($r)) ? '<div class="pagination">'. implode("\r\n", $r).'</div>' : '');
    }

    //derniere etape deconnexion
    function sysDeconnect(){
        unset($_SESSION);
        unset($tableau);
        unset($_GET);
        $_SESSION = "";
        $tableau = "";
        $_GET = "";
        session_destroy();
    }
    function sysConnectedUserControl(){
        if(!isset($_SESSION['connected']) || $_SESSION['connected']!=='connected' ||
            !isset($_SESSION['identifier']) || $_SESSION['identifier']=='' ||
            !isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']==''){
                redirecTo('index');
        }
    }

    /*fonctions pour la langue du systeme*/
    function getSysLang(){

    }
    function changeSysLang($lang){

    }
    function ifSelected($langue, $value){
        if($langue==$value)
            return 'selected';
    }

    function menuCourant($page, $menuItem){
        if($page===$menuItem)
            return ' w_activeMenu';
    }
    function WoutiFormChecksum($tableau){
        $sum = 0;
        $numtel = $tableau['tel_finder'];
        $email = $tableau['mail_finder'];
        $nom = cleanStringWData($tableau['nom_finder']); if(strlen($nom)>0 && !ctype_space($nom)) $sum++;
        $prenom = cleanStringWData($tableau['prenom_finder']); if(strlen($prenom)>0 && !ctype_space($prenom)) $prenom="";/*$sum++;*/
        $addr = cleanStringWData($tableau['addr_finder']); if(strlen($addr)>0 && !ctype_space($addr)) $addr="";/*$sum++;*/
        if(isWoutiNumberFormat($tableau['tel_finder'])){$numtel = $tableau['tel_finder']; $sum++;}
        if(isValidEmail($tableau['mail_finder'])){ $email = $tableau['mail_finder'];/*$sum++;*/}
        $nature = cleanStringWData($tableau['nature_objet']); if(strlen($nature)>0 && !ctype_space($nature)) $sum++;;
        $ramasse = cleanStringWData($tableau['addr_objet']); if(strlen($ramasse)>0 && !ctype_space($ramasse)) $sum++;;
        $details = cleanStringWData($tableau['details_objet']); if(strlen($details)>0 && !ctype_space($details)) $sum++;
        $response = array(
            'sommeDeControl'=>$sum,
            'nom'=>$nom,
            'prenom'=>$prenom,
            'addr_f'=>$addr,
            'tel'=>$numtel,
            'mail'=>$email,
            'nature'=>$nature,
            'rams_vers'=>$ramasse,
            'details'=>$details,
            'total'=>5
        );
        return $response;
    }
    function cleanStringWData($donnees){
        /*enlever char speciaux enlever les tags enlever */
        $string = filter_var($donnees, FILTER_SANITIZE_STRING);
        return $string;
    }
    function isValidEmail($email){
        $valid = true;
        $vmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($vmail, FILTER_VALIDATE_EMAIL)) $valid = false;
        return $valid;
    }
    function isWoutiNumberFormat($number){
        /* valide si le format du numero recu est du genre 009chiffre
        ** tenir compte de 221/ +221 / +00221/ 00221
        ** 77 / 78 / 33 / 76 / 70 + 07chifrres*/
        $full07 =0;$middle03=0;$last04=0;
        $normal = 9;
        $valid = true;
        $valid_number = array('77','70','78','76','33');
        $taille = strlen($number);
        if (!filter_var($number, FILTER_VALIDATE_INT) || $taille > $normal || $taille < $normal){
            $valid = false;
        } else if(filter_var($number, FILTER_VALIDATE_INT) && $taille==9){
            $prefix = substr($number,0,2);
            $full07 = substr($number,2,strlen($number));
            $middle03 = substr($number,2,3);
            $last04 = substr($number,5,strlen($number));
            /*echo $number.'<br>'.$full07.'<br>'.$middle03.'<br>'.$last04;*/
            if(!in_array($prefix,$valid_number) || strval($full07)==='0000000'
                || strval($middle03)==='000' || strval($last04)==='0000'){
                    $valid = false;
            }
        }
        return $valid;
    }
    function getOpertatorByCall($number){
        $op = 'Inconnu';
        if(isWoutiNumberFormat($number)){
            $prefix = substr($number,0,2);
            switch ($prefix){
                case '77':$op='Orange';break;
                case '78':$op='Orange';break;
                case '76':$op='Tigo';break;
                case '70':$op='Expresso';break;
                case '33':$op='Fixe';break;
            }
        }
        return $op;
    }
?>