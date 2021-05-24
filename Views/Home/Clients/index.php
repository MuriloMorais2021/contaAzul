<h1>Clientes</h1>

<?php if($edit_permission):?>
    <a href="<?= BASE_URL . 'Clients/add'; ?>" class="button">Adicionar Cliente</a>
<?php endif;?>

<?php if (isset($error) && !empty($error)) : ?>
    <div class="warning">
        <?= $error; ?>
    </div>
<?php endif; ?><br>
<table border="0" width="100%">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Cidade</th>
            <th>Estrelas</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients_list as $clients) : ?>
            <tr>
                <td><?= $clients['name'] ;?></td>
                <td><?= $clients['phone'] ;?></td>
                <td><?= $clients['address_city'] ;?></td>
                <td><?= $clients['stars'] ;?></td>
                <td width="200">
                <?php if($edit_permission):?>
                    <a href="<?= BASE_URL . 'Clients/edit/' . $clients['id']; ?>" class="button button_small">Editar</a>
                    <a href="<?= BASE_URL . 'Clients/delete/' . $clients['id']; ?>" class="button button_small" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                <?php else:?>
                    <a href="<?= BASE_URL . 'Clients/view/' . $clients['id']; ?>" class="button button_small">visualizar</a>
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