<h1>Produto - Editar</h1>

<form method="POST">

    <label for="name">Nome</label><br>
    <input type="text" name="name"  required value="<?=$inventory_list['name'];?>"><br><br>
    
    <label for="price">Preço</label><br>
    <input type="text" name="price" data-mask="000.000.000.000.000,00" data-mask-reverse="true" required value="<?=number_format($inventory_list['price'], 2);?>"><br><br>

    <label for="quant">Quant.</label><br>
    <input type="number" name="quant" required value="<?=$inventory_list['quant'];?>"><br><br>
    
    <label for="quant_min">Quantidade Minima</label><br>
    <input type="number" name="quant_min" required value="<?=$inventory_list['min_quant'];?>"><br><br>
    
    <input type="submit" value="Editar"><br>

</form>
<?php if (isset($error) && !empty($error)) : ?>
    <div class="warning">
        <?= $error; ?>
    </div>
<?php endif; ?>