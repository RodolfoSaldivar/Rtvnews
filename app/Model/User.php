<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 */
class User extends AppModel {

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	// public $belongsTo = array(
	// 	'CatalogoNivele' => array(
	// 		'className' => 'CatalogoNivele',
	// 		'foreignKey' => 'cat_niv_id'
	// 	)
	// );

/**
 * hasMany associations
 *
 * @var array
 */
	// public $hasMany = array(
	// 	'Dirigido' => array(
	// 		'className' => 'Dirigido',
	// 		'foreignKey' => 'contacto_id',
	// 		'dependent' => false
	// 	)
	// );

//=========================================================================


	public function beforeSave($options = array())
	{
	    if (isset($this->data[$this->alias]['password'])) {
	        $passwordHasher = new BlowfishPasswordHasher();
	        $this->data[$this->alias]['password'] = $passwordHasher->hash(
	            $this->data[$this->alias]['password']
	        );
	    }
	    return true;
	}


//=========================================================================


}
