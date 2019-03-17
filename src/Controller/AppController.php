<?php

namespace Skeleton\Controller;

use Cake\Controller\Controller;
use Cake\Controller\Exception\SecurityException;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Class AppController
 * @package Skeleton\Controller
 *
 * @property \Skeleton\Controller\Component\CrudComponent $Crud
 * @property \Skeleton\Controller\Component\InfiniteScrollComponent $InfiniteScroll
 */
class AppController extends Controller
{

    /**
     * Settings for infiniteScroll.
     *
     * Used to pre-configure infiniteScroll preferences for the various
     * tables your controller will be infinite-scrolling.
     *
     * @var array
     * @see \Skeleton\Controller\Component\InfiniteScrollComponent
     */
//    public $infiniteScroll = [];

    /**
     * The current identified user.
     * @var \Skeleton\Model\Entity\User|null
     */
    public $currentUser = null;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Skeleton.Crud', [
            //'infiniteScroll' => []
        ]);
        if (!Configure::read('debug')) {
            $this->loadComponent('Security', ['blackHoleCallback' => 'forceSSL']);
        }
    }

    //======================================================================
    // Lifecycle Functions
    //======================================================================

    public function beforeFilter(Event $event)
    {
        if (!Configure::read('debug')) {
            $this->Security->requireSecure();
        }
    }

    //======================================================================
    // Utility Functions
    //======================================================================

    /**
     * @param string $error
     * @param SecurityException|null $exception
     * @return \Cake\Http\Response|null
     */
    public function forceSSL($error = '', SecurityException $exception = null)
    {
        if ($exception instanceof SecurityException && $exception->getType() === 'secure') {
            return $this->redirect('https://' . env('SERVER_NAME') . Router::url($this->request->getRequestTarget()));
        }

        throw $exception;
    }

    /**
     * Incorporates the routing parameters into the request body if they exist
     * @param array|string $params
     */
    public function incorporateRoutingParams(...$params)
    {
        $body = $this->getRequest()->getParsedBody();
        foreach ($params as $param) {
            if ($value = $this->getRequest()->getParam($param)) {
                $body[$param] = $value;
            }
        }
        $this->setRequest($this->getRequest()->withParsedBody($body));
    }
}
