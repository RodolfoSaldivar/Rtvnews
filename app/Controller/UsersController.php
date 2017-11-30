<?php
App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * Users Controller
 *
 */
class UsersController extends AppController {
	

//=========================================================================


	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('login', 'logout');
	}
	

//=========================================================================


	public function login()
	{
		$this->layout = "sin_formato";

		if ($this->Session->check('Auth')) $this->redirect('/users/logout');

		if (!$this->request->is('post')) return;

	    if (!$this->Auth->login())
		{
			$this->Session->setFlash('Correo o contraseña incorrecta.');
			return;
		}
        
        if ($this->Session->read("Auth.User.estatus") == "0")
		{
			$this->Session->setFlash('Usuario desactivado.');
			$this->Auth->logout();
			return;
		}

		$this->redirect("/users");
	}
	

//=========================================================================


	public function logout()
	{
		$this->Session->destroy();
	    $this->redirect($this->Auth->logout());
	}


//=========================================================================


	public function checar_username()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;

		if (!$this->request->is('post')) return 0;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);

		$nuevo_user = $data["nuevo_user"];
		$repetido = $this->User->find('count', array(
			'conditions' => array('username' => $nuevo_user)
		));
		if (@$data["actual_user"]) {
			$actual_user = $data["actual_user"];
			if ($nuevo_user == $actual_user) $repetido--;
		}
		if ($repetido > 0) {
			$username = '';
			$placeholder = "Ya esta en uso";
		}
		else {
			$username = $nuevo_user;
			$placeholder = '';
		}
		echo $this->hacerJson(array(
			'username' => $username,
			'placeholder' => $placeholder
		));
	}
	

//=========================================================================


	public function guardar($id = 0)
	{
		$this->layout = 'ajax';
		$this->autoRender = false;

		if (!$this->request->is('post')) return;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);
		$data = $this->descifrarTodo($data)["user"];

		$data["token"] = $this->token();
		$data["estatus"] = 1;

		if ($data["id"])
		{
			$contra_bdd = $this->User->find('first', array(
				'conditions' => array('id' => $data["id"]),
				'fields' => array('password')
			))["User"]["password"];

			if ($contra_bdd == $data["password"]) unset($data["password"]);
		}
			
		$this->User->save($data);
		$this->Session->setFlash('Usuario guardado exitosamente.');
	}
	

//=========================================================================


	public function index()
	{
		$users = $this->User->obtenerTodos(array(), array(), array('estatus DESC', 'tipo', 'nombre'));

		// Para que funcione el switch hay que poner booleano en palabras
		foreach ($users as $key => $user)
		{
			if ($user["User"]["tipo"] == 1)
				$users[$key]["User"]["tipo"] = "Administrador";
			if ($user["User"]["tipo"] == 2)
				$users[$key]["User"]["tipo"] = "Usuario";
			if ($user["User"]["estatus"] == 0)
				$users[$key]["User"]["estatus"] = false;
			if ($user["User"]["estatus"] == 1)
				$users[$key]["User"]["estatus"] = true;
		}

		$variables_php["Users"] = $users;

		$variables_php = $this->hacerJson($variables_php);
		$this->set("variables_php", $variables_php);
		$this->set("guardar_usuario", $this->pathPhp('guardar_usuario'));
	}
	

//=========================================================================


	public function actualizar_estatus()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;

		if (!$this->request->is('post')) return 0;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);
		$data = $this->descifrarTodo($data);

		if ($data["estatus"]) $data["estatus"] = 1;
		else $data["estatus"] = 0;

		$this->User->save($data);
	}
	

//=========================================================================


	public function obtener()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;

		if (!$this->request->is('post')) return 0;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);
		$condiciones = $this->descifrarTodo($data);

		$usuario = $this->User->find('first', array('conditions' => $condiciones));
		$usuario["User"]["id_c"] = $this->User->cifrar($usuario["User"]["id"]);
		echo $this->hacerJson($usuario);
	}


//=========================================================================

}
