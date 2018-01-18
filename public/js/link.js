$(document).ready(function() {
    var pageTitle = document.title; //HTML page title
    var pageUrl = location.href; //Location of the page

    /* Autocompletion pour la barre de recherche standard*/
    var wouti_words = [
        "carte identité",
        "carte scolaire",
        "carte bancaire",
        "permis de conduire",
        "passeport",
        "clef domicile",
        "clef voiture",
        "or",
        "argent",
        "portable",
        "document",
        "bijoux",
        "sac à dos",
        "sac à main",
        "ordinateur",
        "enfant",
        "marchandise",
        "télévision",
        "tablette",
        "lecteur",
        "porte monnaie",
        "portefeuille",
        "pochette",
        "livre",
        "homme perdu",
        "enfant perdu",
        "femme perdu",
        "permis de conduire",
        "perruque",
        "voile",
        "badge",
        "tissu",
        "chemise",
        "pagne",
        "soulier",
        "bague",
        "veste",
        "bracelet",
        "chapeau",
        "collier",
        "costume",
        "colis",
        "casques",
        "carton",
        "écouteur",
        "enveloppe",
        "foulard",
        "puce téléphone",
        "livre",
        "roman",
        "bouquin",
        "cahier",
        "registre",
        "magazine",
        "médicaments",
        "bulletin",
        "reçu",
        "relevé",
        "relevé de notes",
        "bulletin de notes",
        "trousseau",
        "tableau art",
        "caméra",
        "caméoscope",
        "micro",
        "carte gab",
        "chapelet",
        "rallonge",
        "chaussures",
        "vetements",
        "tente",
        "bache",
        "radio",
        "appareil numerique",
        "appareil photo",
        "chargeur",
        "guitare",
        "montre",
        "vélo",
        "valise",
        "tout",
        "autres"
    ];
    $('#recherche').autocomplete({
        source : wouti_words,
        minLength : 3
    });


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
    /*$('.rech')
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
        });*/

    $('.bt_f')
        .mouseenter(function(){
            $('div.rech a.zone #itemFirst')
                .finish()
                .animate(
                    {"height":"40%","background-color":"rgb(244,244,244)","color":"#ffffff"},{"duration":"normal"}
                )
            $('div.rech a.zone #itemFirst i#animated-i')
                .finish()
                .animate(
                    {"margin-top":"1%","opacity":".9"},{"duration":"normal"}
                )
            $('div.rech a.zone #itemLast')
                .finish()
                .animate(
                    {"height":"60%"},{"duration":"normal"}
                )
        });

        $('div.rech a.zone #itemLast, .bt_f').mouseout(function(e){
            $('#itemFirst')
                //.finish()
                .animate(
                    {"height":"100%","background-color":"rgba(255,255,255,0)"},{"duration":"fast"}
                )
            $('div.rech a.zone #itemFirst i#animated-i')
                //.finish()
                .animate(
                    {"margin-top":"35%","opacity":"0.5"},{"duration":"normal"}
                )
            $('div.rech a.zone #itemLast')
                //.finish()
                .animate(
                    {"height":"0%"},{"duration":"fast"}
                )
        });


    $('.bt_d')
        .mouseenter(function(){
            $('div.decl a.zone #itemFirst')
                .finish()
                .animate(
                {"height":"40%","background-color":"rgb(244,244,244)","color":"#ffffff"},{"duration":"normal"}
            )
            $('div.decl  a.zone #itemFirst i#animated-i')
                .finish()
                .animate(
                {"margin-top":"1%","opacity":".9"},{"duration":"normal"}
            )
            $('div.decl a.zone #itemLast')
                .finish()
                .animate(
                {"height":"60%"},{"duration":"normal"}
            )
        });

    $('div.decl a.zone #itemLast, .bt_d').mouseout(function(e){
        $('div.decl a.zone #itemFirst')
            //.finish()
            .animate(
            {"height":"100%","background-color":"rgba(255,255,255,0)"},{"duration":"fast"}
        )
        $('div.decl a.zone #itemFirst i#animated-i')
            //.finish()
            .animate(
            {"margin-top":"35%","opacity":"0.5"},{"duration":"normal"}
        )
        $('div.decl a.zone #itemLast')
            //.finish()
            .animate(
            {"height":"0%"},{"duration":"fast"}
        )
    });

    /*declare form validation*/
    /*function randomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }
    function generateCaptcha() {
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
    }
    generateCaptcha();
    */
    $('.declareForm')
        .formValidation({
            framework: 'bootstrap',
            /*icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },*/
            fields: {
                nom_finder: {
                    row: '.col-sm-12',
                    validators: {
                        notEmpty: {
                            message: 'Votre prénom'
                        }
                    }
                },
                nature_objet: {
                    row: '.col-sm-12',
                    validators: {
                        notEmpty: {
                            message: 'La nature de l\'objet'
                        },
                        stringLength: {
                            min: 3,
                            message: 'Minimum 3 caractères'
                        }
                    }
                },
                tel_finder: {
                    row: '.col-sm-12',
                    validators: {
                        notEmpty: {
                            message: 'Votre numéro de téléphone'
                        },
                        regexp: {
                            message: 'Numéro de tél. invalide',
                            regexp: /(^77|^70|^76|^78|^33)+[0-9]{7}$/
                        }
                    }
                },
                addr_objet: {
                    row: '.col-sm-12',
                    validators: {
                        notEmpty: {
                            message: 'Où l\'avez-vous rammassé ?'
                        }/*,
                        emailAddress: {
                            message: 'The input is not a valid email address'
                        }*/
                    }
                },
                details_objet: {
                    row: '.col-sm-12',
                    validators: {
                        notEmpty: {
                            message: 'Quelques détails sur l\'objet'
                        },
                        stringLength: {
                            max: 200,
                            message: 'Maximum 200 charactères'
                        }
                    }
                }/*,
                captcha: {
                    validators: {
                        callback: {
                            message: 'Wrong answer',
                            callback: function(value, validator, $field) {
                                var items = $('#captchaOperation').html().split(' '),
                                    sum   = parseInt(items[0]) + parseInt(items[2]);
                                return value == sum;
                            }
                        }
                    }
                }*/
            }
        });
/*
        .on('err.form.fv', function(e) {
            // Regenerate the captcha
            generateCaptcha();
        });
*/

});
