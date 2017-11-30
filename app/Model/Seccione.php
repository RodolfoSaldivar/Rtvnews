<?php
App::uses('AppModel', 'Model');
/**
 * Seccione Model
 *
 */
class Seccione extends AppModel {

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	// public $belongsTo = array(
	// 	'Media' => array(
	// 		'className' => 'Media',
	// 		'foreignKey' => 'media_id'
	// 	)
	// );

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Nota' => array(
			'className' => 'Nota',
			'foreignKey' => 'seccione_id',
			'dependent' => false
		)
	);


//=========================================================================


}
