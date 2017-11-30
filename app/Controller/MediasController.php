<?php
App::uses('AppController', 'Controller');
/**
 * Medias Controller
 *
 */
class MediasController extends AppController {
	

//=========================================================================


	public function guardar_ajax()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;

		if (!$this->request->is('post')) return;

		$file = $_FILES["file"];
		date_default_timezone_set('America/Mexico_City');

		$nombre_archivo = uniqid().date('YmdHis').$file["name"];
		$path = WWW_ROOT.'/img/logos/';

		if(!file_exists($path)) mkdir($path, 0777, true);

		move_uploaded_file($file['tmp_name'], $path.$nombre_archivo);

		$media_id = $this->Media->save(array(
			'nombre' => $nombre_archivo,
			'tipo' => 1
		))["Media"]["id"];

		echo $this->Media->cifrar($media_id);
	}


//=========================================================================

}
