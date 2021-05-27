<h1>Adicionar - Venda</h1>

<form method="POST">
    <label for="clients">Clientes</label>
    <select name="clients_id" id="clients">
        <option value="" selected disabled>Selecione o Cliente</option>
        <?php foreach ($clients_list as $client) : ?>
            <option value="<?= $client['id']; ?>"><?= $client['name']; ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="status">Status da Venda</label>
    <select name="status" id="status">
        <option value="1">Aguardando Pgto.</option>
        <option value="2">Pago</option>
        <option value="3">Cancelado</option>
    </select><br><br>

    <label for="total_price">Preço da Venda</label>
    <input type="text" name="total_price" disabled data-mask="000.000.000.000.000,00" data-mask-reverse="true" placeholder="00,00"><br><br>

    <hr>
    <h4>Produtos</h4>
    <fieldset>
        <legend>Adicionar</legend>
        <input type="text" id="search" data-type="search_prod">
    </fieldset>
    <table width="100%" id="product_table">
        <thead>
            <tr>
                <th>Nome do produto</th>
                <th>Quantidade</th>
                <th>Valor Unit.</th>
                <th>Sub-Total.</th>
                <th>Ação</th>
            </tr>
        </thead>
    </table>
    <hr>
    <input type="submit" value="Adicionar">
</form>