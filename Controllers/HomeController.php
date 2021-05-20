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
	public function index()
	{
		$data = array();

		$data['dev'] = "Tiago Ferreira da Silva";

		$this->loadTemplate('Home/index', $data);
	}
}
