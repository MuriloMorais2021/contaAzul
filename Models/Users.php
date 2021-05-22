<?php
class Users extends Model{

	private $userInfo;
	private $permissions;

	//função para verificar se eciste uma sessão iniciada, a sessão é inicada qm do login caso exista aquele usuario
	public function isLogged(){
		if (isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
			return true;
		} else {
			return false;
		}
	}
	// verifica se existe um usuario e se as suas informações estão corretas, ai se inicia a sessão
	public function doLogin($email, $password){
		$sql = $this->db->prepare("SELECT * FROM users WHERE email =:email AND password = :password");
		$sql->bindValue(':email', $email);
		$sql->bindValue(':password', md5($password));
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$row = $sql->fetch(PDO::FETCH_ASSOC);

			$_SESSION['ccUser'] = $row['id'];
			return true;
		} else {
			return false;
		}
	}
	// função para setar informações do usuarioo logado
	public function setLoggedUser(){
		//proteção a mais, não seria necessario fazer essa verificação, pois para chegar ate aqui ele vai ter que ja existir uma sessão
		if (isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
			$id = $_SESSION['ccUser'];

			$sql = $this->db->prepare("SELECT * FROM users WHERE id = :id");
			$sql->bindValue(':id', $id);
			$sql->execute();

			//se tiver retorno ele vai setar as informações em variaveis para que seja usados em outros metodos
			if ($sql->rowCount() > 0) {
				$this->userInfo = $sql->fetch(PDO::FETCH_ASSOC);
				//instancia criada para setar os grupos de permissoes do usuario, para isto é passado o id do grupo e id da companhia
				$this->permissions = new Permissions();
				$this->permissions->setGroup($this->userInfo['group'], $this->userInfo['id_company']);
			}
		}
	}
	//metodo para encerrar a sessão do usuario
	public function logout(){
		unset($_SESSION['ccUser']);
	}
	//esse metodo é somente para facilitar na hora de chamar, ele faz chamada de outro metodo de outra classe que extend de Model, onde retornara se o usuario tem aquela permissão
	public function hasPermission($name){
		return $this->permissions->hasPermission($name);
	}
	//metodo para retornar o id da empres que o usuario faz parte
	public function getCompany(){
		if (isset($this->userInfo['id_company'])) {
			return $this->userInfo['id_company'];
		}else{
			return 0;
		}
	}
	//metodo para retornar o email do usuario, no caso o identificador, esse sera apresentado no menu do template 
	public function getEmail(){
		if (isset($this->userInfo['email'])) {
			return $this->userInfo['email'];
		}else{
			return 0;
		}
	}
}
