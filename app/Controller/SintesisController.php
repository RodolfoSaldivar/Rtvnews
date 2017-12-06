<?php
App::uses('AppController', 'Controller');
/**
 * Sintesis Controller
 *
 */
class SintesisController extends AppController {
	

//=========================================================================


	public function index()
	{
		$this->loadModel('Sintesis');
		$this->loadModel('Seccione');
		$this->loadModel('Cliente');
		$this->loadModel('Media');

		//----> Cuando se hace el post
		if ($this->request->is('post'))
		{
			$data = $this->request->data;
			$data = $this->descifrarTodo($data);
			var_dump($data);
			echo('<br><br>');

			date_default_timezone_set('America/Mexico_City');
			$fecha = date('Ymd');

			$sintesis = $this->Sintesis->obtener(array(), array(), array('id DESC'));
			if (!$sintesis) $sintesis = $this->Sintesis->save(array('fecha' => $fecha));
			if ($sintesis["Sintesis"]["fecha"] != $fecha) $sintesis = $this->Sintesis->save(array('fecha' => $fecha));
			$sintesis_id = $sintesis["Sintesis"]["id"];
		}

		$secciones = $this->Seccione->obtenerTodos(array('estatus' => 1));
		$clientes = $this->Cliente->obtenerTodos(array('estatus' => 1));

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
	}
	

//=========================================================================


	public function obtener()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->loadModel("Sintesis");
		$this->loadModel("Media");

		if (!$this->request->is('post')) return;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);
		$fecha = $this->descifrarTodo($data)["fecha"];

		$sintesis = $this->Sintesis->obtener(array('fecha' => $fecha));
		if (!$sintesis) return 0;

		$medias = $this->Media->obtenerTodos(array('sintesis_id' => $sintesis["Sintesis"]["id"]));

		echo $this->hacerJson($medias);
	}


//=========================================================================

}
