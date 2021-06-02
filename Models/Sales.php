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
    public function getAllInfo($id_sale, $id_company){
        $data = array();
        $sql = $this->db->prepare("SELECT * FROM sales WHERE id = :id");
        $sql->bindValue(':id', $id_sale);
        $sql->execute();

        if($sql->rowCount()>0){
            $data['info'] = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $sql = $this->db->prepare("SELECT id_product, quant, sale_price FROM sales_products WHERE id_sale = :id_sale");
        $sql->bindValue(':id_sale', $id_sale);
        $sql->execute();

        if($sql->rowCount()>0){
            $data['products'] = $sql->fetchAll(PDO::FETCH_ASSOC);

            $inventory = new Inventory();
            foreach($data['products'] as $pkey => $pval){

                $data['products'][$pkey]['c'] = $inventory->getInfo($pval['id_product'], $id_company );
            }
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
        
        $sql = $this->db->prepare("SELECT sales_products.quant, sales_products.sale_price, inventory.name FROM sales_products INNER JOIN inventory ON inventory.id = sales_products.id_product  WHERE sales_products.id_sale = :id AND sales_products.id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if($sql->rowCount()>0){
            $data['products'] = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $data;
    }
    public function setNFEKey($chave, $id_sale){
        $sql = $this->db->prepare("UPDATE sales SET nfe_key = :nfe_key WHERE id = :id");
        $sql->bindValue(':nfe_key', $chave);
        $sql->bindValue(':id', $id_sale);
        $sql->execute();


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

    public function updateStatus($status, $id, $id_company){
        $sql = $this->db->prepare("UPDATE sales SET status = :status WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':status', $status);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

    }

    public function getSalesFiltered($client_name, $date1, $date2, $status, $order, $id_company){
        $data = array();

        $sql = "SELECT sales.date_sale, sales.status, sales.total_price, clients.name FROM sales INNER JOIN clients ON clients.id = sales.id_client WHERE ";

        $where = array();

        $where[] = "sales.id_company = :id_company";

        if(!empty($client_name)){
            $where[] = "clients.name LIKE '%".$client_name."%'";
        }
        if(!empty($date1) && !empty($date2)){
            $where[] = "sales.date_sale BETWEEN :date1 AND :date2";
        }
        if(!empty($status)){
            $where[] = "sales.status = :status";
        }

        $sql .= implode(' AND ', $where);

        switch($order){
            case 'date_desc':
            default:
                $sql .= " ORDER BY date_sale DESC";
                break;
            case 'date_asc':
                $sql .= " ORDER BY date_sale ASC";
                break;
            case 'status':
                $sql .= " ORDER BY sales.status";
                break;
            
        }
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_company', $id_company);

        if(!empty($date1) && !empty($date2)){
            $sql->bindValue(':date1', $date1);
            $sql->bindValue(':date2', $date2);
        }
        if(!empty($status)){
            $sql->bindValue(':status', $status);
        }
        $sql->execute();

        if($sql->rowCount()>0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    public function getTotalRevenue($period1, $period2, $id_company){
        $float = 0;

        $sql = $this->db->prepare("SELECT SUM(total_price) as total FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2");
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':period1', $period1);
        $sql->bindValue(':period2', $period2);
        $sql->execute();

        $n = $sql->fetch(PDO::FETCH_ASSOC);
        $float = $n['total'];


        return $float;
    }
    public function getTotalExpenses($period1, $period2, $id_company){
        $float = 0;

        $sql = $this->db->prepare("SELECT SUM(total_price) as total FROM purchases WHERE id_company = :id_company AND date_purchase BETWEEN :period1 AND :period2");
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':period1', $period1);
        $sql->bindValue(':period2', $period2);
        $sql->execute();

        $n = $sql->fetch(PDO::FETCH_ASSOC);
        $float = $n['total'];


        return $float;
    }
    public function getSoldProducts($period1, $period2, $id_company){
        $int = 0;

        $sql = $this->db->prepare("SELECT id FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2");
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':period1', $period1);
        $sql->bindValue(':period2', $period2);
        $sql->execute();

        if($sql->rowCount()>0){
            $p = array();
            foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $sale_item){
                $p[] = $sale_item['id'];
            }
            $sql = $this->db->prepare("SELECT COUNT(*) as total FROM sales_products WHERE id_sale IN (".implode(',', $p).")");
            $sql->execute();

            $n = $sql->fetch(PDO::FETCH_ASSOC);

            $int = $n['total'];
        }

        return $int;
    }
    //metodo para pegar a lista de vendas para serem atribuidas no gráfico de vendas
    public function getRevenueList($period1, $period2, $id_company){
        $data = array();
        //atribuo a uma variavel o valor da varivel de period 1 tudo isso para criar um array com 30 indices sendo key = data and value = 0
        $curretDay = $period1;
        //loop para preencher cada campo do array enquanto a data final for diferente da data inicial e em cada loop ele vai receber mais um dia ate chegar na data final
        while($period2 != $curretDay){
            //atribuo ao array a key da data, asssim vou formar o array com 30 dias todos iniciando com 0
            $data[$curretDay] = 0;
            //Aqui eu atribuo mais um dia sendo formatado para somente data, para que o loop continue até a data final 
            $curretDay = date('Y-m-d', strtotime('+1 day', strtotime($curretDay)));
        }
        //busco do banco as datas e a soma para aquela data
        $sql = $this->db->prepare("SELECT DATE_FORMAT(date_sale, '%Y-%m-%d') as date_sale, SUM(total_price) as total FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2 GROUP BY DATE_FORMAT(date_sale, '%Y-%m-%d')");
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':period1', $period1);
        $sql->bindValue(':period2', $period2);
        $sql->execute();

        if($sql->rowCount()>0){
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

            //iteração para atribuir o valor total de vendas naquele dia, o indice data do array recebe o valor total, 
            //se eu fizesse somente esta atribuição ele iria ignorar os dias que nao teve venda deixando sem resultado,
            //isso no gráfico iria ficar quebrado, como solução foi necessario antes de tudo montar o array com 30 indices,
            //como mostrado acima e inicialmente setados com 0, depois substituido pelo valor total como mostrado logo abaixo. 
            foreach($rows as $sale_item){
                $data[$sale_item['date_sale']] = $sale_item['total'];
            }
        }
        return $data;
    }
    //metodo para pegar a lista de vendas para serem atribuidas no gráfico de vendas
    public function getExpensesList($period1, $period2, $id_company){
        $data = array();
        //atribuo a uma variavel o valor da varivel de period 1 tudo isso para criar um array com 30 indices sendo key = data and value = 0
        $curretDay = $period1;
        //loop para preencher cada campo do array enquanto a data final for diferente da data inicial e em cada loop ele vai receber mais um dia ate chegar na data final
        while($period2 != $curretDay){
            //atribuo ao array a key da data, asssim vou formar o array com 30 dias todos iniciando com 0
            $data[$curretDay] = 0;
            //Aqui eu atribuo mais um dia sendo formatado para somente data, para que o loop continue até a data final 
            $curretDay = date('Y-m-d', strtotime('+1 day', strtotime($curretDay)));
        }
        //busco do banco as datas e a soma para aquela data
        $sql = $this->db->prepare("SELECT DATE_FORMAT(date_purchases, '%Y-%m-%d') as date_purchases, SUM(total_price) as total FROM purchases WHERE id_company = :id_company AND date_purchases BETWEEN :period1 AND :period2 GROUP BY DATE_FORMAT(date_purchases, '%Y-%m-%d')");
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':period1', $period1);
        $sql->bindValue(':period2', $period2);
        $sql->execute();

        if($sql->rowCount()>0){
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

            //iteração para atribuir o valor total de vendas naquele dia, o indice data do array recebe o valor total, 
            //se eu fizesse somente esta atribuição ele iria ignorar os dias que nao teve venda deixando sem resultado,
            //isso no gráfico iria ficar quebrado, como solução foi necessario antes de tudo montar o array com 30 indices,
            //como mostrado acima e inicialmente setados com 0, depois substituido pelo valor total como mostrado logo abaixo. 
            foreach($rows as $sale_item){
                $data[$sale_item['date_purchases']] = $sale_item['total'];
            }
        }

        return $data;
    }

    public function getStatusList($period1, $period2, $id_company){
        $data = array("1"=>"0", "2"=>"0", "3"=>"0");
        $sql = $this->db->prepare("SELECT COUNT(id) as total, status FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2 GROUP BY status ORDER BY status ASC");
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':period1', $period1);
        $sql->bindValue(':period2', $period2);
        $sql->execute();

        if($sql->rowCount()>0){
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach($rows as $sale_item){
                $data[$sale_item['status']] = $sale_item['total'];
            }
        }

        return $data;
    }
}