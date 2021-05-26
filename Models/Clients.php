<?php
class Clients extends Model{


    public function getList($offset, $id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT * FROM clients WHERE id_company = :id_company LIMIT $offset, 10 ");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    public function getListClient($id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT name, id FROM clients WHERE id_company = :id_company");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    public function getInfo($id, $id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT * FROM clients WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    
    public function getCount( $id_company){
        $data = 0;
        $sql = $this->db->prepare("SELECT count(*) as c FROM clients WHERE id_company = :id_company");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data = $row['c'];

        return $data;
    }
    public function add($name, $email, $phone, $stars, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country, $id_company){
        $sql = $this->db->prepare("INSERT INTO clients SET name = :name, email = :email, phone = :phone, address = :address, address_number = :address_number, address2 = :address2, address_neighb = :address_neighb, address_city = :address_city, address_state = :address_state, address_country = :address_country, address_zipcode = :address_zipcode, stars = :stars, internal_obs = :internal_obs, id_company = :id_company");
        $sql->bindValue(':name', $name);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':address', $address);
        $sql->bindValue(':address_number', $address_number);
        $sql->bindValue(':address2', $address2);
        $sql->bindValue(':address_neighb', $address_neighb);
        $sql->bindValue(':address_city', $address_city);
        $sql->bindValue(':address_state', $address_state);
        $sql->bindValue(':address_country', $address_country);
        $sql->bindValue(':address_zipcode', $address_zipcode);
        $sql->bindValue(':stars', $stars);
        $sql->bindValue(':internal_obs', $internal_obs);
        $sql->bindValue(':phone', $phone);
        $sql->bindValue(':id_company', $id_company);  
        $sql->execute();
    }

    public function edit($name, $email, $phone, $stars, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country, $id, $id_company){
        $sql = $this->db->prepare("UPDATE clients SET name = :name, email = :email, phone = :phone, address = :address, address_number = :address_number, address2 = :address2, address_neighb = :address_neighb, address_city = :address_city, address_state = :address_state, address_country = :address_country, address_zipcode = :address_zipcode, stars = :stars, internal_obs = :internal_obs WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':name', $name);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':address', $address);
        $sql->bindValue(':address_number', $address_number);
        $sql->bindValue(':address2', $address2);
        $sql->bindValue(':address_neighb', $address_neighb);
        $sql->bindValue(':address_city', $address_city);
        $sql->bindValue(':address_state', $address_state);
        $sql->bindValue(':address_country', $address_country);
        $sql->bindValue(':address_zipcode', $address_zipcode);
        $sql->bindValue(':stars', $stars);
        $sql->bindValue(':internal_obs', $internal_obs);
        $sql->bindValue(':phone', $phone);
        $sql->bindValue(':id', $id);  
        $sql->bindValue(':id_company', $id_company);  
        $sql->execute();
    }

    public function searchClientByName($name, $id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT name, id FROM clients WHERE name LIKE :name AND id_company = :id_company LIMIT 10");
        $sql->bindValue(':name', '%'.$name.'%');  
        $sql->bindValue(':id_company', $id_company);  
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }
}