<?php
class HomeController extends Controller{
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

		$this->loadTemplate('Home/index', $data);
	}
}
