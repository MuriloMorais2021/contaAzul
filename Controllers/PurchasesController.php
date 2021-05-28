<?php
class PurchasesController extends Controller{

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


        if ($user->hasPermission('purchases_view')) {
            $sales = new Sales();
            $offset = 0;

            // $data['sales_list'] =$sales->getList($offset, $user->getCompany());
            
            
            $data['edd_permission'] = $user->hasPermission('sales_add');
            $data['edit_permission'] = $user->hasPermission('purchases_edit');
            $data['page_count'] = 0;

            $this->loadTemplate('Home/Purchases/index', $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
}