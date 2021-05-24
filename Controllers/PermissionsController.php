<?php
class PermissionsController extends Controller{

    public function __construct(){
        parent::__construct();

		$user = new Users();
		if (!$user->isLogged()) {
			header('Location: '.BASE_URL.'Login');
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
        
        if($user->hasPermission('permission_view')){
            $data['JS'] = '<script type="text/javascript" src="'.BASE_URL.'Assets/js/script.js"></script>';
            
            $permissions = new Permissions();
            $data['permissions_list'] = $permissions->getList($user->getCompany());
            $data['permissions_groups_list'] = $permissions->getGroupList($user->getCompany());

            $this->loadTemplate('Home/Permissions/index', $data);
        }else{
            header("Location: ".BASE_URL);
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
        
        if($user->hasPermission('permission_view')){
            $permissions = new Permissions();
            
            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);

                if($permissions->add($name, $user->getCompany())){
                    header("Location: ".BASE_URL.'Permissions');
                    exit;
                }else{
                    //tratar mensagem de erro
                    echo "Não foi possivel inserir esse novo grupo, tente novamente mais tarde...";
                    exit;
                }
            }
            $this->loadTemplate('Home/Permissions/add', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
    public function add_group(){
        $data = array();
        $user = new Users();
		$user->setLoggedUser(); 
		$company = new Companies($user->getCompany());

		$data['company_name'] = $company->getName();
		$data['user_email'] = $user->getEmail();
        
        if($user->hasPermission('permission_view')){
            $permissions = new Permissions();
            
            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);
                $permissions_list = $_POST['permissions'];

                if($permissions->addGroup($name, $permissions_list, $user->getCompany())){
                    header("Location: ".BASE_URL.'Permissions');
                    exit;
                }else{
                    //tratar mensagem de erro
                    echo "Não foi possivel inserir esse novo grupo, tente novamente mais tarde...";
                    exit;
                }
            }

            $data['permissions_list'] = $permissions->getList($user->getCompany());

            $this->loadTemplate('Home/Permissions/add_group', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
    public function delete($id){
        $data = array();
        $user = new Users();
		$user->setLoggedUser(); 
		$company = new Companies($user->getCompany());
        
		$data['company_name'] = $company->getName();
		$data['user_email'] = $user->getEmail();
        
        if($user->hasPermission('permission_view')){
            $permissions = new Permissions();
            
            if($permissions->delete($id)){
                header("Location: ".BASE_URL.'Permissions');
                exit;
            }else{
                //tratar mensagem de erro
                echo "Não foi possivel deletar esse novo grupo, tente novamente mais tarde...";
                exit;
            }
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
    public function delete_group($id){
        $data = array();
        $user = new Users();
		$user->setLoggedUser(); 
		$company = new Companies($user->getCompany());
        
		$data['company_name'] = $company->getName();
		$data['user_email'] = $user->getEmail();
        
        if($user->hasPermission('permission_view')){
            $permissions = new Permissions();
            
            if($permissions->deleteGoup($id)){
                header("Location: ".BASE_URL.'Permissions');
                exit;
            }else{
                //tratar mensagem de erro
                echo "Não foi possivel deletar esse grupo, pois ja existe um usuario associado para este grupo...";
                exit;
            }
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
    public function edit_group($id){
        $data = array();
        $user = new Users();
		$user->setLoggedUser(); 
		$company = new Companies($user->getCompany());

		$data['company_name'] = $company->getName();
		$data['user_email'] = $user->getEmail();
        
        if($user->hasPermission('permission_view')){
            $permissions = new Permissions();
            
            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);
                $permissions_list = $_POST['permissions'];

                if($permissions->editGroup($name, $permissions_list, $id, $user->getCompany())){
                    header("Location: ".BASE_URL.'Permissions');
                    exit;
                }else{
                    //tratar mensagem de erro
                    echo "Não foi possivel inserir esse novo grupo, tente novamente mais tarde...";
                    exit;
                }
            }

            $data['permissions_list'] = $permissions->getList($user->getCompany());
            $data['group_info'] = $permissions->getGroup($id, $user->getCompany());
            
            $this->loadTemplate('Home/Permissions/edit_group', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}