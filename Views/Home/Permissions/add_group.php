<h1>Permissões - Adicionar Grupo de Permissões</h1>

<form method="POST">
    <label for="name">Nome do Grupo de Permissões</label><br>
    <input type="text" name="name"><br><br>

    <label>Permissões</label><br>


    <?php foreach ($permissions_list as $permission) : ?>
        <div class="p_item">
            <input type="checkbox" name="permissions[]" value="<?= $permission['id']; ?>" id="p_<?=$permission['id'];?>">
            <label for="p_<?=$permission['id']?>"><?=$permission['name'];?></label>
        </div>
    <?php endforeach; ?><br><br>
    <input type="submit" value="Adicionar"> <br>
</form>