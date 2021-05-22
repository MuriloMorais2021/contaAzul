<?php   
class Permissions extends Model{

    private $group;
    private $permissions;
    //esse metodo é chamado la no Model users para setar as informações de permissões, e as mesmas serão usadas em metodos da mesma classe, por isso defino acima duas variaveis privadas
    public function setGroup($id, $id_company){
        $this->group = $id;
        $this->permissions = array();
        //consulta para pegar os parametros da permissão daquele usuario
        $sql = $this->db->prepare("SELECT params FROM permission_groups WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);    
        $sql->execute();

        if($sql->rowCount()>0){
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            //condicional para verificar se ele teve alguma permissão, pois se não tiver ele recebera um valor para não dar erro na proxima consulta
            if(empty($row['params'])){
                $row['params'] = '0';
            }

            $params = $row['params'];
            // query para comparar as permissões que foram recebidas da consulta acima, ele vai comparar se o usuario tem a permissão atraves do in
            $sql1 = $this->db->prepare("SELECT name FROM permission_params WHERE id IN ($params) AND id_company = :id_company");
            $sql1->bindValue(':id_company', $id_company);
            $sql1->execute();

            if($sql1->rowCount() >0){
                //faço esse foreach pois os valores recebidos são multiplos pois armazeno no banco os grupos de permissões separados por "," , 
                // ai ele vai pecorrer e atribuir o nome da permissão em um array chamado permission;
                foreach($sql1->fetchAll(PDO::FETCH_ASSOC) as $item){
                    $this->permissions[] = $item['name'];
                }
            }
        }
    }
    //metodo que ira comparar se o usuario tem essa permissão, retornando o valor para o metodo do model users, pois é ele quem faz a chamada para este e no controller é chamado o se users
    public function hasPermission($name){
        if(in_array($name, $this->permissions)){
            return true;
        }else{
            return false;
        }
    }   
}