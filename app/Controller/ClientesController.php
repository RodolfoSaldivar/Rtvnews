<?php
App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * Clientes Controller
 *
 */
class ClientesController extends AppController {
	

//=========================================================================


	public function guardar($id = 0)
	{
		$this->layout = 'ajax';
		$this->autoRender = false;

		if (!$this->request->is('post')) return;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);
		$data = $this->descifrarTodo($data)["cliente"];

		$data["estatus"] = 1;
echo json_encode($data);
		// $this->Cliente->save($data);
		// $this->Session->setFlash('Usuario guardado exitosamente.');
	}
	

//=========================================================================


	public function index()
	{
		$clientes = $this->Cliente->obtenerTodos(array(), array(), array('estatus DESC', 'nombre'));

		// Para que funcione el switch hay que poner booleano en palabras
		foreach ($clientes as $key => $user)
		{
			if ($user["Cliente"]["estatus"] == 0)
				$clientes[$key]["Cliente"]["estatus"] = false;
			if ($user["Cliente"]["estatus"] == 1)
				$clientes[$key]["Cliente"]["estatus"] = true;
		}

		$variables_php["Clientes"] = $clientes;

		$variables_php = $this->hacerJson($variables_php);
		$this->set("variables_php", $variables_php);
		$this->set("guardar_cliente", $this->pathPhp('guardar_cliente'));
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

		$this->Cliente->save($data);
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
