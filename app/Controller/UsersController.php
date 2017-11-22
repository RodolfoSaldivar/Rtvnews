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
		if ($this->request->is('post'))
		{
			$data = $this->descifrarTodo($this->request->data);

			$data["User"]["token"] = $this->token();
			$data["User"]["estatus"] = 1;

			if ($data["User"]["id"])
			{
				$contra_bdd = $this->User->find('first', array(
					'conditions' => array('id' => $data["User"]["id"]),
					'fields' => array('password')
				))["User"]["password"];

				if ($contra_bdd == $data["User"]["password"])
					unset($data["User"]["password"]);
			}
				
			$this->User->save($data);
			$this->redirect("/users");
		}

		if ($id)
		{
			$user = $this->User->obtener(array('id' => $this->descifrar($id)));
			$user["User"]["password"] = $this->User->find('first', array(
				'conditions' => array('id' => $this->descifrar($id)),
				'fields' => array('password')
			))["User"]["password"];
			$variables_php = $user;
		}
		else
			$variables_php["User"] = array('tipo' => 'nada');

		$variables_php = $this->hacerJson($variables_php);
		$this->set("variables_php", $variables_php);
	}
	

//=========================================================================


	public function index()
	{
		$users = $this->User->obtenerTodos(array(), array(), array('estatus DESC'));

		foreach ($users as $key => $user)
		{
			if ($user["User"]["tipo"] == 1)
				$users[$key]["User"]["tipo"] = "Administrador";
			if ($user["User"]["tipo"] == 2)
				$users[$key]["User"]["tipo"] = "Cliente";
			if ($user["User"]["estatus"] == 0)
				$users[$key]["User"]["estatus"] = false;
			if ($user["User"]["estatus"] == 1)
				$users[$key]["User"]["estatus"] = true;
		}

		$variables_php["Users"] = $users;

		$variables_php = $this->hacerJson($variables_php);
		$this->set("variables_php", $variables_php);
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

}
