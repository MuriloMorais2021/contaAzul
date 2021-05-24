<?php
class Users extends Model{

	private $userInfo;
	private $permissions;

	//função para verificar se existe uma sessão iniciada, a sessão é inicada qm do login caso exista aquele usuario
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
				$this->permissions->setGroup($this->userInfo['id_group'], $this->userInfo['id_company']);
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
	public function getInfo($id, $id_company){
		$data = array();
		$sql = $this->db->prepare("SELECT * FROM users WHERE id = :id AND  id_company = :id_company");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount()>0){
			$data = $sql->fetch(PDO::FETCH_ASSOC);
		}		
		return $data;
	}
	public function findUsersInGroup($id){
		$sql = $this->db->prepare("SELECT count(*) as c FROM users WHERE id_group = :id_group");
		$sql->bindValue(':id_group', $id);
		$sql->execute();

		$row = $sql->fetch();
		
		if($row['c'] == '0'){
			return false;
		}else{
			return true; 
		}
	}
	public function getList($id_company){
		$data = array();
		$sql = $this->db->prepare("SELECT users.id, users.email, permission_groups.name FROM users INNER JOIN permission_groups ON permission_groups.id = users.id_group WHERE users.id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount()>0){
			$data = $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;
	}
	// metodo para adicionar usuario, antes de inserir sera feito uma consulta para saber se ja existe um email(login) igual ao que esta sendo adicionado
	public function add($email, $password, $group, $id_company){
		$sql = $this->db->prepare("SELECT count(*) as c FROM users WHERE email = :email");
		$sql->bindValue(":email", $email);
		$sql->execute();
		$row = $sql->fetch();

		if($row['c'] == '0'){
			$sql1 = $this->db->prepare("INSERT INTO users SET email = :email, password = :password, id_group = :id_group, id_company = :id_company");
			$sql1->bindValue(":email", $email);
			$sql1->bindValue(":password", md5($password));
			$sql1->bindValue(":id_group", $group);
			$sql1->bindValue(":id_company", $id_company);
			$sql1->execute();

			return true;	
		}else{
			return false;
		}
	}
	public function editPassword($password, $group, $id, $id_company){
		$sql = $this->db->prepare("UPDATE users SET password = :password, id_group = :id_group WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':password', md5($password));
		$sql->bindValue(':id_group', $group);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);

		if($sql->execute()){
			return true;
		}else{
			return false;
		}
	}
	public function editGroup($group, $id, $id_company){
		$sql = $this->db->prepare("UPDATE users SET id_group = :group WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':group', $group);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);

		if($sql->execute()){
			return true;
		}else{
			return false;
		}
	}
	public function delete($id, $id_company){
		$sql = $this->db->prepare("DELETE FROM users WHERE id =:id AND id_company = :id_company");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);

		if($sql->execute()){
			return true;
		}else{
			return false;
		}
	}
}
