<?php
class ReportsController extends Controller{

    public function __construct(){
        parent::__construct();

        $user = new Users();
        if (!$user->isLogged()) {
            header('Location: ' . BASE_URL .'Login');
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


        if ($user->hasPermission('reports_view')) {
            
            $this->loadTemplate('Home/Reports/index', $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function sales(){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();
        $company = new Companies($user->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_email'] = $user->getEmail();

        $data['statuses'] = ["1"=>"Aguardando Pgto.", "2"=>"Pago","3"=> "Cancelado"];

        if ($user->hasPermission('reports_view')) {
            
            $data['JS'] = '<script src="'.BASE_URL.'Assets/js/report_sales.js"></script>';

            $this->loadTemplate('Home/Reports/sales', $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function sales_pdf(){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();

        $data['statuses'] = ["1"=>"Aguardando Pgto.", "2"=>"Pago","3"=> "Cancelado"];

        if ($user->hasPermission('reports_view')) {
            
            $client_name = addslashes($_GET['name']);
            $date1 = addslashes($_GET['date1']);
            $date2 = addslashes($_GET['date2']);
            $status = addslashes($_GET['status']);
            $order = addslashes($_GET['order']);

            $sales = new Sales();

            $data['sales_list'] = $sales->getSalesFiltered($client_name, $date1, $date2, $status, $order, $user->getCompany());
            
            $data['filters'] = $_GET;

            $this->loadLibrary('mpdf-6.1/mpdf');
            ob_start();
            $this->loadView('Home/Reports/sales_pdf', $data);
            $html  = ob_get_contents();
            ob_end_clean();

            $mpdf = new mPDF();
            $mpdf->writeHTML($html);
            $mpdf->Output();
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function inventory(){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();
        $company = new Companies($user->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_email'] = $user->getEmail();


        if ($user->hasPermission('reports_view')) {
            
            $data['JS'] = '<script src="'.BASE_URL.'Assets/js/report_inventory.js"></script>';

            $this->loadTemplate('Home/Reports/inventory', $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function inventory_pdf(){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();


        if ($user->hasPermission('reports_view')) {
            $inventory = new Inventory();

           $data['inventory_list'] = $inventory->getInventoryFiltered($user->getCompany());


            $this->loadLibrary('mpdf-6.1/mpdf');
            ob_start();
            $this->loadView('Home/Reports/inventory_pdf', $data);
            $html  = ob_get_contents();
            ob_end_clean();

            $mpdf = new mPDF();
            $mpdf->writeHTML($html);
            $mpdf->Output();
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
}