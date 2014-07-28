$(function(){
    $('.Non, .oui, .partiel, .impertinant').each(function(){
            $(this).mouseover(function(){
                $(this).removeClass('unselected');
            });
            $(this).mouseleave(function(){
                if(!$(this).hasClass('selected'))
                    $(this).addClass('unselected');
            });
            $(this).on('click', function(){
                $(this).parents().children('.selected').removeClass('selected').addClass('unselected');
                $(this).addClass('selected').removeClass('unselected');
                countPart($(this));
                count();
            });
    });
    $('#send_data').click(function(){
        var json = {client: $('#client').text(),commentaire: $('#commentaire').val()};
        var to_send = {} ;
        var url = "../save/audit";
        if($('#content').attr('audit') != undefined){
            url= '/'+$('#content').attr('audit');

        }else{
            url = '/0';
        }
        alert(url);
        to_send.general = json;

        if(ergo){
            to_send.ergo = generateErgoJson();
        }
        if(access){
            to_send.access = generateAccessJson();
        }
        if(compa){
            to_send.compa = generateCompaJson();
        }
        if(fct){
            to_send.fct = generateFctJson();
        }
        to_send = JSON.stringify(to_send);
        alert(to_send);
        $.ajax({
            type: "POST",
            contentType: "application/json; charset=utf-8",
            url:  "../save/audit"+url,
            data: to_send,
            beforeSend:function(){
                $("#overlay_add_audit").removeClass('hidden');
                $("#ajax_loader").removeClass('hidden');
                $('#ajax_success').addClass('hidden');
                $('#ajax_error').addClass('hidden');
            },
            success: function(){
                $('#ajax_success').text("Tout c'est bien passé.").removeClass('hidden');
                $("#ajax_loader").addClass('hidden');
                window.setTimeout(function(){
                    $("#overlay_add_audit").addClass('hidden');
                }, 2000);
            },
            error: function(xhr, status, message){
                $('#ajax_error').html("Une erreur a été rencontrée :<br />Statut : "+ status +"<br />Message : "+ message).removeClass('hidden');
                $("#ajax_loader").addClass('hidden');
            }
        });
    });
    function countPart(target){
        var result = 0,
            total_part = 0,
            categorie = target.parents('.categorie');
        console.log(categorie.children());
        categorie.children('ul').children('li').children('.selected').each(function(){
            if($(this).hasClass('oui')){
                result++;
            }else if($(this).hasClass('partiel')){
                result += 0.5;
            }
        });
        categorie.children('.note').text(result);
        categorie.parents('.part').children('.categorie').children('.note').each(function(){
            total_part += parseFloat($(this).text());
        });
        categorie.parents('.part').children('p').children('.note_part').text(total_part);
    }
    function count(){
        var result = 0;
        $('.note_part').each(function(){
            result += parseFloat($(this).text());
        });
        $('#results').text(result);
        $('#note_max').text(function(){
            var max = 0;
            $('.note_max').each(function(){
                max = parseInt($(this).text());
            });
            return max;
        });
        if($('#results').text()/$('#note_max').text()>0.6){
            $('#note').addClass('green').removeClass('red').removeClass('orange');
        }else if($('#results').text()/$('#note_max').text()> 0.4){
            $('#note').removeClass('green').removeClass('red').addClass('orange');
        }else{
            $('#note').removeClass('green').addClass('red').removeClass('orange');

        }
    }
    function generateErgoJson(){
        var oui= new Array();
        var partiel = new Array();
        var non = new Array();
        $('#ergonomie .oui.selected').each(function(){
           oui.push($(this).parents('.ergo_item').attr('id'))
       });
        $('#ergonomie .partiel.selected').each(function(){
           partiel.push($(this).parents('.ergo_item').attr('id'))
       });
        $('#ergonomie .Non.selected').each(function(){
           non.push($(this).parents('.ergo_item').attr('id'))
       });
        return {id_non: non, id_oui:oui, id_partiel:partiel};
    }
    function generateAccessJson(){
        var oui= new Array();
        var partiel = new Array();
        var non = new Array();
        $('#accessibilite .oui.selected').each(function(){
           oui.push($(this).parents('.acce_item').attr('id'))
       });
        $('#accessibilite .partiel.selected').each(function(){
           partiel.push($(this).parents('.acce_item').attr('id'))
       });
        $('#accessibilite .Non.selected').each(function(){
           non.push($(this).parents('.acce_item').attr('id'))
       });
        return {id_non: non, id_oui:oui, id_partiel:partiel};
    }
    function generateCompaJson(){
        var oui= new Array();
        var partiel = new Array();
        var non = new Array();
        $('#compatibilite .oui.selected').each(function(){
           oui.push($(this).parents('.comp_item').attr('id'));
            alert("dksf");

       });
        $('#compatibilite .partiel.selected').each(function(){
           partiel.push($(this).parents('.comp_item').attr('id'));
       });
        $('#compatibilite .Non.selected').each(function(){
           non.push($(this).parents('.comp_item').attr('id'));
       });
        return {id_non: non, id_oui:oui, id_partiel:partiel};
    }
    function generateFctJson(){
        var oui= new Array();
        var partiel = new Array();
        var non = new Array();
        $('#fonctionnalites .oui.selected').each(function(){
           oui.push($(this).parents('.fonc_item').attr('id'))
       });
        $('#fonctionnalites .partiel.selected').each(function(){
           partiel.push($(this).parents('.fonc_item').attr('id'))
       });
        $('#fonctionnalites .Non.selected').each(function(){
           non.push($(this).parents('.fonc_item').attr('id'))
       });
        return {id_non: non, id_oui:oui, id_partiel:partiel};
    }
    function gereRequire(){
        $('.require').each(function(){
            if($("#"+$(this).attr('require')+" .impertinant.selected, #"+$(this).attr('require')+" .Non.selected").length != 0){
                $(this).fadeOut(1500).addClass('hidden');
            }
            else
            {
                 console.log($("#"+$(this).attr('require')+" .impertinant.selected").length);
                $(this).fadeIn(1500).removeClass('hidden');
            }

        });

    }
    function gereOnglets(element){
        $('.part').addClass('hidden');
        $(element.attr('href')).removeClass('hidden');
    }
    var ergo = false,
        access = false,
        compa = false,
        fct = false;
    if($('#ergonomie').length != 0){
        ergo = true;

    }
    if($("#accessibilite").length != 0){
        access = true;
    }
    if($("#compatibilite").length != 0){
        compa = true;
    }
    if($("#fonctionnalites").length != 0){
        fct = true;
    }
    $(document).click(function(e){
        gereRequire();
    });
    $('#onglets li').click(function(e){
        $('#onglets li').each(function(){
            $(this).removeClass('current');
        });
        $(this).addClass('current');
        e.preventDefault();
        gereOnglets($(this).children('a'));
    });
    gereRequire();
});

