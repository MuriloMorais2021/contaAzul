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

        $data['statuses'] = ["0"=>"Aguaruardando Pgto.", "1"=>"Pago","2"=> "Cancelado"];

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
        
        

        if ($user->hasPermission('sales_view')) {
            $sales = new Sales();
            $client = new Clients();

            if(isset($_POST['clients_id']) && !empty($_POST['clients_id']) && isset($_POST['status']) && !empty($_POST['status']) && isset($_POST['total_price']) && !empty($_POST['total_price'])){
                $clients_id = addslashes($_POST['clients_id']);
                $status = addslashes($_POST['status']);
                $total_price = addslashes($_POST['total_price']);
                
                $total_price = str_replace('.', '', $total_price);
                $total_price = str_replace(',', '.', $total_price);

                $sales->add($clients_id, $status, $total_price, $user->getCompany(), $user->getId());
                header("Location: ".BASE_URL.'Sales');
                exit;
            }


            $data['clients_list'] = $client->getListClient($user->getCompany());
            $data['JS'] = '<script src="'.BASE_URL.'Assets/js/jquery.mask.js"></script>';

            $this->loadTemplate('Home/Sales/add', $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }

    

}