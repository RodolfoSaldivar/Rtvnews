<?php
App::uses('AppController', 'Controller');
/**
 * Notas Controller
 *
 */
class NotasController extends AppController {
	

//=========================================================================


	public function index()
	{
		$this->loadModel('Seccione');
		$this->loadModel('Cliente');

		$secciones = $this->Seccione->obtenerTodos();
		$clientes = $this->Cliente->obtenerTodos();

		$clientes_auto = array();
		if ($clientes)
		foreach ($clientes as $key => $cliente)
			$clientes_auto[$cliente["Cliente"]["nombre"]] = 0;

		$variables_php = array(
			'clientes_autocompletar' => $clientes_auto,
			'secciones' => $secciones
		);
		$variables_php = $this->hacerJson($variables_php);
		$this->set("variables_php", $variables_php);
		$this->set("preloader", $this->pathPhp('preloader'));
		$this->set("guardar_cliente", $this->pathPhp('guardar_cliente'));

		if (!$this->request->is('post')) return;

		$data = $this->request->data;
		var_dump($data);
	}
	

//=========================================================================


	public function agregar_media()
	{
		$this->layout = 'ajax';

		if (!$this->request->is('post')) return;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);
		$data = $this->descifrarTodo($data);
		switch ($data["tipo"])
		{
			case 2: $data["nombre"] = 'PDF'; break;
			case 3: $data["nombre"] = 'Video'; break;
			case 4: $data["nombre"] = 'Audio'; break;
			case 5: $data["nombre"] = 'Link'; break;
		}
		$this->set("data", $data);
	}


//=========================================================================

}
