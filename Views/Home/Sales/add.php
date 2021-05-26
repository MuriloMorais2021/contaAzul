<h1>Adicionar - Venda</h1>

<form method="POST">
    <label for="clients">Clientes</label>
    <select name="clients_id" id="clients">
        <option value="" selected disabled>Selecione o Cliente</option>
        <?php foreach ($clients_list as $client) : ?>
            <option value="<?=$client['id'];?>"><?=$client['name'];?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="status">Status da Venda</label>
    <select name="status" id="status">
        <option value="0">Aguardando Pgto.</option>
        <option value="1">Pago</option>
        <option value="2">Cancelado</option>
    </select><br><br>

    <label for="total_price">Preço da Venda</label>
    <input type="text" name="total_price" data-mask="000.000.000.000.000,00" data-mask-reverse="true"><br><br>

    <input type="submit" value="Adicionar">
</form>