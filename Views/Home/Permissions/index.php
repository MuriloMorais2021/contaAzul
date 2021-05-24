<h1>Permissões</h1>

<div class="tabarea">
    <div class="tabitem activetab">Grupos de permissões</div>
    <div class="tabitem">Permissões</div>
</div>
<div class="tabcontent">
    <div class="tabbody">
        <a href="<?= BASE_URL . 'Permissions/add_group'; ?>" class="button">Adicionar Grupo de Permissões</a>
        <table border="0" width="100%">
            <thead>
                <tr>
                    <th>Nome do grupo de permissões</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($permissions_groups_list as $permission) : ?>
                    <tr>
                        <td><?= $permission['name'] ?></td>
                        <td>
                            <a href="<?= BASE_URL . 'Permissions/edit_group/' . $permission['id']; ?>" class="button button_small">Editar</a>
                            <a href="<?= BASE_URL . 'Permissions/delete_group/' . $permission['id']; ?>" class="button button_small" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="tabbody d-none">
        <a href="<?= BASE_URL . 'Permissions/add'; ?>" class="button">Adicionar Permissão</a>
        <table border="0" width="100%">
            <thead>
                <tr>
                    <th>Nome da permissão</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($permissions_list as $permission) : ?>
                    <tr>
                        <td><?= $permission['name'] ?></td>
                        <td><a href="<?= BASE_URL . 'Permissions/delete/' . $permission['id']; ?>" class="button button_small" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>