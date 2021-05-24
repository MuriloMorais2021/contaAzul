$('#address_zipcode').blur(function(){
    var address_zipcode = $(this).val();

    $.ajax({
        url:'http://api.postmon.com.br/v1/cep/'+address_zipcode,
        type: 'GET',
        dataType: 'jsonp',
        success:function(data){
            if(data){
                $('#address').val(data.logradouro);
                $('#address_neighb').val(data.bairro);
                $('#address_city').val(data.cidade);
                $('#address_state').val(data.estado);
                $('#address_country').val("Brasil");

                $('#address_number').focus();
            }else{
            }   
        }
    })
})  