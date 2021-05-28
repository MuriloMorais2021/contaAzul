<?php
class Inventory extends Model{

    public function getList($offset, $id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT * FROM inventory WHERE id_company = :id_company LIMIT $offset, 10");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;

    }
    public function downInventory($id_prod, $qtd, $id_company, $id_user){
        $sql = $this->db->prepare("UPDATE inventory SET quant = quant - $qtd WHERE id = :id_prod AND id_company = :id_company");
        $sql->bindValue(':id_prod', $id_prod);
        $sql->bindValue('id_company', $id_company);
        $sql->execute();

        $this->infoInventory($id_prod, $id_user, $id_company, 'dwn');
    }
    public function getInfoInventory($id, $id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT * FROM inventory WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    public function getPrice($id_product, $id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT price FROM inventory WHERE id = :id_product AND id_company = :id_company ");
        $sql->bindValue(':id_product', $id_product);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $data = $row['price'];
        }
        return $data;
    }
    public function infoInventory($id_product, $id_user, $id_company, $action){
        $sql = $this->db->prepare("INSERT INTO inventory_history SET id_product = :id_product, id_user = :id_user, id_company = :id_company, action = :action, date_action = NOW()");
        $sql->bindValue(':id_product', $id_product);                
        $sql->bindValue(':id_user', $id_user);            
        $sql->bindValue(':id_company', $id_company);            
        $sql->bindValue(':action', $action);        
        $sql->execute();    
    }

    public function add($name, $price, $quant, $min_quant, $id_company, $id_user){
        $sql = $this->db->prepare("INSERT INTO inventory SET name = :name, price = :price, quant = :quant, min_quant = :min_quant, id_company = :id_company");
        $sql->bindValue(':name', $name);            
        $sql->bindValue(':price', $price);        
        $sql->bindValue(':quant', $quant);        
        $sql->bindValue(':min_quant', $min_quant);        
        $sql->bindValue(':id_company', $id_company); 
        $sql->execute();       

        $id_product = $this->db->lastInsertId();
        
        $this->infoInventory($id_product, $id_user, $id_company, 'add');
    }
    public function edit($id, $name, $price, $quant, $min_quant, $id_company, $id_user){
        $sql = $this->db->prepare("UPDATE inventory SET name = :name, price = :price, quant = :quant, min_quant = :min_quant WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':name', $name);            
        $sql->bindValue(':price', $price);        
        $sql->bindValue(':quant', $quant);        
        $sql->bindValue(':min_quant', $min_quant);        
        $sql->bindValue(':id', $id); 
        $sql->bindValue(':id_company', $id_company); 
        $sql->execute();       

        $this->infoInventory($id, $id_user, $id_company, 'edt');
          
    }
    public function delete($id, $id_company, $id_user){
        $sql = $this->db->prepare("DELETE FROM inventory WHERE id =:id AND id_company = :id_company");
        $sql->bindValue(':id', $id); 
        $sql->bindValue(':id_company', $id_company); 
        $sql->execute();    
        $this->infoInventory($id, $id_user, $id_company, 'del');
    }

    public function searchProducts($value, $id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT name, id, price FROM inventory WHERE name LIKE :name AND id_company = :id_company LIMIT 10");
        $sql->bindValue(':name', '%'.$value.'%');  
        $sql->bindValue(':id_company', $id_company);  
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }
    public function getInventoryFiltered($id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT *, (min_quant - quant) as dif FROM inventory WHERE quant <= min_quant AND id_company = :id_company ORDER BY dif DESC");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
}