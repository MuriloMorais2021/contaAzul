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

        $data['JS'] = '<script type="text/javascript" src="'.BASE_URL.'Assets/js/script.js"></script>';

        if($user->hasPermission('permission_view')){
            $this->loadTemplate('Home/Permissions/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}