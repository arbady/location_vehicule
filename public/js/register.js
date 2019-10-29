// import {red} from "ansi-colors";
$(document).ready(function () {

    $('.button').click(function(){
        var $btn = $(this),
            $step = $btn.parents('.modal-body'),
            stepIndex = $step.index(),
            $pag = $('.modal-header span').eq(stepIndex);

        if (stepIndex === 0){
            step1($step, $pag);
        }
        else
            if (stepIndex === 1){
                step2($step, $pag);
            }
            else { step3($step, $pag); }

        // if(stepIndex === 0 || stepIndex === 1) { step1($step, $pag); }
        // else { step3($step, $pag); }

    });

    function step1($step, $pag){
        let recupNom = $('#inputNom').val();
        let recupPrenom = $('#inputPrenom').val();
        let recupMail = $('#inputEmail').val();
        let recupPwd = $('#inputPassword').val();

        if (recupNom != "" && recupPrenom != "" && recupMail != "" && recupPwd != ""){
            console.log('step1');
            // animate the step out
            $step.addClass('animate-out');

            // animate the step in
            setTimeout(function(){
                $step.removeClass('animate-out is-showing')
                    .next().addClass('animate-in');
                $pag.removeClass('is-active')
                    .next().addClass('is-active');
            }, 600);

            // after the animation, adjust the classes
            setTimeout(function(){
                $step.next().removeClass('animate-in')
                    .addClass('is-showing');
            }, 1200);
        }
        else {
            // alert('Remplisser les champs vides');
            let message = "";
            if (recupNom == ""){
                $('#inputNom').css('border-color', 'red');
                message += "Veuillez remplir le nom";
            }if (recupPrenom == ""){
                $('#inputPrenom').css('border-color', 'red');
                message += "Veuillez remplir le prénom";
            }if (recupMail == ""){
                $('#inputEmail').css('border-color', 'red');
                message += "Veuillez entrer le mail";
            }if (recupPwd == ""){
                $('#inputPassword').css('border-color', 'red');
                message += "Veuillez remplir le mot de passe";
            }
            alert(message);
        }
    }

    function step2($step, $pag){
        let recupSexe = $('#inputSexe').val();
        let recupAdresse= $('#inputAdresse').val();
        let recupdate_naissance = $('#datepicker').val();
        let recupTel = $('#inputTel').val();

        if (recupSexe !== "" && recupAdresse !== "" && recupdate_naissance !== "" && recupTel !== ""){
            console.log('step1');
            // animate the step out
            $step.addClass('animate-out');

            // animate the step in
            setTimeout(function(){
                $step.removeClass('animate-out is-showing')
                    .next().addClass('animate-in');
                $pag.removeClass('is-active')
                    .next().addClass('is-active');
            }, 600);

            // after the animation, adjust the classes
            setTimeout(function(){
                $step.next().removeClass('animate-in')
                    .addClass('is-showing');
            }, 1200);
        }
        else {
            // alert('Remplisser les champs vides');
            let message = "";
            if (recupSexe === ""){
                $('#inputSexe').css('border-color', 'red');
                message += "Veuillez remplir le sexe";
            }if (recupAdresse === ""){
                $('#inputAdresse').css('border-color', 'red');
                message += "Veuillez remplir l'adresse";
            }if (recupdate_naissance === ""){
                $('#datepicker').css('border-color', 'red');
                message += "Veuillez entrer la date de naissance";
            }if (recupTel === ""){
                $('#inputTel').css('border-color', 'red');
                message += "Veuillez remplir le téléphone";
            }
            alert(message);
        }
    }

    function step3($step, $pag){
        console.log('3');

        // let recupdate_inscription = $('#datepicker1').val();
        // let recupdate_permis = $('#select').val();

        // if (recupdate_permis !== ""){
            // animate the step out
        $step.parents('.modal-wrap').addClass('animate-up');

        setTimeout(function(){
            $('.rerun-button').css('display', 'inline-block');
        }, 300);
        // }
        // else {
        //     alert('Remplisser les champs vides');
        // }
    }

    //Pour le focus dans les inputs
    $('#input').focus();

    //Pour le format date
    $(".datepicker").datepicker({
        uiLibrary: 'bootstrap4',
        locale: 'fr_fr',
        format: 'dd mmm yyyy'
    });

    $( function() {
        $( "#datepicker" ).datepicker();
    });
    $( function() {
        $( "#datepicker1" ).datepicker();
    });
});