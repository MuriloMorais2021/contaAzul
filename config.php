<?php 
define("ENVIRONMENT", "development");
date_default_timezone_set('America/Fortaleza');
define("S_NAME", "chamados");
define("BASE_URL", "http://localhost/contaAzul/");


$config = array();
if(ENVIRONMENT == 'development'){
	$config['dbname'] = 'contaAzul';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else{	
	$config['dbname'] = '';
	$config['host'] = '';
	$config['dbuser'] = '';
	$config['dbpass'] = '';
}
global $db;
try{
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
} catch(PDOException $e){
	echo "Erro: ".$e->getMessage();
	exit;
}