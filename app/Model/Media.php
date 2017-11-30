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
			'className' => 'Dirigido',
			'foreignKey' => 'media_id',
			'dependent' => false
		)
	);


//=========================================================================


	public $useTable = 'medias';


//=========================================================================

}
