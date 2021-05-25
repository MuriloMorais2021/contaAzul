<h1>Estoque</h1>

<?php if($add_permission):?>
    <a href="<?= BASE_URL . 'Inventory/add'; ?>" class="button">Adicionar Cliente</a>
<?php endif;?>

<input type="text" id="busca" data-type="search_inventory">

<?php if (isset($error) && !empty($error)) : ?>
    <div class="warning">
        <?= $error; ?>
    </div>
<?php endif; ?><br>
<table border="0" width="100%">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Quant. Min</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inventory_list as $inventory) : ?>
            <tr>
                <td><?= $inventory['name'] ;?></td>
                <td><?= number_format($inventory['price'], 2) ;?></td>
                <td><?= $inventory['quant'] ;?></td>
                <td class="<?= $inventory['min_quant'] > $inventory['quant']? 'text-red':'';?>" ><?= $inventory['min_quant'];?></td>
                <td width="200">
                <?php if($edit_permission):?>
                    <a href="<?= BASE_URL . 'Inventory/edit/' . $inventory['id']; ?>" class="button button_small">Editar</a>
                    <a href="<?= BASE_URL . 'Inventory/delete/' . $inventory['id']; ?>" class="button button_small" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                <?php else:?>
                    <a href="<?= BASE_URL . 'Inventory/view/' . $inventory['id']; ?>" class="button button_small">visualizar</a>
                <?php endif;?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="pagination">
<?php for($i=1; $i <= $page_count; $i++):?>
    <div class="pag_item <?= $i == $page ?'page_active':'';?>"><a href="<?=BASE_URL.'Clients?page='.$i;?>"><?=$i;?></a></div>
<?php endfor;?>
<div class="clear:both"></div>
</div>