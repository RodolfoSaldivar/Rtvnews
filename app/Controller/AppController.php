<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {


//=========================================================================


    public $components = array(
        'Session',
        'Flash',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'loginRedirect' => array(
                'controller' => 'notas',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish'
                )
            ),
            'authorize' => array('Controller')
        )
    );


//=========================================================================


    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['tipo']) && $user['tipo'] === 1){
            return true;
        }

        // Default deny
        //return false;
        return true;
    }


//=========================================================================


    public function beforeFilter() {
        $this->Auth->allow('');
        //$this->Auth->allow();
    }


//=========================================================================


	public function descifrar($id)
	{
		$id = $id."=";
		$id_desencriptada =	base64_decode(base64_decode(base64_decode($id)));

		return $id_desencriptada;
	}


//=========================================================================


    public function regex()
    {
        return '/[^a-z_\ñáéíóú\ÑÁÉÍÓÚ\-0-9\ \/\$\.\;\:\,\_\-\@\!\#\%\&\(\)\?\¿\¡\{\}\+\*\<\>\=]/i';
    }


//=========================================================================


	public function token()
	{
		$token = substr(
				str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20
			) .
			substr(
				str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20
			);
		return $token;
	}


//=========================================================================


    public function descifrarTodo($arreglo = 0)
    {
        if (!is_array($arreglo))
            return $arreglo;

        foreach ($arreglo as $atributo => $valor)
        {
            if (is_array($valor))
                $arreglo[$atributo] = $this->descifrarTodo($valor);

            if (
                substr($atributo, -3) == "_id" ||
                substr($atributo, -3) == ".id" ||
                strval($atributo) == "id"
            )
            {
                $arreglo[$atributo] = $this->descifrar($valor);
            }
        }

        return $arreglo;
    }


//=========================================================================


    public function quitarIds($arreglo = 0)
    {
        if (!is_array($arreglo))
            return $arreglo;

        foreach ($arreglo as $atributo => $valor)
        {
            if (is_array($valor))
                $arreglo[$atributo] = $this->quitarIds($valor);

            if (
                substr($atributo, -3) == "_id" ||
                strval($atributo) == "id"
            )
                unset($arreglo[$atributo]);
        }

        return $arreglo;
    }


//=========================================================================


    public function hacerJson($arreglo = 0)
    {
        $arreglo = $this->quitarIds($arreglo);
        $arreglo = json_encode($arreglo);
        return $arreglo;
    }


//=========================================================================


    public function pathPhp($archivo)
    {
        return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER["HTTP_HOST"]."/php/$archivo.php";
    }


//=========================================================================


}
