<?php /** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedNamespaceInspection */

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Http\Response;
use Exception;

/**
 * Application Controller
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 * @property $Auth
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 * @method loadComponent(string $string)
 * @method beforeRender(Event $event)
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     * Use this method to add common initialization code like loading components.
     * e.g. `$this->loadComponent('Security');`
     * @return void
     * @throws Exception
     */
    public function initialize()
    {
        /*
         parent::initialize();
         $this->loadComponent('RequestHandler', [
             'enableBeforeRedirect' => false,
         ]);
         $this->loadComponent('Flash');
        */
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginRedirect'  => [
                'controller' => 'Articles',
                'action'     => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action'     => 'display',
                'home'
            ]
        ]);
    }

    /**
     * @param Event $event
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'view', 'display']);
    }

    /**
     * @param $user
     *
     * @return bool
     */
    public function isAuthorized($user)
    {
        // Admin can access every action
        return isset($user['role']) && $user['role'] === 'admin';
    }


    /*
     * Enable the following component for recommended CakePHP security settings.
     * see https://book.cakephp.org/3.0/en/controllers/components/security.html
     */
    //$this->loadComponent('Security');

}
