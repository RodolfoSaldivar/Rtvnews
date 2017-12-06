<?php
App::uses('AppController', 'Controller');
/**
 * Notas Controller
 *
 */
class NotasController extends AppController {
	

//=========================================================================


	public function guardar($nota_id = 0)
	{
		$this->loadModel('Seccione');
		$this->loadModel('Cliente');
		$this->loadModel('Media');

		//----> Cuando se hace el post
		if ($this->request->is('post'))
		{
			$data = $this->request->data;
			$data = $this->descifrarTodo($data);
			// var_dump($data);
			date_default_timezone_set('America/Mexico_City');
			$data["Nota"]["fecha"] = date('Ymd');
			$data["Nota"]["estatus"] = 1;
			$nota_id = $this->Nota->save($data["Nota"])["Nota"]["id"];

			//----> Obtiene todas las medias guardadas de la nota
			$medias_guardadas = $this->Media->find('list', array(
				'conditions' => array('nota_id' => $nota_id),
				'fields' => 'id'
			));

			if (@$data["Media"])
				$this->Media->guardarBorrar($data["Media"], $medias_guardadas, 'nota_id', $nota_id);

			$this->Session->setFlash('Nota guardada exitosamente.');
			$this->redirect("/notas/guardar");
		}

		//----> Cuando hay get y edita
		if ($nota_id)
		{
			$nota_id = $this->descifrar($nota_id);
			$nota = $this->Nota->unoConPadres(array('Nota.id' => $nota_id));
			$medias = $this->Media->obtenerTodos(array('nota_id' => $nota_id));
			foreach ($medias as $key => $media)
				$nota["Medias"][$media["Media"]["id_c"]] = $media["Media"]["tipo"];
		}
		else
			$nota["Nota"] = array('seccione_id_c' => 'nada', 'tipo' => 'nada', 'calificacion' => 'nada');

		$secciones = $this->Seccione->obtenerTodos(array('estatus' => 1));
		$clientes = $this->Cliente->obtenerTodos(array('estatus' => 1));

		$clientes_auto = array();
		if ($clientes)
		foreach ($clientes as $key => $cliente)
			$clientes_auto[$cliente["Cliente"]["nombre"]] = 0;

		$variables_php = array(
			'clientes_autocompletar' => $clientes_auto,
			'secciones' => $secciones,
			'nota' => $nota
		);
		$variables_php = $this->hacerJson($variables_php);
		$this->set("variables_php", $variables_php);
		$this->set("preloader", $this->pathPhp('preloader'));
		$this->set("guardar_cliente", $this->pathPhp('guardar_cliente'));			
	}
	

//=========================================================================


	public function agregar_media()
	{
		$this->layout = 'ajax';
		$this->loadModel("Media");

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
		if ($data["id_c"] === 0) $data["disabled"] = 0;
		else
		{
			$data["disabled"] = 1;
			$media = $this->Media->obtener(array('id' => $this->descifrar($data["id_c"])))["Media"];
			$media["nombre"] = substr($media["nombre"], 14);
			$data["Media"] = $media;
		}
		$data["name"] = 'data[Media]['.$data["tipo"].']['.$data["acum"].']';
		$this->set("data", $data);
	}
	

//=========================================================================


	public function obtener()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->loadModel("Seccione");
		$this->loadModel("Media");

		if (!$this->request->is('post')) return;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);
		$condiciones = $this->descifrarTodo($data);

		$ultimo_nombre = '';
		$notas_mandar = array();
		$notas = $this->Nota->obtenerTodos($condiciones, array(), array('orden', 'seccione_id'));
		if ($notas)
		foreach ($notas as $key => $nota)
		{
			$nota["Medias"] = $this->Media->obtenerTodos(array('nota_id' => $nota["Nota"]["id"]));
			$seccion = $this->Seccione->obtener(array('id' => $nota["Nota"]["seccione_id"]));
			if ($seccion["Seccione"]["nombre"] != $ultimo_nombre)
			{
				$ultimo_nombre = $seccion["Seccione"]["nombre"];
				$notas_mandar[$ultimo_nombre]["Seccione"] = $seccion["Seccione"];
			}
			$notas_mandar[$ultimo_nombre]["Notas"][$nota["Nota"]["id_c"]] = $nota;
		}
		echo $this->hacerJson($notas_mandar);
	}


//=========================================================================

}
