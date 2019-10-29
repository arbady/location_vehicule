// =======================================================
//                      Script  filtre
// =======================================================

// Ce Script me permet de faire disparaitre les catégories de véhicules
// Et de les faire réapparaître en fonction des critères de recherche

$(document).ready(function () {
    let selected = [];
    let filtre_typeCat = "";
    let filtre_lieu = "";

    function filtreGlobale(){

        var filtre = new RegExp('\\b\\w*'+filtre_lieu+'\\w*\\b');
        var filtre2 = new RegExp('\\b\\w*'+filtre_typeCat+'\\w*\\b');

        // Je selectionne tous les elements qui ont la class myFliter, qui representent les véhicules
        // Ensuite, je les cache tous avec un 'hide'
        // Ensuite, j'applique un filtre. Si ce filtre est vrai ('true'), je fais l'action suivante 'show'
        // Enfin, si je renvoie 'false', je m'arrête (pas de 'show'). Le véhicule reste caché.
        $('.myFliter').hide('slow', 'swing').filter(function () {

            var data_name = $(this).data('name');
            let result = true;

            if (filtre_typeCat.length > 0){

                result = false;

                filtre_typeCat.forEach(function (f) {

                    var filtre2 = new RegExp('\\b\\w*'+f+'\\w*\\b');
                    console.log($(this).data('name'));
                    console.log(data_name);

                    if (filtre2.test(data_name)){
                        result = true;
                    }
                });
            }

            if (filtre.test($(this).data('name')) && result){
                return true;
            }else {
                return false;
            }
        }).show('slow', 'swing');

        $('.myFliter').each(function () {
            if ($(this).is(':visible')){
                console.log(2);
            }
            else {
                console.log(3);
            }
        })
    }

    // Ce script me permet d'afficher les véhicules en fonction du lieu

    $('#select1').change(function () {
        console.log($("#select1 option:selected").val());

        filtre_lieu = $("#select1 option:selected").val();
        filtreGlobale();
    });

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

        filtre_typeCat = selected;
        filtreGlobale();
    });

    console.log('vehicule.js');
// =======================================================
//                          Script Modal
//========================================================
    $('[id^=vehicule]').click(function () {
        console.log(this.id);
        var marqueModele = this.id.substr(8,4);
        var btn_res = "<a class=\"btn btn-unique myBtn\" id=\"reserver3\" href=\"/reservation/?id="+marqueModele+" \">Reserver</a>";
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
        $('#btn-res-modal').html("");
        $(btn_res).appendTo("#btn-res-modal");
        $('#myModal').show();
    });
    $('.close').click(function () {
        $('#myModal').hide();
    });
});


