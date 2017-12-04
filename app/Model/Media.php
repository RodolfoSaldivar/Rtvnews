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

}
