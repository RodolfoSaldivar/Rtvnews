<?php
App::uses('AppController', 'Controller');
/**
 * Clientes Controller
 *
 */
class ClientesController extends AppController {
	

//=========================================================================


	public function guardar()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;

		if (!$this->request->is('post')) return;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);
		$data = $this->descifrarTodo($data)["cliente"];

		$data["estatus"] = 1;

		//----> Borra la imagen de la carpeta si es que se edita
		if ($data["id"])
		{
			$media_nombre = $this->Cliente->unoConPadres(array('Cliente.id' => $data["id"]))["Media"]["nombre"];
			$ruta_borrar = WWW_ROOT."/img/logos/$media_nombre";
			$file = new File($ruta_borrar);
			$file->delete();
		}

		$this->Cliente->save($data);
		$this->Session->setFlash('Cliente guardado exitosamente.');
	}
	

//=========================================================================


	public function index()
	{
		$clientes = $this->Cliente->todosConPadres(array(), array(), array('Cliente.estatus DESC', 'Cliente.nombre'));
		// Para que funcione el switch hay que poner booleano en palabras
		if ($clientes)
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

		if (!$this->request->is('post')) return;

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

		if (!$this->request->is('post')) return;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);
		$condiciones = $this->descifrarTodo($data);

		$cliente = $this->Cliente->unoConPadres($condiciones);
		echo $this->hacerJson($cliente);
	}


//=========================================================================

}
