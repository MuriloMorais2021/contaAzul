<?php
class SalesController extends Controller{

    public function __construct(){
        parent::__construct();

        $user = new Users();
        if (!$user->isLogged()) {
            header('Location: ' . BASE_URL .'Login');
            exit;
        }
    }
    public function index(){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();
        $company = new Companies($user->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_email'] = $user->getEmail();

        $data['statuses'] = ["1"=>"Aguardando Pgto.", "2"=>"Pago","3"=> "Cancelado"];

        if ($user->hasPermission('sales_view')) {
            $sales = new Sales();
            $offset = 0;

            $data['sales_list'] =$sales->getList($offset, $user->getCompany());
            
            
            $data['edd_permission'] = $user->hasPermission('sales_add');
            $data['edit_permission'] = $user->hasPermission('sales_edit');
            $data['page_count'] = 0;
            $this->loadTemplate('Home/Sales/index', $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }

    public function add(){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();
        $company = new Companies($user->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_email'] = $user->getEmail();
        
        

        if ($user->hasPermission('sales_edit')) {
            $sales = new Sales();
            $client = new Clients();
            $inventory = new Inventory();
            if(isset($_POST['clients_id']) && !empty($_POST['clients_id']) && isset($_POST['status']) && !empty($_POST['status']) && isset($_POST['quant']) && !empty($_POST['quant'])){
                $clients_id = addslashes($_POST['clients_id']);
                $status = addslashes($_POST['status']);

                $quant = $_POST['quant'];
                $total_price = 0;

                //iteração para calcular o preço de cada profuto e ter um valor total da venda
                foreach($quant as $id_prod => $quant_prod){
                    $retorno = $inventory->getPrice($id_prod, $user->getCompany());
                    $total_price += $retorno*$quant_prod;
                }
                //insiro a venda e rretorno o id da venda para ser adicionado em produtos das vendas, sendo assim vou ter o detalhe dos produtos vendidos naquela venda
                $id_sale = $sales->add($clients_id, $status, $total_price, $user->getCompany(), $user->getId());

                //iteração para pegar o id de cada produto e inserir os produtos daquela venda.
                foreach($quant as $id_prod => $qtd){
                    $price = $inventory->getPrice($id_prod, $user->getCompany());
                    $sales->addSaleProducts($id_sale, $id_prod, $qtd, $price, $user->getCompany());
                    //baixando a quantidade do produto que esta no estoque
                    $inventory->downInventory($id_prod, $qtd, $user->getCompany(), $user->getId());
                }
                
                header("Location: ".BASE_URL.'Sales');
                exit;
            }


            $data['clients_list'] = $client->getListClient($user->getCompany());
            $data['JS'] = '<script src="'.BASE_URL.'Assets/js/jquery.mask.js"></script>';
            $data['JS'] .= '<script src="'.BASE_URL.'Assets/js/script_sale.js"></script>';

            $this->loadTemplate('Home/Sales/add', $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function edit($id){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();
        $company = new Companies($user->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_email'] = $user->getEmail();


        if ($user->hasPermission('sales_edit')) {
            $sales = new Sales();

            $data['sales_info']= $sales->getInfo($id, $user->getCompany());
            
            $this->loadTemplate('Home/Sales/edit', $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
}