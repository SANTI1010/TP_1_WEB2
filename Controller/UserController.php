<?php 

require_once "./View/UserView.php";
require_once "./Model/UserModel.php";
require_once "./Helpers/Helper.php";



class UserController {

	private $view;
	private $model;
	private $authHelper;

	public function __construct(){
		$this->view = new UserView();
		$this->model = new UserModel();
		$this->authHelper = new Helper();
	}

	function ShowLogin() {
		$this->view->ShowLogin();
	}

	public function UserLoguedIn() {
		if(empty($_POST['input_user_log']) && empty($_POST['input_pass_log'])){
			//No existe el user en la DB
			$this->view->ShowLogin("El usuario o Contraseña estan vacios");
			die();
		}

			$user_log = $_POST['input_user_log'];
			$pass_log = $_POST['input_pass_log'];
		
			if(isset($user_log) && (isset($pass_log))){
				$insertUserDB = $this->model->insertUser($user_log,$pass_log);		
			}

			$userFromDB = $this->model->GetUser($user_log);

			if(isset($userFromDB) && $userFromDB){ //existe y es true.
					$this->authHelper->Login($userFromDB);
					header("Location:".BASE_URL."home");	
			}else{
				//No existe el user en la DB
				$this->view->ShowLogin("El usuario no existe");
			}	
			
			
	}


	public function VerifyUser() {
		if(empty($_POST['input_user']) && empty($_POST['input_pass'])){
			//No existe el user en la DB
			$this->view->ShowLogin("El usuario o Contraseña no existe");
			die();
		}else{
			$user = $_POST['input_user'];
			$pass = $_POST['input_pass'];
		}

		if(isset($user)){
			$userFromDB = $this->model->GetUser($user);
			
			if(isset($userFromDB) && $userFromDB){ //existe y es true.
				if(password_verify($pass, $userFromDB->password)){
					$this->authHelper->Login($userFromDB);

					if($userFromDB->rol == 'admin') {
						header("Location:".BASE_URL."homeAdmin");
					}else {
						header("Location:".BASE_URL."home");
					}

					
				}else{
					$this->view->ShowLogin("Contraseña incorrecta");
				}
			}else{
				//No existe el user en la DB
				$this->view->ShowLogin("El usuario no existe");
			}
		}
	}

	public function ShowLoguearme() {
		$this->view->ShowLoguearme();
	}


	public function Logout() {
        $this->authHelper->Logout();
        header('Location: ' . LOGIN);
    }


}
