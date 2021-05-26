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

    public function add($id_client, $status, $total_price, $id_company, $id_user){
        $sql = $this->db->prepare("INSERT INTO sales SET id_client = :id_client, status = :status, total_price = :total_price, date_sale = NOW(), id_company = :id_company, id_user = :id_user");
        $sql->bindValue(':id_client', $id_client);
        $sql->bindValue(':status', $status);
        $sql->bindValue(':total_price', $total_price);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();
    }

}