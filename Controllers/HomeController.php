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

		$sales = new Sales();
		$data['statuses'] = ["1"=>"Aguardando Pgto.", "2"=>"Pago","3"=> "Cancelado"];

		$data['products_sold'] = $sales->getSoldProducts(date('y-m-d', strtotime('-30 days')), date('Y-m-d'), $user->getCompany());
		$data['revenue'] = $sales->getTotalRevenue(date('y-m-d', strtotime('-30 days')), date('Y-m-d'), $user->getCompany());
		$data['expenses'] = $sales->getTotalExpenses(date('y-m-d', strtotime('-30 days')), date('Y-m-d'), $user->getCompany());

		$data['revenue_list'] = array();
		for($i=30; $i>0; $i--){
			$data['days_list'][] = date('d/m', strtotime('-'.$i.' days'));;
		}

		$data['revenue_list'] =  $sales->getRevenueList(date('y-m-d', strtotime('-30 days')), date('Y-m-d'), $user->getCompany());
		$data['expenses_list'] =  $sales->getExpensesList(date('y-m-d', strtotime('-30 days')), date('Y-m-d'), $user->getCompany());
		$data['status_list'] =  $sales->getStatusList(date('y-m-d', strtotime('-30 days')), date('Y-m-d'), $user->getCompany());

		$data['JS'] = '<script type="text/javascript">
			var days_list = '.json_encode($data['days_list']).';
			var revenue_list = '.json_encode(array_values($data['revenue_list'])).';
			var expenses_list = '.json_encode(array_values($data['expenses_list'])).';
			var status_name_list = '.json_encode(array_values($data['statuses'])).';
			var status_value_list = '.json_encode(array_values($data['status_list'])).';
		</script>';
		$data['JS'] .= '<script type="text/javascript" src="'.BASE_URL.'Assets/js/Chart.min.js"></script>';
		$data['JS'] .= '<script type="text/javascript" src="'.BASE_URL.'Assets/js/script_home.js"></script>';

		$this->loadTemplate('Home/index', $data);
	}
}
