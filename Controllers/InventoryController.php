<?php
class InventoryController extends Controller{

    public function __construct(){
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

        if ($user->hasPermission('inventory_view')) {
            $inventory = new Inventory();
            $offset = 0;

            $data['inventory_list'] = $inventory->getList($offset, $user->getCompany());
    
            $data['add_permission'] = $user->hasPermission('inventory_add');
            $data['edit_permission'] = $user->hasPermission('inventory_edit');


            $data['page_count'] = 2;

            $this->loadTemplate('Home/Inventory/index', $data);
        }else{  
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

        if ($user->hasPermission('inventory_add')) {
            $inventory = new Inventory();

           if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['price']) && !empty($_POST['price']) && isset($_POST['quant']) && !empty($_POST['quant']) && isset($_POST['quant_min']) && !empty($_POST['quant_min'])){
                $name = addslashes($_POST['name']);
                $price = addslashes($_POST['price']);
                $quant = addslashes($_POST['quant']);
                $quant_min = addslashes($_POST['quant_min']);

                $price = str_replace('.', '', $price);
                $price = str_replace(',', '.', $price);

                $inventory->add($name, $price, $quant, $quant_min, $user->getCompany(), $user->getId());
                
                header("Location: " .BASE_URL.'Inventory');
                exit;    
            }

            $data['JS'] = '<script src="'.BASE_URL.'Assets/js/jquery.mask.js"></script>';
            
            $data['page_count'] = 2;

            $this->loadTemplate('Home/Inventory/add', $data);
        }else{  
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

        if ($user->hasPermission('inventory_edit')) {
            $inventory = new Inventory();
            $id = addslashes($id);
            
           if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['price']) && !empty($_POST['price']) && isset($_POST['quant']) && !empty($_POST['quant']) && isset($_POST['quant_min']) && !empty($_POST['quant_min'])){
                $name = addslashes($_POST['name']);
                $price = addslashes($_POST['price']);
                $quant = addslashes($_POST['quant']);
                $quant_min = addslashes($_POST['quant_min']);

                $price = str_replace('.', '', $price);
                $price = str_replace(',', '.', $price);

                $inventory->edit($id, $name, $price, $quant, $quant_min, $user->getCompany(), $user->getId());
                
                header("Location: " .BASE_URL.'Inventory');
                exit;    
            }

            $data['inventory_list'] = $inventory->getInfoInventory($id, $user->getCompany());

            $data['JS'] = '<script src="'.BASE_URL.'Assets/js/jquery.mask.js"></script>';

            $this->loadTemplate('Home/Inventory/edit', $data);
        }else{  
            header("Location: " . BASE_URL);
            exit;
        }
    }

    public function  delete($id){
        $user = new Users();
        $user->setLoggedUser();
        
        if ($user->hasPermission('inventory_edit')) {
            $inventory = new Inventory();

            $inventory->delete($id, $user->getCompany(), $user->getId());

            header("Location: " .BASE_URL.'Inventory');
            exit;
        }else{
            header("Location: " . BASE_URL);
            exit;
        }
    }
}