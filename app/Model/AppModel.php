<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {


//=========================================================================


	var $useDbConfig = 'default';

	public $recursive = -1;


//=========================================================================


	public function cifrar($id)
	{
		$id_encriptada = base64_encode(base64_encode(base64_encode($id)));
		$id_encriptada = substr($id_encriptada, 0, -1);

		return $id_encriptada;
	}


//=========================================================================


    public function cifrarTodo($arreglo = 0)
    {
        if (!is_array($arreglo))
            return $arreglo;

        foreach ($arreglo as $atributo => $valor)
        {
            if (is_array($valor))
                $arreglo[$atributo] = $this->cifrarTodo($valor);

            if (
                substr($atributo, -3) == "_id" ||
                strval($atributo) == "id"
            )
            {
                $arreglo[$atributo."_c"] = $this->cifrar($valor);
            }
        }

        return $arreglo;
    }


//=========================================================================


	public function obtener($condiciones = array(), $campos = array(), $orden = array())
	{
		$result = $this->find('first', array(
			'conditions' => $condiciones,
			'fields' => $campos,
			'order' => $orden
		));

		if(!$result)
			return 0;

		unset($result["User"]["password"]);

		return $this->cifrarTodo($result);
	}


//=========================================================================


	public function obtenerTodos($condiciones = array(), $campos = array(), $orden = array())
	{
		$result = $this->find('all', array(
			'conditions' => $condiciones,
			'fields' => $campos,
			'order' => $orden
		));

		if(!$result)
			return 0;

		foreach ($result as $key => $value)
			unset($value["User"]["password"]);

		return $this->cifrarTodo($result);
	}


//=========================================================================


	public function unoConPadres($condiciones = array(), $campos = array(), $orden = array())
	{
		$result = $this->find('first', array(
			'recursive' => 0,
			'conditions' => $condiciones,
			'fields' => $campos,
			'order' => $orden
		));

		if(!$result)
			return 0;

		unset($result["User"]["password"]);

		return $this->cifrarTodo($result);
	}


//=========================================================================


	public function todosConPadres($condiciones = array(), $campos = array(), $orden = array())
	{
		$result = $this->find('all', array(
			'recursive' => 0,
			'conditions' => $condiciones,
			'fields' => $campos,
			'order' => $orden
		));

		if(!$result)
			return 0;

		foreach ($result as $key => $value)
			unset($value["User"]["password"]);

		return $this->cifrarTodo($result);
	}


//=========================================================================


	public function obtenerUltimo($condiciones = array(), $campos = array())
	{
		$result = $this->find('first', array(
			'conditions' => $condiciones,
			'order' => array('id DESC'),
			'fields' => $campos
		));

		if(!$result)
			return 0;

		unset($result["User"]["password"]);

		return $this->cifrarTodo($result);
	}


//=========================================================================

}
