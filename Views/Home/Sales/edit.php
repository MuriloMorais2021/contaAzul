<h1>Editar - Venda</h1>

<strong>Nome do Cliente: </strong>
<?=$sales_info['info']['name'];?><br><br>

<strong>Data da Venda: </strong>
<?= date('d/m/Y', strtotime($sales_info['info']['date_sale']));?><br><br>

<strong>Total da Venda: </strong>
<?='R$ '.number_format($sales_info['info']['total_price'], 2, ',', '.');?><br><br>