<?php 

class Controller{
	protected $db;

	public function __construct() {
		global $config;
		$this->db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
	}

	public function loadView($viewName, $viewData = array() ){
		extract($viewData);
		require 'Views/'.$viewName.'.php';
	}

	public function loadTemplate($viewName, $viewData = array()){
		
		require 'Views/template.php';
	}


	public function loadViewInTemplate($viewName, $viewData = array()){
		extract($viewData);
		require 'Views/'.$viewName.'.php';
	}
	public function loadLibrary($lib){
		if(file_exists('Libraries/'.$lib.'.php')){
			include 'Libraries/'.$lib.'.php';
		}
	}
}