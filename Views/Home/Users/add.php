<h1>Usuários - Adicionar</h1>

<form method="POST">
    <label for="email">E-mail</label><br>
    <input type="email" name="email" required value="<?= isset($user) ? $user['email'] : '' ?>"><br><br>

    <label for="password">Senha</label><br>
    <input type="password" name="password" required value="<?= isset($user) ? $user['password'] : '' ?>"><br><br>

    <label for="group">Grupo de Permissões</label><br>
    <select name="group" id="group" required>
        <option value="" selected disabled>Selecionar um grupo</option>
        <?php foreach ($group_list as $group) : ?>
            <option value="<?= $group['id'] ?>" <?= isset($user['group']) && $user['group'] == $group['id'] ? 'selected' : ''; ?>><?= $group['name']; ?></option>
        <?php endforeach; ?>
    </select><br><br>
    <input type="submit" value="Adicionar"><br>

</form>
<?php if (isset($error) && !empty($error)) : ?>
    <div class="warning">
        <?= $error; ?>
    </div>
<?php endif; ?>