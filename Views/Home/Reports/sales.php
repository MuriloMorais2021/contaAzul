<h1>Relatório - Vendas</h1>

<form method="GET" onsubmit="return openPopUp(this)">
    <div class="report-grid-4">
        <label for="name">Nome do Cliente</label>
        <input type="text" name="name" id="name">
    </div>
    <div class="report-grid-4">
        Período: <br>
        <input type="date" name="date1" id="date1"><br>
        Até <br>
        <input type="date" name="date2" id="date2">
    </div>
    <div class="report-grid-4">
        Status da Venda <br>
        <select name="status">
            <option value="">Todos os status</option>
            <?php foreach($statuses as $statusKey => $statusValue):?>
                <option value="<?=$statusKey;?>"><?=$statusValue;?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="report-grid-4">
        Ordenação: <br>
        <select name="order" >
                <option value="date_desc">Mais Recente</option>
                <option value="date_asc">Mais Antigos</option>
                <option value="status">Status da Venda</option>
        </select>
    </div>
    <div class="text-center">
        <input type="submit" value="Gerar Relatório">
    </div>
</form>