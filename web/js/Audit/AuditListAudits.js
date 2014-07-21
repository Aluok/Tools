$(function(){
    const TPS_ANIM = 1500;
    function gereAffichageUpdate(test){
        var to_check = new Array();
        if(test % 2 != 1){
            hideFormPart('#ergo');
            to_check.push('ergo');
        }
        else{
            showFormPart('#ergo');
        }
        if(test % 4 < 2){
            hideFormPart('#access');
            to_check.push('access');
        }
        else{
           showFormPart('#access');
        }
        if(test % 8 < 4){
            hideFormPart('#compa');
            to_check.push('compa');
        }
        else{
            showFormPart('#compa');
        }
        if(test % 16 < 8){
            hideFormPart('#fct');
            to_check.push('fct');
        }
        else{
            showFormPart('#fct');
        }
        $('.update').val(to_check);
    }
    function gereAffichageAdd(test){
         var to_check = new Array();
        if(test % 2 == 1){
            hideFormPart('#ergo');
            to_check.push('ergo');
        }
        else{
            showFormPart('#ergo');
        }
        if(test % 4 >= 2){
            hideFormPart('#access');
            to_check.push('access');
        }
        else{
           showFormPart('#access');
        }
        if(test % 8 >=4){
            hideFormPart('#compa');
            to_check.push('compa');
        }
        else{
            showFormPart('#compa');
        }
        if(test % 16 >= 8){
            hideFormPart('#fct');
            to_check.push('fct');
        }
        else{
            showFormPart('#fct');
        }
        $('.update').val(to_check);
    }
    function hideFormPart(id){
        $(id).hide();
        $(id+'_label').hide();
    }
    function showFormPart(id){
        $(id).show();
        $(id+'_label').show();
    }

    //Cache ce qui doit etre vu même sans js
    $('.details').each(function(){
        $(this).hide().addClass('hidden');
    });
    //Event
    $('.menu').click(function(){
        var details = $(this).parent('li').children('.details');

        if(details.hasClass('hidden')) {
            details.fadeIn(700).removeClass('hidden');
        } else {
            details.fadeOut(700).addClass('hidden');
        }
    });
    $('.delete').click(function(event){
        event.preventDefault();
        $('#overlay_delete').fadeIn(TPS_ANIM).removeClass('hidden');
        $('#overlay_delete #client').text(
                $(event.target).parents('li').children('.client').text()
            );
        var id =  $(this).parents('li').attr('id');

        $('.inner_overlay').removeClass('hidden');
        $(".ajax_loader").addClass('hidden');
        $('#id_to_delete').val(id);
        $('#confirmed_delete').click(function(){
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url:  "./delete/"+id,
                beforeSend:function(){
                    $("#overlay_delete").removeClass('hidden');
                    $('.inner_overlay').addClass('hidden');
                    $(".ajax_loader").removeClass('hidden');
                    $('#ajax_loader').removeClass('hidden');
                    $('.ajax_message').addClass('hidden');
                },
                success: function(){
                    $('.ajax_message').text("Tout c'est bien passé.").removeClass('hidden');
                    $("#ajax_loader").addClass('hidden');
                    window.setTimeout(function(){
                        $("#overlay_delete").addClass('hidden');
                    }, 2000);
                    $(event.target).parents('li').remove();
                },
                error: function(xhr, status, message){
                    $('.ajax_message').html("Une erreur a été rencontrée :<br />Statut : "+ status +"<br />Message : "+ message).removeClass('hidden');
                    $("#ajax_loader").addClass('hidden');
                }
            });

        });
    });
    $('.update').click(function(event){
        event.preventDefault();
        $('#overlay_update').fadeIn(TPS_ANIM).removeClass('hidden');
        var test = $(this).children('a').attr('class');
        $('#id_to_update').val($(this).parents('li').attr('id'));
        switch(test){
            case '1':
                $('#fct').hide().removeAttr('checked');
                $('#fct_label').hide();
                $('#compa').hide().removeAttr('checked');
                $('#compa_label').hide();
                $('#access').hide().removeAttr('checked');
                $('#access_label').hide();
                $('#ergo').show().attr('checked');
                $('#ergo_label').show();
                break;
            case '2':
                $('#fct').hide().removeAttr('checked');
                $('#fct_label').hide();
                $('#compa').hide().removeAttr('checked');
                $('#compa_label').hide();
                $('#ergo').hide().removeAttr('checked');
                $('#ergo_label').hide();
                $('#access').show().attr('checked');
                $('#access_label').show();
                break;
            case '3':
                $('#fct').hide().removeAttr('checked');
                $('#fct_label').hide();
                $('#compa').hide().removeAttr('checked');
                $('#compa_label').hide();
                $('#ergo').show().attr('checked');
                $('#ergo_label').show();
                $('#access').show().attr('checked');
                $('#access_label').show();
                break;
            case '4':
                $('#fct').hide().removeAttr('checked');
                $('#fct_label').hide();
                $('#access').hide().removeAttr('checked');
                $('#access_label').hide();
                $('#ergo').hide().removeAttr('checked');
                $('#ergo_label').hide();
                $('#compa').show().attr('checked');
                $('#compa_label').show();
                break;
            case '5':
                $('#fct').hide().removeAttr('checked');
                $('#fct_label').hide();
                $('#access').hide().removeAttr('checked');
                $('#access_label').hide();
                $('#ergo').show().attr('checked');
                $('#compa').show().attr('checked');
                $('#compa_label').show();
                $('#ergo_label').show();
                break;
            case '6':
                $('#fct').hide().removeAttr('checked');
                $('#fct_label').hide();
                $('#ergo').hide().removeAttr('checked');
                $('#ergo_label').hide();
                $('#access').show().attr('checked');
                $('#access_label').show();
                $('#compa').show().attr('checked');
                $('#compa_label').show();
                break;
            case '7':
                $('#fct').hide().removeAttr('checked');
                $('#fct_label').hide();
                $('#ergo').show().attr('checked');
                $('#ergo_label').show();
                $('#access').show().attr('checked');
                $('#access_label').show();
                $('#compa').show().attr('checked');
                $('#compa_label').show();
                break;
            case '8':
                $('#access').hide().removeAttr('checked');
                $('#access_label').hide();
                $('#compa').hide().removeAttr('checked');
                $('#compa_label').hide();
                $('#ergo').hide().removeAttr('checked');
                $('#ergo_label').hide();
                $('#fct').show().attr('checked');
                $('#fct_label').show();
                break;
            case '9':
                $('#access').hide().removeAttr('checked');
                $('#access_label').hide();
                $('#compa').hide().removeAttr('checked');
                $('#compa_label').hide();
                $('#ergo').show().attr('checked');
                $('#ergo_label').show();
                $('#fct').show().attr('checked');
                $('#fct_label').show();
                break;
            case '10':
                $('#compa').hide().removeAttr('checked');
                $('#compa_label').hide();
                $('#ergo').hide().removeAttr('checked');
                $('#access').show().attr('checked');
                $('#access_label').show();
                $('#ergo_label').hide();
                $('#fct').show().attr('checked');
                $('#fct_label').show();
                break;
            case '11':
                $('#compa').hide().removeAttr('checked');
                $('#compa_label').hide();
                $('#ergo').show().attr('checked');
                $('#ergo_label').show();
                $('#access').show().attr('checked');
                $('#access_label').show();
                $('#fct').show().attr('checked');
                $('#fct_label').show();
                break;
            case '12':
                $('#access').hide().removeAttr('checked');
                $('#access_label').hide();
                $('#ergo').hide().removeAttr('checked');
                $('#ergo_label').hide();
                $('#compa').show();
                $('#compa_label').show();
                $('#fct').show();
                $('#fct_label').show();
                break;
            case '13':
                $('#access').hide().removeAttr('checked');
                $('#ergo').show().attr('checked');
                $('#ergo_label').show();
                $('#access_label').hide();
                $('#compa').show().attr('checked');
                $('#compa_label').show();
                $('#fct').show().attr('checked');
                $('#fct_label').show();
                break;
            case '14':
                $('#ergo').hide().removeAttr('checked');
                $('#ergo_label').hide();
                $('#access').show().attr('checked');
                $('#access_label').show();
                $('#compa').show().attr('checked');
                $('#compa_label').show();
                $('#fct').show().attr('checked');
                $('#fct_label').show();
                break;
            case '15':
                $('#ergo').show().attr('checked');
                $('#ergo_label').show();
                $('#access').show().attr('checked');
                $('#access_label').show();
                $('#compa').show().attr('checked');
                $('#compa_label').show();
                $('#fct').show().attr('checked');
                $('#fct_label').show();
                break;

        }
    });
    $('.acces_client').click(function(event){
        $('#overlay_acces').fadeIn(TPS_ANIM).removeClass('hidden');
        $('form.inner_overlay').attr('action', $(event.target).parents('li').attr('action_url'));
    });
    $('.add').click(function(){
        $('#overlay_update').fadeIn(TPS_ANIM).removeClass('hidden');
        var tests = $(this).children('a').attr('class');
        $('#id_to_update').val($(this).parents('li').attr('id'));
        gereAffichageAdd(tests);
    });
    $(document).click(function(e){
        if(!$(event.target).closest(".inner_overlay, .update, .delete, .add,.acces_client, #creer").length){
            $('.overlay').fadeOut(TPS_ANIM).addClass('hidden');
        }
    });

});
