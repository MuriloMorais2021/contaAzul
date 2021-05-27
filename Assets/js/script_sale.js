function addProd(obj) {
    var id = $(obj).attr('data-id');
    var name = $(obj).attr('data-name');
    var price = $(obj).attr('data-price');
    
    
    $('.searchresults').hide();
    if (!$('#'+id+'').val()) {
        var tr =
            '<tr>' +
            '<td>' + name + '</td>' +
            '<td class="text-center">' +
            '<input type="number" class="p_quant" name="quant[' + id + ']" id="' + id + '" value="1" onchange="updateSubtotal(this)" data-price="' + price + '"/>' +
            '</td>' +
            '<td>R$ ' + price + '</td>' +
            '<td class="sub_total">R$ ' + price + '</td>' +
            '<td><a href="javascript:;" onclick="deleteProd(this)" class="button button_small">Excluir</a></td>' +
            '<tr>';

        $('#product_table').append(tr);
    }

    updateTotal();
}
function deleteProd(obj) {
    $(obj).closest('tr').remove();
}
function updateSubtotal(obj) {
    var quant = $(obj).val();
    if (quant > 0) {
        var price = $(obj).attr('data-price');
        var subtotal = price * quant;

        $(obj).closest('tr').find('.sub_total').html('R$ ' + subtotal);
    } else {
        $(obj).val(1);
    }
    updateTotal();
}
function updateTotal(){
    var total = 0;

    for(var i =0; i< $('.p_quant').length; i++){
        var quant = $('.p_quant').eq(i);

        var price = quant.attr('data-price');
        var subtotal = price*parseInt(quant.val());
        total += subtotal;  
    }

    $('input[name=total_price]').val(total);
}

$('#search').on('keyup', function () {
    var datatype = $(this).attr('data-type');
    var value = $(this).val();
    if (datatype) {
        $.ajax({
            url: BASE_URL + 'ajax/' + datatype,
            type: 'GET',
            data: { value: value },
            dataType: 'json',
            success: function (json) {
                if ($('.searchresults').length == 0) {
                    $('#search').after('<div class="searchresults"></div>');
                }

                $('.searchresults').css('left', $('#search').offset().left + 'px');
                $('.searchresults').css('top', $('#search').offset().top + $('#search').height() + 3 + 'px');

                var html = '';
                for (var item in json) {
                    html += '<div class="si"><a href="javascript:;" onclick="addProd(this)" data-id="' + json[item].id + '" data-price="' + json[item].price + '" data-name="' + json[item].name + '">' + json[item].name + ' - R$' + json[item].price + ' </a></div>';
                }
                $('.searchresults').html(html);
                $('.searchresults').show();
                $('#search').val('');
            }
        });

    }
});