<?php
class ajaxController extends Controller{

    public function __construct()
    {
        parent::__construct();

        $user = new Users();
        if (!$user->isLogged()) {
            header('Location: '.BASE_URL.'Login');
            exit;
        }
    }
    public function index(){

    }
    public function search_clients(){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();

        $clients = new Clients();

        if(isset($_GET['value']) && !empty($_GET['value'])){
            $value = addslashes($_GET['value']);

            $data = $clients->searchClientByName($value, $user->getCompany());
        }
        echo json_encode($data);
    }
    public function search_prod(){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();

        $Inventory = new Inventory();

        if(isset($_GET['value']) && !empty($_GET['value'])){
            $value = addslashes($_GET['value']);

            $data = $Inventory->searchProducts($value, $user->getCompany());
        }
        echo json_encode($data);
    }
    public function get_city_list(){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();
        $cidade = new Cidade();

        if(isset($_GET['state']) && !empty($_GET['state'])){
            $state = addslashes($_GET['state']);

            $data['cities'] = $cidade->getCityList($state);
        }
        echo json_encode($data);
    }
}