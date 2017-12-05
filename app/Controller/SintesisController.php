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
		$this->loadModel('Seccione');
		$this->loadModel('Cliente');
		$this->loadModel('Media');

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

}
