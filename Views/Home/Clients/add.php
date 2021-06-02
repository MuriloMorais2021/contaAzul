<h1>Clientes - Adicionar</h1>

<form method="POST">

    <label for="name">Nome</label><br>
    <input type="text" name="name" required ><br><br>
    
    <label for="email">E-mail</label><br>
    <input type="email" name="email" ><br><br>
    
    <label for="phone">Telefone</label><br>
    <input type="text" name="phone" ><br><br>
    
    <label for="stars">Estrelas</label><br>
    <select name="stars" id="stars" required>
        <option value="1">1 Estrela</option>
        <option value="2">2 Estrelas</option>
        <option value="3" selected>3 Estrelas</option>
        <option value="4">4 Estrelas</option>
        <option value="5">5 Estrelas</option>
    </select>

    <label for="internal_obs">Informações Internas</label><br>
    <textarea name="internal_obs" id="internal_obs"></textarea><br><br>

    <label for="address_zipcode">CEP</label><br>
    <input type="text" name="address_zipcode"id="address_zipcode" ><br><br>

    <label for="address">Endereço</label><br>
    <input type="text" name="address" id="address" ><br><br>
    
    <label for="address_number">Número</label><br>
    <input type="text" name="address_number" id="address_number" ><br><br>
    
    <label for="address2">Complemento</label><br>
    <input type="text" name="address2" id="address2" ><br><br>

    <label for="address_neighb">Bairro</label><br>
    <input type="text" name="address_neighb" id="address_neighb" ><br><br>

    <label for="address_state">Estado</label><br>
    <select name="address_state" id="address_state" onchange="changeState(this)">
        <?php foreach($states_list as $states):?>
            <option value="<?= $states['UF'];?>"><?= $states['UF'];?></option>
        <?php endforeach;?>
    </select> <br><br>
    
    <label for="address_city">Cidade</label><br>
    <select name="address_city" id="address_city">
        
    </select> <br><br>

    <label for="address_country">País</label><br>
    <input type="text" name="address_country" id="address_country" ><br><br>
    
    <input type="submit" value="Adicionar"><br>

</form>
<?php if (isset($error) && !empty($error)) : ?>
    <div class="warning">
        <?= $error; ?>
    </div>
<?php endif; ?>