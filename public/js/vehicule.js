// =======================================================
//                      Script  filtre
// =======================================================

// Ce Script me permet de faire disparaitre les catégories de véhicules
// Et de les faire réapparaître en fonction des critères de recherche

$(document).ready(function () {
    var selected = [];

    $('.card-group').hide();
    $('#radio0').click(function () {
        $('.card-group').hide('slow', 'swing');
    });
    $('#radio1').click(function () {
        $('.card-group').show('slow', 'swing');
    });
    $('#radio2').click(function () {
        $('.card-group').hide('slow', 'swing');
    });
    $('#radio3').click(function () {
        $('.card-group').hide('slow', 'swing');
    });
    $('#radio4').click(function () {
        $('.card-group').hide('slow', 'swing');
    });

    // Ce script me permet de mettre la catégorie (Tous, Voiture, Utilitaires, 2 Roues, Luxes) choisie en gras
    // Il me permet également de filtrer mes éléments sur base de ma recherche
    // console.log(this);
    $('#radio0').ready(function () {
        document.getElementById('Tous').style.fontWeight = 'bold';
        $('#radio0').click(function () {
            document.getElementById("Tous").style.fontWeight = 'bold';
            document.getElementById("V").removeAttribute('style');
            document.getElementById("utilitaires").removeAttribute('style');
            document.getElementById("2roues").removeAttribute('style');
            document.getElementById("luxe").removeAttribute('style');

            $('.myFliter').each(function (i, j) {
                $(this).addClass("collapse");
                for (let item of selected.values()){
                    if($(this).hasClass(item)){
                        $(this).removeClass("collapse");
                        // console.log($(this));
                    }
                }
                if($(this).hasClass('utilitaires')){
                    $(this).removeClass("collapse");
                    // console.log($(this));
                }
                if($(this).hasClass('2roues')){
                    $(this).removeClass("collapse");
                    // console.log($(this));
                }
                if($(this).hasClass('luxe')){
                    $(this).removeClass("collapse");
                    // console.log($(this));
                }
                if (selected.length==0){
                    $(this).removeClass("collapse");
                }
            });
        });
    });

    $('#radio1').click(function () {
        document.getElementById("V").style.fontWeight = 'bold';
        document.getElementById("Tous").removeAttribute('style');
        document.getElementById("utilitaires").removeAttribute('style');
        document.getElementById("2roues").removeAttribute('style');
        document.getElementById("luxe").removeAttribute('style');

        $('.myFliter').each(function (i, j) {
            $(this).addClass("collapse");
            for (let item of selected.values()){
                if($(this).hasClass(item)){
                    $(this).removeClass("collapse");
                    // console.log($(this));
                }
            }
            if (selected.length==0){
                $(this).removeClass("collapse");
            }
            if($(this).hasClass('utilitaires')){
                $(this).addClass("collapse");
                // console.log($(this));
            }
            if($(this).hasClass('2roues')){
                $(this).addClass("collapse");
                // console.log($(this));
            }
            if($(this).hasClass('luxe')){
                $(this).addClass("collapse");
                // console.log($(this));
            }
        });
    });

    $('#radio2').click(function () {
        document.getElementById("utilitaires").style.fontWeight = 'bold';
        document.getElementById("V").removeAttribute('style');
        document.getElementById("2roues").removeAttribute('style');
        document.getElementById("luxe").removeAttribute('style');
        document.getElementById("Tous").removeAttribute('style');

        $('.myFliter').each(function (i, j) {
            $(this).addClass("collapse");
            if($(this).hasClass('utilitaires')){
                $(this).removeClass("collapse");
                // console.log($(this));
            }
            if($(this).hasClass('2roues')){
                $(this).addClass("collapse");
                // console.log($(this));
            }
            if($(this).hasClass('luxe')){
                $(this).addClass("collapse");
                // console.log($(this));
            }
        });
    });
    $('#radio3').click(function () {
        document.getElementById("2roues").style.fontWeight = 'bold';
        document.getElementById("utilitaires").removeAttribute('style');
        document.getElementById("V").removeAttribute('style');
        document.getElementById("luxe").removeAttribute('style');
        document.getElementById("Tous").removeAttribute('style');

        $('.myFliter').each(function (i, j) {
            $(this).addClass("collapse");
            if($(this).hasClass('2roues')){
                $(this).removeClass("collapse");
                // console.log($(this));
            }
            if($(this).hasClass('utilitaires')){
                $(this).addClass("collapse");
                // console.log($(this));
            }
            if($(this).hasClass('luxe')) {
                $(this).addClass("collapse");
            }
        });
    });
    $('#radio4').click(function () {
        document.getElementById("luxe").style.fontWeight = 'bold';
        document.getElementById("V").removeAttribute('style');
        document.getElementById("2roues").removeAttribute('style');
        document.getElementById("utilitaires").removeAttribute('style');
        document.getElementById("Tous").removeAttribute('style');

        $('.myFliter').each(function (i, j) {
            $(this).addClass("collapse");
            if($(this).hasClass('luxe')){
                $(this).removeClass("collapse");
                // console.log($(this));
            }
            if($(this).hasClass('utilitaires')){
                $(this).addClass("collapse");
                // console.log($(this));
            }
            if($(this).hasClass('2roues')) {
                $(this).addClass("collapse");
            }
        });
    });


    // Ce script me permet d'afficher les véhicules en fonction du lieu
    // $('#mySelect1').click(function () {
    //     document.getElementById("affAgence").
    // });



    // Ce script me permet de changer la couleur des icones-catégorie
    // Il me permet également de faire la recherche sur base des critères choisies

    $('.filter').on("click", function() {
        var field = $(this);
        var isSet = $(this).css('box-shadow');

        if (isSet !== 'none'){
            field.css('box-shadow', 'none');

            selected = $.grep(selected, function (value, index, arr) {
                return value !== field.attr('id');
            });
        }
        else{
            field.css('box-shadow', '0 4px 8px 0 #F57F17');

            selected.push(field.attr('id'));
        }
        // $('#res').text(selected);
        console.log(selected);
        $('.myFliter').each(function (i, j) {
            $(this).addClass("collapse");
            for (let item of selected.values()){
                if($(this).hasClass(item)){
                    $(this).removeClass("collapse");
                    // console.log($(this));
                }
            }
            if (selected.length==0){
                $(this).removeClass("collapse");
            }
        });
    });

    console.log('vehicule.js');
// =======================================================
//                          Script Modal
//  =========================================================
    $('[id^=vehicule]').click(function () {
        console.log(this.id);
        var marqueModele = this.id.substr(8,4);
        var nameCard = 'card' + marqueModele;
        console.log(marqueModele);
        console.log(nameCard);
        console.log($('#'+nameCard));
        var titre = $('#'+nameCard).children(".marque-modele").html();
        var descr = $('#'+nameCard).children(".descr").html();
        var caract = $('#'+nameCard).children(".caract").html();
        var origine1 = $('#'+nameCard).children(".origine1").html();
        var origine2 = $('#'+nameCard).children(".origine2").html();
        var origine3 = $('#'+nameCard).children(".origine3").html();
        $('#marqueModele').html(titre);
        $('#caracteristique').html(descr);
        $('#caracteristique').html(caract);
        $('#pays').html(origine1);
        $('#ville').html(origine2);
        $('#aeroport').html(origine3);
        $('#myModal').show();
    });
    $('.close').click(function () {
        $('#myModal').hide();
    })
});


