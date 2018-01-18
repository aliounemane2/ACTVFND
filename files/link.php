<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="revisit-after" content="7 days" />
<meta name="language" content="fr" />
<meta name="robots" content="index, follow" />
<meta name="googlebot" content="index, follow" />
<meta name="description" content="Creation de site internet au Sénégal" />
<meta name="keywords" content="Creation,site internet,Sénégal,web design, Webmaster, Senegal,creation de logo, graphic designer,imprimerie au senegal" />
<meta name="copyright" content="Maxima International" />
<meta name="author" content="Maxima International" />
<title>Creation de site internet au Sénégal</title>
<script src="js/jquery-dev.js"></script>
<!--[if IE 7]><link rel="stylesheet" href="/wp-content/themes/whiteSEN/ie7.css" type="text/css" title="default" media="screen" /><![endif]-->

<!--[if IE 6]><link rel="stylesheet" href="/wp-content/themes/whiteSEN/ie6.css" type="text/css" title="default" media="screen" /><![endif]-->

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">Cufon.set('fontFamily','white');Cufon.replace('#content h1',{fontWeight:'400',textShadow:'#fff 1px 1px 1px',hover:true});Cufon.replace('h2',{fontWeight:'400',textShadow:'#fff 1px 1px 1px',hover:true});Cufon.replace('h3',{fontWeight:'400',textShadow:'#fff 0 1px 1px',hover:true});Cufon.replace('h4',{fontWeight:'400',textShadow:'#ccc 0 1px 1px',hover:true});Cufon.replace('h5',{fontWeight:'400',textShadow:'#fff 0 1px 1px',hover:true});Cufon.replace('.heading',{fontWeight:'400',textShadow:'#000 1px 1px 1px',hover:true});Cufon.replace('.reference h2',{fontWeight:'400',textShadow:'#fff 1px 1px 1px',hover:true});Cufon.replace('.description h2',{fontWeight:'400',textShadow:'#fff 2px 2px 2px',hover:true});Cufon.replace('.bigdate',{fontWeight:'700',textShadow:'#000 0 2px 2px',hover:true});Cufon.replace('.memo',{fontWeight:'400',textShadow:'#000 0 1px 1px',hover:true});</script>
<script type="text/javascript">$(function(){$('#accordion > li').hover(function(){var $this=$(this);$this.stop().animate({'width':'480px'},500);$('.heading',$this).stop(true,true).fadeOut();$('.bgDescription',$this).stop(true,true).slideDown(500);$('.description',$this).stop(true,true).fadeIn();},function(){var $this=$(this);$this.stop().animate({'width':'115px'},1000);$('.heading',$this).stop(true,true).fadeIn();$('.description',$this).stop(true,true).fadeOut(500);$('.bgDescription',$this).stop(true,true).slideUp(700);});});</script>
<style type="text/css">
/* Share button */

/* outer wrapper */
#share-wrapper {
    margin-top: 100px;
    position:fixed;
    left: 0;
    z-index:9999;
}

/* inner wrapper */
#share-wrapper ul.share-inner-wrp{
    list-style: none;
    margin: 0px;
    padding: 0px;
}

/* the list */
#share-wrapper li.button-wrap {
    background: #E4EFF0;
    padding: 0px 0px 0px 10px;
    display: block;
    width: 140px;
    margin: 0px 0px 1px -117px;
}

/* share link */
#share-wrapper li.button-wrap > a {
    padding-right: 60px;
    height: 32px;
    display: block;
    line-height: 32px;
    font-weight: bold;
    color: #444;
    text-decoration: none;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
}

/* background image for each link */
#share-wrapper .facebook > a{
    background: url(images/fbk.jpg) no-repeat right;
}
#share-wrapper .twitter > a{
    background: url(images/fbk.jpg) no-repeat right;
}
#share-wrapper .digg > a{
    background: url(images/fbk.jpg) no-repeat right;
}
.stumbleupon > a{
    background: url(images/fbk.jpg) no-repeat right;
}
#share-wrapper .delicious > a{
    background: url(images/fbk.jpg) no-repeat right;
}
#share-wrapper .google > a{
    background: url(images/fbk.jpg) no-repeat right;
}
#share-wrapper .email > a{
    background: url(images/fbk.jpg) no-repeat right;
}
/* small screen */
@media all and (max-width: 699px) {
    #share-wrapper {
        bottom: 0;
        position: fixed;
        padding: 5px 5px 0px 5px;
        background: #EBEBEB;
        width: 100%;
        margin: 0px;
        -webkit-box-shadow: 0 -1px 4px rgba(0, 0, 0, 0.15);
        -moz-box-shadow: 0 -1px 4px rgba(0,0,0,0.15);
        -o-box-shadow: 0 -1px 4px rgba(0,0,0,0.15);
        box-shadow: 0 -1px 4px rgba(0, 0, 0, 0.15);
    }
    #share-wrapper ul.share-inner-wrp {
        list-style: none;
        margin: 0px auto;
        padding: 0px;
        text-align: center;
        overflow: auto;
    }
    #share-wrapper li.button-wrap {
        display: inline-block;
        width: 32px!important;
        margin: 0px;
        padding: 0px;
        margin-left:0px!important;
    }
    #share-wrapper li.button-wrap > a {
        height: 32px;
        display: inline-block;
        text-indent: -10000px;
        width: 32px;
        padding-right: 0;
        float: left;
    }
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    var pageTitle = document.title; //HTML page title
    var pageUrl = location.href; //Location of the page

    
    //user hovers on the share button   
    $('#share-wrapper li').hover(function() {
        var hoverEl = $(this); //get element
        
        //browsers with width > 699 get button slide effect
        if($(window).width() > 699) { 
            if (hoverEl.hasClass('visible')){
                hoverEl.animate({"margin-left":"-117px"}, "fast").removeClass('visible');
            } else {
                hoverEl.animate({"margin-left":"0px"}, "fast").addClass('visible');
            }
        }
    });
        
    //user clicks on a share button
    $('.button-wrap').click(function(event) {
            var shareName = $(this).attr('class').split(' ')[0]; //get the first class name of clicked element
            
            switch (shareName) //switch to different links based on different social name
            {
                case 'facebook':
                    var openLink = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);
                    break;
                case 'twitter':
                    var openLink = 'http://twitter.com/home?status=' + encodeURIComponent(pageTitle + ' ' + pageUrl);
                    break;
                case 'digg':
                    var openLink = 'http://www.digg.com/submit?phase=2&amp;url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);
                    break;
                case 'stumbleupon':
                    var openLink = 'http://www.stumbleupon.com/submit?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);
                    break;
                case 'delicious':
                    var openLink = 'http://del.icio.us/post?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);
                    break;
                case 'google':
                    var openLink = 'https://plus.google.com/share?url=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle);
                    break;
                case 'email':
                    var openLink = 'mailto:?subject=' + pageTitle + '&body=Found this useful link for you : ' + pageUrl;
                    break;
            }
        
        //Parameters for the Popup window
        winWidth    = 650;  
        winHeight   = 450;
        winLeft     = ($(window).width()  - winWidth)  / 2,
        winTop      = ($(window).height() - winHeight) / 2, 
        winOptions   = 'width='  + winWidth  + ',height=' + winHeight + ',top='    + winTop    + ',left='   + winLeft;
        
        //open Popup window and redirect user to share website.
        window.open(openLink,'Share This Link',winOptions);
        return false;
    });
});
</script>
</head>
<body>
<div id="share-wrapper">
    <ul class="share-inner-wrp">
        <!-- Facebook -->
        <li class="facebook button-wrap"><a href="#">Facebook</a></li>
        
        <!-- Twitter -->
        <li class="twitter button-wrap"><a href="#">Tweet</a></li>
        
         <!-- Digg -->
        <li class="digg button-wrap"><a href="#">Digg it</a></li>
        
        <!-- Stumbleupon -->
        <li class="stumbleupon button-wrap"><a href="#">Stumbleupon</a></li>
      
         <!-- Delicious -->
        <li class="delicious button-wrap"><a href="#">Delicious</a></li>
        
        <!-- Google -->
        <li class="google button-wrap"><a href="#">Plus Share</a></li>
        
        <!-- Email -->
        <li class="email button-wrap"><a href="#">Email</a></li>
    </ul>
</div>
</body>
<html>