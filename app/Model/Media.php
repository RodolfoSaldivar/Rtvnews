<?php
App::uses('AppModel', 'Model');
/**
 * Media Model
 *
 */
class Media extends AppModel {

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Nota' => array(
			'className' => 'Nota',
			'foreignKey' => 'nota_id'
		),
		'Sintesis' => array(
			'className' => 'Sintesis',
			'foreignKey' => 'sintesis_id'
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'media_id',
			'dependent' => false
		)
	);


//=========================================================================


	public $useTable = 'medias';


//=========================================================================


	public function guardarEnCarpeta($file, $ruta)
	{
		date_default_timezone_set('America/Mexico_City');
		$nombre_archivo = date('YmdHis').$file["name"];
		if(!file_exists($ruta)) mkdir($ruta, 0777, true);
		move_uploaded_file($file['tmp_name'], $ruta.$nombre_archivo);
		return $nombre_archivo;
	}


//=========================================================================


	public function guardarBorrar($data_medias, $medias_guardadas, $destino, $destino_id)
	{
		foreach ($data_medias as $tipo => $medias)
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

				$media[$destino] = $destino_id;
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
					$media["nombre"] = $this->guardarEnCarpeta($media["nombre"], $ruta);
					$this->create();
					$this->save($media);
				}

				if ($tipo == 5)
				{
					$this->create();
					$this->save($media);
				}
			}
		}

		//----> Busca las medias que quedaron en el arreglo de las medias guardadas para despues borrar el archivo del folder y el registro de la BDD
		$medias_borrar = $this->obtenerTodos(array('id' => $medias_guardadas));
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
			$this->delete($media["Media"]["id"], false);
		}
	}


//=========================================================================

}
