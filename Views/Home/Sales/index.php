<h1>Vendas</h1>

<?php if($edd_permission):?>
    <a href="<?= BASE_URL . 'Sales/add'; ?>" class="button">Adicionar Venda</a>
<?php endif;?>

<input type="text" id="busca" data-type="search_clients">

<?php if (isset($error) && !empty($error)) : ?>
    <div class="warning">
        <?= $error; ?>
    </div>
<?php endif; ?><br>
<table border="0" width="100%">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Data</th>
            <th>Status</th>
            <th>Valor</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sales_list as $sales) : ?>
            <tr>
                <td><?= $sales['name'] ;?></td>
                <td><?= date('d/m/Y', strtotime($sales['date_sale'])) ;?></td>
                <td><?= $statuses[$sales['status']] ;?></td>
                <td>R$ <?= number_format($sales['total_price'],2, ',', '.') ;?></td>
                <td width="250">
                <a href="<?= BASE_URL . 'Sales/edit/' . $sales['id']; ?>" class="button button_small">Editar</a>
                <?php if(!empty($sales['nfe_key'])):?>
                    <a href="<?= BASE_URL . 'Sales/view_nfe/' . $sales['nfe_key']; ?>" class="button button_small" target="_blank">visualizar Nota</a>
                <?php else:?>
                        <a href="<?= BASE_URL . 'Sales/generate_nfe/' . $sales['id']; ?>" class="button button_small">Emitir NF-e</a>
                <?php endif;?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="pagination">
<?php for($i=1; $i <= $page_count; $i++):?>
    <div class="pag_item <?= $i == $page ?'page_active':'';?>"><a href="<?=BASE_URL.'Sales?page='.$i;?>"><?=$i;?></a></div>
<?php endfor;?>
<div class="clear:both"></div>
</div>