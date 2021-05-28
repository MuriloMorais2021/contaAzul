<style type="text/css">
    th{
        text-align: left;
    }
    .text-danger{
        color: red;
    }
</style>

<h1>Relatório de Estoque</h1>

Itens com estoque abaixo do minimo.
<br><br>
<table border="0" width="100%">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Quant. Min</th>
            <th>Diferença</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inventory_list as $inventory) : ?>
            <tr>
                <td><?= $inventory['name'] ;?></td>
                <td>R$ <?= number_format($inventory['price'], 2, ',', '.') ;?></td>
                <td><?= $inventory['quant'] ;?></td>
                <td class="<?=  ($inventory['min_quant'] > $inventory['quant'])? 'text-danger':'';?>" ><?= $inventory['min_quant'];?></td>
                <td><?=$inventory['dif'];?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>