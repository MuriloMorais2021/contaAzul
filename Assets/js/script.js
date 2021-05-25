$(function(){    
    $('.tabitem').click(function(){

        $('.tabitem').removeClass('activetab');
        $(this).addClass('activetab');

        var item = $('.activetab').index();
        
        $('.tabbody').addClass('d-none');
        $('.tabbody').eq(item).removeClass('d-none');
    });

    $('#busca').on('focus', function(){
        $(this).animate({
            width: '250px'
        });
    });
    $('#busca').on('blur', function(){
        if(!$(this).val()){
            $(this).animate({
                width: '100px'
            });
        }
        setTimeout(function(){
            $('.searchresults').hide();
        }, 500);
    });

    $('#busca').on('keyup', function(){
        var datatype = $(this).attr('data-type');
        var value = $(this).val();
        if(datatype){
            $.ajax({
                url: BASE_URL+'ajax/'+datatype,
                type: 'GET',
                data:{value:value},
                dataType:'json',
                success:function(json){
                    if($('.searchresults').length == 0){
                        $('#busca').after('<div class="searchresults"></div>');
                    }

                    $('.searchresults').css('left', $('#busca').offset().left+'px');
                    $('.searchresults').css('top', $('#busca').offset().top+$('#busca').height()+3+'px');                    
                    
                    var html = '';
                    for(var item in json){
                        html +='<div class="si"><a href="'+BASE_URL+'Clients/edit/'+json[item].id+'">'+json[item].name+'</a></div>';
                    }
                    $('.searchresults').html(html);
                    $('.searchresults').show();
                }
            });

        }
    });
})