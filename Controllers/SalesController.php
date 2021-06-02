<?php
class SalesController extends Controller{

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

        $data['statuses'] = ["1"=>"Aguardando Pgto.", "2"=>"Pago","3"=> "Cancelado"];

        if ($user->hasPermission('sales_view')) {
            $sales = new Sales();
            $offset = 0;

            $data['sales_list'] =$sales->getList($offset, $user->getCompany());
            
            
            $data['edd_permission'] = $user->hasPermission('sales_add');
            $data['edit_permission'] = $user->hasPermission('sales_edit');
            $data['page_count'] = 0;
            $this->loadTemplate('Home/Sales/index', $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function view_nfe($nfe_key){
        
    }
    public function generate_nfe($id_sale){
        $data = array();
        $user = new Users();
        $user->setLoggedUser();
        $company = new Companies($user->getCompany());
        $sales = new Sales();
        $clients = new Clients();

        $cNF = $company->getNextNFE();

        $sales_info = $sales->getAllInfo($id_sale, $user->getCompany());
        $client_info = $clients->getInfo($sales_info['info']['id_client'], $user->getCompany());
        
        $fatinfo = array(
            'nfat' => $id_sale,
            'vorig' => number_format($sales_info['info']['total_price'], 2),
            'vdesc' => '',
            'modFrete'=> '9'
        );
        
        $dest = array(
            'cpf' => $client_info['cpf'],
            'cnpj' => $client_info['cnpj'],
            'idestrangeiro' => $client_info['foreignid'],
            'nome' => $client_info['name'],
            'email' => $client_info['email'],
            'iedest' => $client_info['iedest'],
            'ie' => $client_info['ie'],
            'isuf' => $client_info['isuf'],
            'im' => $client_info['im'],
            'end' => array(
                'logradouro' => $client_info['address'],
                'numero' => $client_info['address_number'],
                'complemento' => $client_info['address2'],
                'bairro' => $client_info['address_neighb'],
                'mu' => $client_info['address_city'],
                'uf' => $client_info['address_state'],
                'cep' => $client_info['address_zipcode'],
                'pais' => $client_info['address_country'],
                'fone' => $client_info['phone'],
                'cmu' => $client_info['address_citycode'],
                'cpais' => $client_info['address_countrycode']
            )
        );
        $prods = array();
        foreach($sales_info['products'] as $prod){
            $sale_price = number_format($prod['sale_price'], 2);
            $prods[] = array(
                'cProd' => $prod['id_product'],
                'cEAN' => $prod['c']['cEAN'],
                'xProd' => $prod['c']['name'],
                'NCM' => $prod['c']['NCM'],
                'EXTIPI' => $prod['c']['EXTIPI'],
                'CFOP' => $prod['c']['CFOP'],
                'uCom' => $prod['c']['uCom'],
                'vUnCom' => $sale_price,
                'cEANTrib' => $prod['c']['cEANTrib'],
                'uTrib' => $prod['c']['uTrib'],
                'vUnTrib' => $sale_price,
                'vFrete' => $prod['c']['vFrete'],
                'vSeg' => $prod['c']['vSeg'],
                'vDesc' => $prod['c']['vDesc'],
                'vOutro' => $prod['c']['vOutro'],
                'indTot' => $prod['c']['indTot'],
                'xPed' => $prod['c']['xPed'],
                'nItemPed' => $prod['c']['nItemPed'],
                'nFCI' => $prod['c']['nFCI'],
                'cst' => $prod['c']['cst'],
                'pPIS' => number_format($prod['c']['pPIS'], 2),
                'pCOFINS' => number_format($prod['c']['pCOFINS'], 2),
                'csosn' => $prod['c']['csosn'],
                'pICMS' => $prod['c']['pICMS'], // 18
                'orig' => $prod['c']['orig'],
                'modBC' => $prod['c']['modBC'],
                'vICMSDeson' => $prod['c']['vICMSDeson'],
                'pRedBC' => $prod['c']['pRedBC'],
                'modBCST' => $prod['c']['modBCST'],
                'pMVAST' => $prod['c']['pMVAST'],
                'pRedBCST' => $prod['c']['pRedBCST'],
                'vBCSTRet' => $prod['c']['vBCSTRet'],
                'vICMSSTRet' => $prod['c']['vICMSSTRet'],
                'qBCProd' => $prod['c']['qBCProd'],
                'vAliqProd' => $prod['c']['vAliqProd'],
                'qCom' => $prod['quant'],
                'vProd' => ($prod['quant'] * $sale_price),
                'vBC' => ($prod['quant'] * $sale_price),
                'qTrib' => $prod['quant']
            );
        }

        $nfe = new Nfe();
        $chave = $nfe->emitirNFE($cNF, $dest, $prods, $fatinfo);

        if(!empty($chave)){
            $company->setNFE($cNF, $user->getCompany());

            $sales->setNFEKey($chave, $id_sale);
            header("Location: ".BASE_URL."sales/view_nfe/".$chave);
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
        
        

        if ($user->hasPermission('sales_edit')) {
            $sales = new Sales();
            $client = new Clients();
            $inventory = new Inventory();
            if(isset($_POST['clients_id']) && !empty($_POST['clients_id']) && isset($_POST['status']) && !empty($_POST['status']) && isset($_POST['quant']) && !empty($_POST['quant'])){
                $clients_id = addslashes($_POST['clients_id']);
                $status = addslashes($_POST['status']);

                $quant = $_POST['quant'];
                $total_price = 0;

                //iteração para calcular o preço de cada profuto e ter um valor total da venda
                foreach($quant as $id_prod => $quant_prod){
                    $retorno = $inventory->getPrice($id_prod, $user->getCompany());
                    $total_price += $retorno*$quant_prod;
                }
                //insiro a venda e rretorno o id da venda para ser adicionado em produtos das vendas, sendo assim vou ter o detalhe dos produtos vendidos naquela venda
                $id_sale = $sales->add($clients_id, $status, $total_price, $user->getCompany(), $user->getId());

                //iteração para pegar o id de cada produto e inserir os produtos daquela venda.
                foreach($quant as $id_prod => $qtd){
                    $price = $inventory->getPrice($id_prod, $user->getCompany());
                    $sales->addSaleProducts($id_sale, $id_prod, $qtd, $price, $user->getCompany());
                    //baixando a quantidade do produto que esta no estoque
                    $inventory->downInventory($id_prod, $qtd, $user->getCompany(), $user->getId());
                }
                
                header("Location: ".BASE_URL.'Sales');
                exit;
            }


            $data['clients_list'] = $client->getListClient($user->getCompany());
            $data['JS'] = '<script src="'.BASE_URL.'Assets/js/jquery.mask.js"></script>';
            $data['JS'] .= '<script src="'.BASE_URL.'Assets/js/script_sale.js"></script>';

            $this->loadTemplate('Home/Sales/add', $data);
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

        $data['statuses'] = ["1"=>"Aguardando Pgto.", "2"=>"Pago","3"=> "Cancelado"];

        if ($user->hasPermission('sales_edit')) {
            $sales = new Sales();
            
            $data['sales_edit'] = $user->hasPermission('sales_edit');
            
            if(isset($_POST['status']) && !empty($_POST['status']) && $data['sales_edit']){
                $status = addslashes($_POST['status']);

                $sales->updateStatus($status, $id, $user->getCompany());
                
                header('Location: '.BASE_URL.'Sales');
                exit;
            }

            $data['sales_info'] = $sales->getInfo($id, $user->getCompany());

            $this->loadTemplate('Home/Sales/edit', $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
}