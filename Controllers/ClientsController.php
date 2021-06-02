<?php
class ClientsController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $user = new Users();
        if (!$user->isLogged()) {
            header('Location: ' . BASE_URL . 'Login');
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

        if ($user->hasPermission('clients_view')) {

            $clients = new Clients();
            $offset = 0;
            $data['page'] = 1;
            if(isset($_get['page']) && !empty($_get['page'])){
                $data['page'] = intval($_GET['page']);

                if($data['page'] == 0){
                    $data['page'] = 1;
                }
            }
            $offset = (10*($data['page'] -1));
            
            $data['clients_list'] = $clients->getList($offset, $user->getCompany());
            $data['clients_count'] = $clients->getCount($user->getCompany());
            $data['edit_permission'] = $user->hasPermission('clients_edit');
            $data['page_count'] = ceil($data['clients_count']/10);

            $data['JS'] = '<script type="text/javascript" src="'.BASE_URL.'Assets/js/script.js"></script>';
            
            $this->loadTemplate('Home/Clients/index', $data);
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

        if ($user->hasPermission('clients_edit')) {
            $clients = new Clients();
            $cidade = new Cidade();

            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $phone = addslashes($_POST['phone']);
                $stars = addslashes($_POST['stars']);
                $internal_obs = addslashes($_POST['internal_obs']);
                $address_zipcode = addslashes($_POST['address_zipcode']);
                $address = addslashes($_POST['address']);
                $address_number = addslashes($_POST['address_number']);
                $address2 = addslashes($_POST['address2']);
                $address_neighb = addslashes($_POST['address_neighb']);
                $address_city_cod = addslashes($_POST['address_city']);
                $address_state = addslashes($_POST['address_state']);
                $address_country = addslashes($_POST['address_country']);
                $address_city = $cidade->getCity($address_city_cod);
                


                $clients->add($name, $email, $phone, $stars, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country, $address_city_cod,$user->getCompany());
                header("Location: ".BASE_URL."Clients");
                exit;
            }
            $data['states_list'] = $cidade->getStates();
            $data['JS'] = '<script src="'.BASE_URL.'Assets/js/script_clients.js"></script>';

            $this->loadTemplate('Home/Clients/add', $data);
        } else {
            header("Location: " .BASE_URL.'Clients/index');
            exit;
        }
    }
    public function edit($id){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();
        $company = new Companies($user->getCompany());
        $id = addslashes($id);

        $data['company_name'] = $company->getName();
        $data['user_email'] = $user->getEmail();

        if ($user->hasPermission('clients_edit')) {
            $clients = new Clients();
            $cidade = new Cidade();

            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $phone = addslashes($_POST['phone']);
                $stars = addslashes($_POST['stars']);
                $internal_obs = addslashes($_POST['internal_obs']);
                $address_zipcode = addslashes($_POST['address_zipcode']);
                $address = addslashes($_POST['address']);
                $address_number = addslashes($_POST['address_number']);
                $address2 = addslashes($_POST['address2']);
                $address_neighb = addslashes($_POST['address_neighb']);
                $address_city_cod = addslashes($_POST['address_city']);
                $address_state = addslashes($_POST['address_state']);
                $address_country = addslashes($_POST['address_country']);
                
                $address_city = $cidade->getCity($address_city_cod);
                
                $clients->edit($name, $email, $phone, $stars, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country, $id, $user->getCompany(), $address_city_cod);
                header("Location: ".BASE_URL."Clients");
                exit;
            }
            
            $data['client_info'] = $clients->getInfo($id, $user->getCompany());
            
            $data['states_list'] = $cidade->getStates(); 
            $data['cities_list'] = $cidade->getCityList($data['client_info']['address_state']); 

            $data['JS'] = '<script src="'.BASE_URL.'Assets/js/script_clients.js"></script>';


            $this->loadTemplate('Home/Clients/edit', $data);
        } else {
            header("Location: " .BASE_URL.'Clients/index');
            exit;
        }
    }
    public function delete($id){

    }
}