<?php
class Cidade extends Model{


    public function getStates(){
        $data = array();
        $sql = $this->db->prepare("SELECT UF FROM cidade GROUP BY UF");
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }   
        return $data;
    }
    public function getCityList($state){
        $data = array();
        $sql = $this->db->prepare("SELECT codigoMunicipio, Nome FROM cidade WHERE UF = :uf");
        $sql->bindValue(':uf', $state);
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }   
        return $data;
    }
    public function getCity($address_city_cod){
        $sql = $this->db->prepare("SELECT Nome FROM cidade WHERE codigoMunicipio = :address_city_cod");
        $sql->bindValue(':address_city_cod', $address_city_cod);
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            return $data['Nome'];
        }   
    }
}