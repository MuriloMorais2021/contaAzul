<?php

class LoginController extends Controller{

    public function index(){
        $data = array();

        if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $email = addslashes($_POST['email']);
            $password = addslashes($_POST['password']);


            $user = new Users();
            if ($user->doLogin($email, $password)) {
                header('Location: ' . BASE_URL . 'Home');
                exit;
            } else {
                $data['error'] = "E-mail e/ou senha inválidos";
            }
        }

        $this->loadView('Login/index', $data);
    }
    public function logout()
    {
        $user = new Users();
        $user->logout();

        header("Location: " . BASE_URL);
        exit;
    }
}
