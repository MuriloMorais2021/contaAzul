<h1>Produto - Adicionar</h1>

<form method="POST">

    <label for="name">Nome</label><br>
    <input type="text" name="name" required required><br><br>
    
    <label for="price">Preço</label><br>
    <input type="text" name="price" data-mask="000,00" required><br><br>

    <label for="quant">Quant.</label><br>
    <input type="number" name="quant" required><br><br>
    
    <label for="quant_min">Quantidade Minima</label><br>
    <input type="number" name="quant_min" required><br><br>
    
    <input type="submit" value="Adicionar"><br>

</form>
<?php if (isset($error) && !empty($error)) : ?>
    <div class="warning">
        <?= $error; ?>
    </div>
<?php endif; ?>