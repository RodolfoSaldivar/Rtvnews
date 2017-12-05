<?php
App::uses('AppController', 'Controller');
/**
 * Medias Controller
 *
 */
class MediasController extends AppController {
	

//=========================================================================


	public function guardar_logo()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;

		if (!$this->request->is('post')) return;

		$file = $_FILES["file"];

		$nombre_archivo = $this->Media->guardarEnCarpeta($file, WWW_ROOT.'/img/logos/');

		$media_id = $this->Media->save(array(
			'nombre' => $nombre_archivo,
			'tipo' => 1
		))["Media"]["id"];

		echo $this->Media->cifrar($media_id);
	}
	

//=========================================================================


	public function ver()
	{
		$filename = "20171204183717La_ardilla_dramatica(youtube.com).mp4";
        $name = explode('.', strrev($filename), 2);
        $this->viewClass = 'Media';

        $params = array(
            'id'        => $filename,
            'name'      => strrev($name[1]),
            'download'  => 0,
            'extension' => strrev($name[0]),
            'path'      => APP . 'medias\videos' . DS
        );

        $this->set($params);
	}


//=========================================================================

}
