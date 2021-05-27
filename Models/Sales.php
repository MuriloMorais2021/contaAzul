<?php
class Sales extends Model{

    public function getList($offset, $id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT sales.*, clients.name FROM sales INNER JOIN clients ON clients.id = sales.id_client WHERE sales.id_company = :id_company ORDER BY sales.date_sale DESC LIMIT $offset, 10 ");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    public function getInfo($id, $id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT sales.*, clients.name FROM sales INNER JOIN clients ON clients.id = sales.id_client WHERE sales.id = :id AND sales.id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount()>0){
            $data['info'] = $sql->fetch(PDO::FETCH_ASSOC);
        }
        
        $sql = $this->db->prepare("SELECT sales_products.quant, sales_products.sale_price, inventory.name FROM sales_products INNER JOIN inventory ON inventory.id = sales_products.id_product  WHERE sales_products.id = :id AND sales_products.id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount()>0){
            $data['products'] = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $data;
    }

    public function add($id_client, $status, $total_price, $id_company, $id_user){
        $sql = $this->db->prepare("INSERT INTO sales SET id_client = :id_client, status = :status, total_price = :total_price, date_sale = NOW(), id_company = :id_company, id_user = :id_user");
        $sql->bindValue(':id_client', $id_client);
        $sql->bindValue(':status', $status);
        $sql->bindValue(':total_price', $total_price);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();

        return $this->db->lastInsertID();
    }
    public function addSaleProducts($id_sale, $id_product, $quant, $sale_price, $id_company){
        $sql = $this->db->prepare("INSERT INTO sales_products SET id_sale = :id_sale, id_product = :id_product, quant = :quant, sale_price = :sale_price, id_company = :id_company");
        $sql->bindValue(':id_sale', $id_sale);
        $sql->bindValue(':id_product', $id_product);
        $sql->bindValue(':quant', $quant);
        $sql->bindValue(':sale_price', $sale_price);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();
    }
}