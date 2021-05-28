<h1>Editar - Venda</h1>

<strong>Nome do Cliente: </strong>
<?=$sales_info['info']['name'];?><br><br>

<strong>Data da Venda: </strong>
<?= date('d/m/Y', strtotime($sales_info['info']['date_sale']));?><br><br>

<strong>Total da Venda: </strong>
<?='R$ '.number_format($sales_info['info']['total_price'], 2, ',', '.');?><br><br>

<?php if($sales_edit):?>
    <form method="POST">
        <strong>Status da Venda</strong><br>
        <select name="status">
            <?php foreach($statuses as $statusKey => $statusValue):?>
                <option value="<?= $statusKey;?>" <?= ($statusKey == $sales_info['info']['status'])?'selected':'';?> ><?=$statusValue;?></option>
            <?php endforeach;?>
        </select><br><br>
        <input type="submit" class="button" value="Enviar">
    </form>
<?php else:?>
    <strong>Status: </strong>
    <?=$statuses[$sales_info['info']['status']];?><br><br>
<?php endif;?>

<hr>
<table>
    <thead> 
        <tr>
            <th>Nome do Produto</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
            <th>Preço Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($sales_info['products'] as $product):?>
            <tr>
                <td><?=$product['name'];?></td>
                <td><?=$product['quant'];?></td>
                <td>R$ <?= number_format($product['sale_price'],2, ',','.');?></td>
                <td>R$ <?=number_format($product['sale_price'] * $product['quant'],2, ',','.');?></td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>  
