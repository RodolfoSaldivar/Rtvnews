<?php
App::uses('AppModel', 'Model');
/**
 * Nota Model
 *
 */
class Nota extends AppModel {

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Seccione' => array(
			'className' => 'Seccione',
			'foreignKey' => 'seccione_id'
		),
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'cliente_id'
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Medias' => array(
			'className' => 'Medias',
			'foreignKey' => 'nota_id',
			'dependent' => false
		)
	);


//=========================================================================

}
