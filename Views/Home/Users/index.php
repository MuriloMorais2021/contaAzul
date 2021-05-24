<h1>Usuários</h1>
<a href="<?= BASE_URL . 'Users/add'; ?>" class="button">Adicionar Usuário</a>
<?php if (isset($error) && !empty($error)) : ?>
    <div class="warning">
        <?= $error; ?>
    </div>
<?php endif; ?><br>
<table border="0" width="100%">
    <thead>
        <tr>
            <th>E-mail</th>
            <th>Grupo de Permissões</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users_list as $user) : ?>
            <tr>
                <td><?= $user['email'] ;?></td>
                <td width="300"><?= $user['name'] ;?></td>
                <td width="200">
                    <a href="<?= BASE_URL . 'Users/edit/' . $user['id']; ?>" class="button button_small">Editar</a>
                    <a href="<?= BASE_URL . 'Users/delete/' . $user['id']; ?>" class="button button_small" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>