<?php
App::uses('AppModel', 'Model');
/**
 * Sintesis Model
 *
 */
class Sintesis extends AppModel {

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
		'Media' => array(
			'className' => 'Media',
			'foreignKey' => 'sintesis_id',
			'dependent' => false
		)
	);


//=========================================================================


	public $useTable = 'sintesis';


//=========================================================================


}
