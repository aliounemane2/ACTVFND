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


    /* La barre de recheche */
    $('.rechercher')
        .focusin(function(e){
            $(this)
                .finish()
                .animate(
                    {"width":"57%","margin-left":".5%"},{"duration":"slow"}
                )
        .focusout(function(e){
            $(this)
                .finish()
                .animate(
                    {"width":"50%","margin-left":"5%"}, "fast"
                )
        });
    });

    /* Les block rechercher et declarer dans l'accueil */
    $('.rech')
        .mouseenter(function(){
            $('#itemFirst')
                .finish()
                .animate(
                    {"height":"40%","background-color":"rgb(244,244,244)","color":"#ffffff"},{"duration":"normal"}
                )
            $('#itemFirst>img#imgFirst')
                .finish()
                .animate(
                    {"margin-top":"1%","opacity":".9"},{"duration":"normal"}
                )
            $('#itemLast')
                .finish()
                .animate(
                    {"height":"60%"},{"duration":"normal"}
                )
        });

    $('.bt_f')
        .mouseenter(function(){
            $('#itemFirst')
                .finish()
                .animate(
                    {"height":"40%","background-color":"rgb(244,244,244)","color":"#ffffff"},{"duration":"normal"}
                )
            $('#itemFirst>img#imgFirst')
                .finish()
                .animate(
                    {"margin-top":"1%","opacity":".9"},{"duration":"normal"}
                )
            $('#itemLast')
                .finish()
                .animate(
                    {"height":"60%"},{"duration":"normal"}
                )
        });

        $('#itemLast, .bt_f').mouseout(function(e){
            $('#itemFirst')
                //.finish()
                .animate(
                    {"height":"100%","background-color":"rgba(255,255,255,0)"},{"duration":"fast"}
                )
            $('#itemFirst>img#imgFirst')
                //.finish()
                .animate(
                    {"margin-top":"35%","opacity":"0.2"},{"duration":"normal"}
                )
            $('#itemLast')
                //.finish()
                .animate(
                    {"height":"0%"},{"duration":"fast"}
                )
        });

        /* Envoi de toute la page avis_form à notre facebox */
        $('div>a.file_avis').facebox();
});
