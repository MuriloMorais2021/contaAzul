$(function(){    
    $('.tabitem').click(function(){

        $('.tabitem').removeClass('activetab');
        $(this).addClass('activetab');

        var item = $('.activetab').index();
        
        $('.tabbody').addClass('d-none');
        $('.tabbody').eq(item).removeClass('d-none');
    });
})