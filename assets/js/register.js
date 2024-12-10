$(document).ready(function(){
    //on click sign up,hide login and show registration form
    $("#signup").click(function () {
        $("#first").slideUp("slow",function () {
            $("#second").slideDown("slow");
        });
    });
    
    //on click signup,hide registration and show login form

    $("#sigin").click(function () {
        $("#second").slideUp("slow",function () {
            $("#first").slideDown("slow");
        });
    });
});