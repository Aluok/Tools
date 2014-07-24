$(function () {
    var TPS_ANIM = 1500;
    $('#global').change(function () {
        if($(this).is(':checked')){
            $(".check").val(["global", "ergo", "access", "fct", "compa"]);
        } else {
            $(".check").val([]);
        }
    });
    $('#submit').click(function (e) {
        if($("#nom_client").val() == ""){
            $("#nom_client_error").removeClass('hidden');
            e.preventDefault();
        } else{
            $("#nom_client_error").addClass('hidden');
        }
        if($(".check:checked").length == 0){
            $("#checkbox_error").removeClass('hidden');
             e.preventDefault();
        }else{
            $("#checkbox_error").addClass('hidden');
        }
    });
    $('#creer').click(function (e) {
        $("#overlay_add_audit").removeClass('hidden');
        e.preventDefault();
    });
    $('#login').click(function(e){
        $('#overlay_login').removeClass('hidden');
        e.preventDefault();
    });
    $(document).click(function(e){
        if(!$(event.target).closest(".inner_overlay, .update, .delete, .add,.acces_client, #creer, #send_data, #login").length){
            $('.overlay').fadeOut(TPS_ANIM).addClass('hidden');
        }
    });
    $(window).keyup(function(e){
        if(e.which == 27){
            $(".overlay").addClass('hidden');
        }
    });
    $('#submit_automated').click(function(e){
        $('#overlay_add_audit form').attr('action', $('#overlay_add_audit form').attr('action') +'/automated');
    });
});
