<?php
class UsersController extends Controller
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
    public function index()
    {
        $data = array();
        $user = new Users();
        $user->setLoggedUser();
        $company = new Companies($user->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_email'] = $user->getEmail();

        if ($user->hasPermission('users_view')) {

            $data['users_list'] = $user->getList($user->getCompany());

            $this->loadTemplate('Home/Users/index', $data);
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

        if ($user->hasPermission('users_view')) {

            if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['group']) && !empty($_POST['group'])) {
                $email = addslashes($_POST['email']);
                $password = addslashes($_POST['password']);
                $group = addslashes($_POST['group']);

                if ($user->add($email, $password, $group, $user->getCompany())) {
                    header("Location: ".BASE_URL.'Users');
                    exit;
                }else{
                    $data['user'] = ['email'=>$email, 'password'=> $password, 'group' => $group];
                    $data['error'] = "Usuário já existe!";
                }
            }

            $permission = new Permissions();
            $data['group_list'] = $permission->getGroupList($user->getCompany());

            $this->loadTemplate('Home/Users/add', $data);
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
        $id = addslashes($id);
        
        if ($user->hasPermission('users_view')) {

            if (isset($_POST['group']) && !empty($_POST['group'])) {
                $group = addslashes($_POST['group']);

                if(isset($_POST['password']) && !empty($_POST['password'])){
                    $password = addslashes($_POST['password']);
                    
                    if($user->editPassword($password, $group, $id, $user->getCompany())){
                        header("Location: ".BASE_URL.'Users');
                        exit;
                    }else{
                        $data['error'] = "Não foi possivel editar o usuário, por favor tente novamente mais tarde!";
                    }
                }
                if($user->editGroup($group, $id, $user->getCompany())){
                    header("Location: ".BASE_URL.'Users');
                    exit;
                }else{
                    $data['error'] = "Não foi possivel editar o usuário, por favor tente novamente mais tarde!";
                }
            }

            $permission = new Permissions();
            $data['user_info'] = $user->getInfo($id, $user->getCompany());
            $data['group_list'] = $permission->getGroupList($user->getCompany());

            $this->loadTemplate('Home/Users/edit', $data);
        } else {
            header("Location: " . BASE_URL);
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

        if ($user->hasPermission('users_view')) {

            if($user->delete($id, $user->getCompany())){
                header("Location: ".BASE_URL."Users");
                exit;
            }else{
                $data['error'] = "Não foi deletar esse usuário, por favor tente novamente mais tarde!";
            }

            $data['users_list'] = $user->getList($user->getCompany());
        
            $this->loadTemplate('Home/Users/index', $data);
        }else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
}
