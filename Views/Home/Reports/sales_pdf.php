<style type="text/css">
    th{
        text-align: left;
    }
</style>

<h1>Relatório de Vendas</h1>
<fieldset>
    <?php if(isset($filters['name']) && !empty($filters['name'])):?>
        <strong>Filtrado pelo cliente:</strong> <?=$filters['name'];?><br>
    <?php endif;?>
    <?php if(!empty($filters['date1']) && !empty($filters['date2'])):?>
        <strong>Filtrado no periodo de:</strong> <?= date('d/m/Y', strtotime($filters['date1'])).' a '.date('d/m/Y', strtotime($filters['date2']));?><br>
    <?php endif;?>
    <?php if(!empty($filters['status'])):?>
        <strong>Filtrado pelo status:</strong> <?= $statuses[$filters['status']];?><br>
    <?php endif;?>
</fieldset><br><br>
<table border="0" width="100%">
    <thead>
        <tr>
            <th>Nome do Cliente</th>
            <th>Data</th>
            <th>Status</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sales_list as $sales) : ?>
            <tr>
                <td><?= $sales['name'] ;?></td>
                <td><?= date('d/m/Y', strtotime($sales['date_sale']));?></td>
                <td><?= $statuses[$sales['status']];?></td>
                <td>R$ <?= number_format($sales['total_price'], 2, ',', '.') ;?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>