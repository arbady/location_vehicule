$(document).ready(function() {

    $(".menu-icon").on("click", function() {
        $(".myNav .myUl").toggleClass("showing");
        // $("nav ul").toggleClass("showing");
    });

    // Scrolling Effect
    $(window).on("scroll", function() {
        if($(window).scrollTop()) {
            $('.myNav').addClass('black');
        }
        else {
            $('.myNav').removeClass('black');
        }
    });

    // Hover Effect
    $('.myNav').hover(function(){
        $(this).css("background-color", "black");
    }, function(){
        $(this).css("background-color", "#d2d2d2");
    });

});