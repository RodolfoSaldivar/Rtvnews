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
			foreach ($data["Media"] as $tipo => $medias)
			{
				foreach ($medias as $key => $media)
				{
					//----> Si en el post viene una de las notas guardadas, la quita del arreglo y se salta al siguiente for
					if (in_array($media["id"], $medias_guardadas))
					{
						unset($medias_guardadas[$media["id"]]);
						continue;
					}

					if (empty($media["desplegar"]) || empty($media["nombre"])) continue;

					$media["nota_id"] = $nota_id;
					$media["tipo"] = $tipo;
					$ruta = APP.'/medias';
					if ($tipo == 2 || $tipo == 3 || $tipo == 4)
					{
						switch ($tipo)
						{
							case 2: $ruta.= '/pdf/'; break;
							case 3: $ruta.= '/videos/'; break;
							case 4: $ruta.= '/voz/'; break;
						}
						$media["nombre"] = $this->Media->guardarEnCarpeta($media["nombre"], $ruta);
						$this->Media->create();
						$this->Media->save($media);
					}

					if ($tipo == 5)
					{
						$this->Media->create();
						$this->Media->save($media);
					}
				}
			}

			//----> Busca las medias que quedaron en el arreglo de las medias guardadas para despues borrar el archivo del folder y el registro de la BDD
			$medias_borrar = $this->Media->obtenerTodos(array('id' => $medias_guardadas));
			if ($medias_borrar)
			foreach ($medias_borrar as $key => $media)
			{
				switch ($media["Media"]["tipo"])
				{
					case 2: $tipo = 'pdf'; break;
					case 3: $tipo = 'videos'; break;
					case 4: $tipo = 'voz'; break;
				}
				$ruta_borrar = APP."/medias/$tipo/".$media["Media"]["nombre"];
				$file = new File($ruta_borrar);
				$file->delete();
				$this->Media->delete($media["Media"]["id"], false);
			}

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
			$nota["Nota"] = array('seccion' => 'nada', 'tipo' => 'nada', 'calificacion' => 'nada');

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
		$this->loadModel("Media");

		if (!$this->request->is('post')) return;

		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata, true);
		$condiciones = $this->descifrarTodo($data);

		$notas = $this->Nota->obtenerTodos($condiciones);
		if ($notas)
		foreach ($notas as $key => $nota)
			$notas[$key]["Medias"] = $this->Media->obtenerTodos(array('nota_id' => $nota["Nota"]["id"]));
		echo $this->hacerJson($notas);
	}


//=========================================================================

}
