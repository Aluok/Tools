$(function () {
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
    })
    $(document).click(function(e){
       if(!($(e.target).closest(".inner_overlay").length || $(e.target).closest("#creer").length)) {
            $("#overlay_add_audit").hide();
       }
    });
    $(window).keyup(function(e){
        if(e.which == 27){
            $("#overlay_add_audit").addClass('hidden');
        }
    });
});
