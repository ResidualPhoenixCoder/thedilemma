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
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

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

    public $components = array('DebugKit.Toolbar', 'Session', 'Auth'
        => array(
            'loginAction' => array('controller' => 'dilemmas', 'action' => 'login', 'login'),
            'loginRedirect' =>
            array('controller' => 'lobby',
                'action' => 'lobby'),
            'logoutRedirect' => array(
                'controller' => 'dilemmas',
                'action' => 'index',
                'dilemma_splash'
            ),
            'authError' => 'The aliens are coming.',
            'autoRedirect' => false
        )
    );

    public function beforeFilter() {
        $this->Auth->allow('index');
        $this->Auth->autoRedirect = false;
    }

    public function index() {
        $this->layout = "dilemmas";

        if ($this->Auth->login()) {
            $this->redirect($this->Auth->redirect());
        }

        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }

        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }

        if (!empty($path[$count - 1])) {
            $title_for_layout = "The Dilemma | A game to drive you mad..."; //Inflector::humanize($path[$count - 1]);
        }

        $this->set(compact('page', 'title_for_layout'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

}
