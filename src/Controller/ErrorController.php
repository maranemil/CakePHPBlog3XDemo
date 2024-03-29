<?php /** @noinspection PhpMethodParametersCountMismatchInspection */
/** @noinspection PhpUnused */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedNamespaceInspection */

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.3.4
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Event\Event;
use Cake\Http\Response;
use Exception;

/**
 * Error Handling Controller
 * Controller used by ExceptionRenderer to render error responses.
 * @method viewBuilder()
 */
class ErrorController extends AppController
{
    /**
     * Initialization hook method.
     * @return void
     * @throws Exception
     */
    public function initialize()
    {
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
    }

    /**
     * beforeFilter callback.
     *
     * @param Event $event Event.
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
    }

    /**
     * beforeRender callback.
     *
     * @param Event $event Event.
     *
     * @return void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);

        $this->viewBuilder()->setTemplatePath('Error');
    }

    /**
     * afterFilter callback.
     *
     * @param Event $event Event.
     *
     * @return void
     */
    public function afterFilter(Event $event)
    {
    }
}
