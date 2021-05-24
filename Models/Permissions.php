<?php
class Permissions extends Model
{

    private $group;
    private $permissions;
    //esse metodo é chamado la no Model users para setar as informações de permissões, e as mesmas serão usadas em metodos da mesma classe, por isso defino acima duas variaveis privadas
    public function setGroup($id, $id_company)
    {
        $this->group = $id;
        $this->permissions = array();
        //consulta para pegar os parametros da permissão daquele usuario
        $sql = $this->db->prepare("SELECT params FROM permission_groups WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            //condicional para verificar se ele teve alguma permissão, pois se não tiver ele recebera um valor para não dar erro na proxima consulta
            if (empty($row['params'])) {
                $row['params'] = '0';
            }

            $params = $row['params'];
            // query para comparar as permissões que foram recebidas da consulta acima, ele vai comparar se o usuario tem a permissão atraves do in
            $sql1 = $this->db->prepare("SELECT name FROM permission_params WHERE id IN ($params) AND id_company = :id_company");
            $sql1->bindValue(':id_company', $id_company);
            $sql1->execute();

            if ($sql1->rowCount() > 0) {
                //faço esse foreach pois os valores recebidos são multiplos pois armazeno no banco os grupos de permissões separados por "," , 
                // ai ele vai pecorrer e atribuir o nome da permissão em um array chamado permission;
                foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $item) {
                    $this->permissions[] = $item['name'];
                }
            }
        }
    }
    //metodo que ira comparar se o usuario tem essa permissão, retornando o valor para o metodo do model users, pois é ele quem faz a chamada para este e no controller é chamado o se users
    public function hasPermission($name)
    {
        if (in_array($name, $this->permissions)) {
            return true;
        } else {
            return false;
        }
    }

    public function getList($id_company)
    {
        $data = array();
        $sql = $this->db->prepare("SELECT * FROM permission_params WHERE id_company = :id_company");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    public function getGroupList($id_company)
    {
        $data = array();
        $sql = $this->db->prepare("SELECT * FROM permission_groups WHERE id_company = :id_company");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }
    public function getGroup($id, $id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT * FROM permission_groups WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $data['params'] = explode(',', $data['params']);
        }

        return $data;
    }
    public function addGroup($name, $permissions_list, $id_company)
    {
        $params = implode(',', $permissions_list);
        $sql = $this->db->prepare("INSERT INTO permission_groups SET name = :name, params = :params, id_company = :id_company");
        $sql->bindValue(':name', $name);
        $sql->bindValue(':params', $params);
        $sql->bindValue(':id_company', $id_company);

        if ($sql->execute()) {
            return  true;
        } else {
            return false;
        }
    }
    public function editGroup($name, $permissions_list, $id, $id_company){
        $params = implode(',', $permissions_list);
        $sql = $this->db->prepare("UPDATE permission_groups SET name = :name, params = :params WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':name', $name);
        $sql->bindValue(':params', $params);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':id', $id);

        if ($sql->execute()) {
            return  true;
        } else {
            return false;
        }
    }
    public function add($name, $id_company)
    {
        $sql = $this->db->prepare("INSERT INTO permission_params SET name = :name, id_company = :id_company");
        $sql->bindValue(':name', $name);
        $sql->bindValue(':id_company', $id_company);

        if ($sql->execute()) {
            return  true;
        } else {
            return false;
        }
    }
    public function delete($id)
    {
        $sql = $this->db->prepare("DELETE FROM permission_params WHERE id = :id");
        $sql->bindValue(':id', $id);

        if ($sql->execute()) {
            return  true;
        } else {
            return false;
        }
    }
    public function deleteGoup($id){
        $user = new Users();

        if (!$user->findUsersInGroup($id)) {
            $sql = $this->db->prepare("DELETE FROM permission_groups WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();

            return true;
        }else{
            return false;
        }
    }
}
