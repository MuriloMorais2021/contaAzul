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

}