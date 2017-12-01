<?php
App::uses('AppController', 'Controller');
/**
 * Secciones Controller
 *
 */
class SeccionesController extends AppController {
	

//=========================================================================


	public function guardar()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;

		if (!$this->request->is('post')) return;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);
		$data = $this->descifrarTodo($data)["seccion"];

		$data["estatus"] = 1;

		$this->Seccione->save($data);
		$this->Session->setFlash('Seccion guardada exitosamente.');
	}
	

//=========================================================================


	public function index()
	{
		$secciones = $this->Seccione->obtenerTodos(array(), array(), array('estatus DESC', 'nombre'));
		// Para que funcione el switch hay que poner booleano en palabras
		if ($secciones)
		foreach ($secciones as $key => $user)
		{
			if ($user["Seccione"]["estatus"] == 0)
				$secciones[$key]["Seccione"]["estatus"] = false;
			if ($user["Seccione"]["estatus"] == 1)
				$secciones[$key]["Seccione"]["estatus"] = true;
		}

		$variables_php["Secciones"] = $secciones;

		$variables_php = $this->hacerJson($variables_php);
		$this->set("variables_php", $variables_php);
		$this->set("guardar_seccion", $this->pathPhp('guardar_seccion'));
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

		$this->Seccione->save($data);
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

		$seccion = $this->Seccione->unoConPadres($condiciones);
		echo $this->hacerJson($seccion);
	}


//=========================================================================

}
