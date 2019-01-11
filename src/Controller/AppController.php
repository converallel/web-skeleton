<?php

namespace Skeleton\Controller;

use Cake\Controller\Controller;
use Cake\Controller\Exception\SecurityException;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\Event;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Query;
use Cake\Routing\Router;
use Cake\Utility\Inflector;

/**
 * Class AppController
 * @package Skeleton\Controller
 *
 * @property \Skeleton\Model\Entity\User|null $currentUser
 * @property \Cake\ORM\Table $Table
 * @property boolean $usingApi
 * @property string entityName
 *
 * @property \Skeleton\Controller\Component\InfiniteScrollComponent $InfiniteScroll
 */
class AppController extends Controller
{

    /*
     * True use infinite scroll, false use pagination
     */
    protected $_infiniteScroll = true;

    /**
     * Settings for infiniteScroll.
     *
     * Used to pre-configure infiniteScroll preferences for the various
     * tables your controller will be infinite-scrolling.
     *
     * @var array
     * @see \Skeleton\Controller\Component\InfiniteScrollComponent
     */
    public $infiniteScroll = [];

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

        $acceptsContentTypes = $this->getRequest()->accepts();
        $this->usingApi = !empty(array_intersect(['application/json', 'application/xml'], $acceptsContentTypes))
            && !in_array('text/html', $acceptsContentTypes);
        $this->Table = $this->{$this->getName()};
        $this->entityName = Inflector::singularize(lcfirst($this->getName()));

        // load components
        if ($this->usingApi) {
//            $this->loadComponent('Auth', [
//                'authenticate' => ['JWT'],
//                'storage' => 'Memory',
//                'unauthorizedRedirect' => false,
//            ]);
        }

//        $this->loadComponent('Auth', [
//            'authenticate' => [
//                'OAuth2' => [
//                    'providers' => [
//                        'Native' => [
//                            'className' => '\Native\OAuth2\Client\Provider\Native',
//                            // all options defined here are passed to the provider's constructor
//                            'options' => [
//                                'clientId' => 'foo',
//                                'clientSecret' => 'bar',
//                            ],
//                            'mapFields' => [
//                                'username' => 'login', // maps the app's username to github's login
//                            ],
//                            // ... add here the usual AuthComponent configuration if needed like fields, etc.
//                        ],
//                    ]
//                ]
//            ]
//        ]);

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
//        $this->loadComponent('Security', ['blackHoleCallback' => 'forceSSL']);
        $this->loadComponent('Flash');

        $this->currentUser = \Cake\ORM\TableRegistry::getTableLocator()->get('Users')->get(1);
//        $this->current_user = $this->Auth->user();
        Configure::write('user_id', $this->currentUser->id);
    }

    //======================================================================
    // Default Functions
    //======================================================================

    public function beforeFilter(Event $event)
    {
//        $this->Security->requireSecure();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->load();
    }

    /**
     * View method
     *
     * @param string|null $id Entity id.
     * @return void
     */
    public function view($id = null)
    {
        $this->get($id);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->create();
    }

    /**
     * Edit method
     *
     * @param string|null $id Entity id.
     * @return void Redirects on successful edit, renders view otherwise.
     */
    public function edit($id = null)
    {
        $this->update($id);
    }

    /**
     * Delete method
     *
     * @param string|null $id Entity id.
     * @return void Redirects to index.
     */
    public function delete($id = null)
    {
        $this->remove($id);
    }

    //======================================================================
    // CRUD Functions
    //======================================================================

    /**
     * Index method
     *
     * @param array|Query $query
     * @param array $options
     * @return \Cake\Http\Response|null
     */
    public function load($query = [], $options = [])
    {
        if (is_array($query)) {
            $query = $this->Table->find('all', $query);
        }

        $entities = $this->_infiniteScroll ? $this->infiniteScroll($query, $options) : $this->paginate($query,
            $options);
        if ($this->usingApi) {
            return $this->setSerialized($entities);
        }
        $this->set(lcfirst($this->getName()), $entities);
    }

    /**
     * View method
     *
     * @param string|null $id Entity id.
     * @param array|Query $query
     * @param array $options
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When the user is not the authorized to view this entity.
     */
    public function get($id = null, $query = [], $options = [])
    {
        if ($query instanceof Query) {
            $entity = $query->where(["{$this->getName()}.id" => $id])->first();
            if (is_null($entity)) {
                throw new NotFoundException();
            }
        } else {
            $entity = $this->Table->get($id, $query);
        }

        if (!$entity->isViewableBy($this->currentUser)) {
            throw new ForbiddenException();
        }

        if ($this->usingApi) {
            return $this->setSerialized($entity);
        }

        $this->set($this->entityName, $entity);
    }

    /**
     * Add method
     *
     * @param array $options
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     * @throws \Cake\Http\Exception\ForbiddenException When the user is not the authorized to create this entity.
     */
    public function create($options = [])
    {
        $entity = $this->Table->newEntity();
        if ($this->getRequest()->is('post')) {
            $entity = $this->Table->patchEntity($entity, $this->getRequest()->getData(),
                $options['objectHydration'] ?? []);

            if (!$entity->isCreatableBy($this->currentUser)) {
                throw new ForbiddenException();
            }

            if ($this->Table->save($entity)) {
                if ($this->usingApi) {
                    return $this->setSerialized(['id' => $entity->id]);
                }
                $this->Flash->success(__("The $this->entityName has been saved."));

                return $this->redirect(['action' => 'index']);
            }

            $error_message = __("The $this->entityName could not be saved. Please, try again.");
            if ($this->usingApi) {
                return $this->setSerialized($error_message, 400);
            }
            $this->Flash->error($error_message);
        }

        $this->set($this->entityName, $entity);
        $this->setExtraViews($options['viewVars']);
    }

    public function addMany($options = [])
    {
        $entities = $this->Table->newEntities($this->getRequest()->getData());
        if ($this->getRequest()->is('post')) {
            foreach ($entities as $entity) {
                if (!$entity->isCreatableBy($this->currentUser)) {
                    throw new ForbiddenException();
                }
            }

            if ($this->Table->saveMany($entities)) {
                $ids = array_map(function ($entity) {
                    return ['id' => $entity->id];
                }, $entities);

                $name = $this->getName();
                if (count($ids) === 1) {
                    $ids = $ids[0];
                }

                if ($this->usingApi) {
                    return $this->setSerialized($ids);
                }
                $this->Flash->success(__("The {$this->getName()} has been saved."));

                return $this->redirect(['action' => 'index']);
            }

            $error_message = __("The {$this->getName()} could not be saved. Please, try again.");
            if ($this->usingApi) {
                return $this->setSerialized($error_message, 400);
            }

            $this->Flash->error($error_message);
        }

        $this->set($this->entityName, $entity);
        $this->setExtraViews($options['viewVars']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Entity id.
     * @param array $options
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\ForbiddenException When the user is not the authorized to edit this entity.
     */
    public function update($id = null, $options = [])
    {
        $entity = $this->Table->get($id);

        if (!$entity->isEditableBy($this->currentUser)) {
            throw new ForbiddenException();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $entity = $this->Table->patchEntity($entity, $this->getRequest()->getData(),
                $options['ObjectHydration'] ?? []);

            if ($this->Table->save($entity)) {
                if ($this->usingApi) {
                    return $this->setSerialized(204);
                }
                $this->Flash->success(__("The $this->entityName has been saved."));

                return $this->redirect(['action' => 'index']);
            }

            $error_message = __("The $this->entityName could not be saved. Please, try again.");
            if ($this->usingApi) {
                return $this->setSerialized($error_message, 400);
            }
            $this->Flash->error($error_message);
        }

        $this->set($this->entityName, $entity);
        $this->setExtraViews($options['viewVars']);
    }

    /**
     * Delete method
     *
     * @param array|string|null $id Entity id.
     * @param array $options options accepted by `Table::find()`.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Http\Exception\ForbiddenException When the user is not the authorized to delete this entity.
     */
    public function remove($id = null, $options = [])
    {
        $this->request->allowMethod(['post', 'delete']);

        if (is_array($id)) {
            $entity = $this->Table->find('all', $options)->where($id)->first();
            if (is_null($entity)) {
                throw new NotFoundException();
            }
        } else {
            $entity = $this->Table->get($id, $options);
        }

        if (!$entity->isDeletableBy($this->currentUser)) {
            throw new ForbiddenException();
        }

        if ($this->Table->delete($entity)) {
            if ($this->usingApi) {
                return $this->setSerialized(204);
            }
            $this->Flash->success(__("The $this->entityName has been deleted."));
        } else {
            $error_message = __("The $this->entityName could not be deleted. Please, try again.");
            if ($this->usingApi) {
                return $this->setSerialized($error_message, 400);
            }
            $this->Flash->error($error_message);
        }

        return $this->redirect(['action' => 'index']);
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
     * Serializes the response body, i.e. json/xml
     * @param array|int|string|EntityInterface|ResultSetInterface $data
     * @param int $status
     */
    public function setSerialized($data = [], $status = 200)
    {
        if (is_int($data) && 100 <= $data && $data < 600) {
            $status = $data;
            $data = [];
        } elseif (is_string($data)) {
            $data = ['message' => $data];
        } elseif ($data instanceof EntityInterface || $data instanceof ResultSetInterface) {
            $data = $data->toArray();
        } elseif (!$data) {
            $data = [];
        }

        $this->setResponse($this->getResponse()->withStatus($status));
        $this->set(array_merge($data, ['_serialize' => array_keys($data)]));
    }

    /**
     * `find()` the fields of the table and `set()` them .
     * @param array $viewVars e.g. ['tags', 'files' => ['contain' => 'Users'], ...]
     */
    public function setExtraViews($viewVars = [])
    {
        foreach ($viewVars as $field => $options) {
            if (is_int($field)) {
                $field = $options;
                $options = ['limit' => 10];
            }
            $this->set(lcfirst($field), $this->Table->{ucfirst($field)}->find('list', $options));
        }
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

    /**
     * Handles infiniteScroll of records in Table objects.
     *
     * Will load the referenced Table object, and have the InfiniteScrollComponent
     * scroll the query using the request date and settings defined in `$this->infiniteScroll`.
     *
     * This method will also make the InfiniteScrollHelper available in the view.
     *
     * @param \Cake\ORM\Table|string|\Cake\ORM\Query|null $object Table to infiniteScroll
     * (e.g: Table instance, 'TableName' or a Query object)
     * @param array $settings The settings/configuration used for infiniteScroll.
     * @return \Cake\ORM\ResultSet|\Cake\Datasource\ResultSetInterface Query results
     * @throws \RuntimeException When no compatible table object can be found.
     */
    public function infiniteScroll($object = null, array $settings = [])
    {
        if (is_object($object)) {
            $table = $object;
        }

        if (is_string($object) || $object === null) {
            $try = [$object, $this->modelClass];
            foreach ($try as $tableName) {
                if (empty($tableName)) {
                    continue;
                }
                $table = $this->loadModel($tableName);
                break;
            }
        }

        $this->loadComponent('Skeleton.InfiniteScroll');
        if (empty($table)) {
            throw new \RuntimeException('Unable to locate an object compatible with infiniteScroll.');
        }
        $settings += $this->infiniteScroll;

        return $this->InfiniteScroll->scroll($table, $settings);
    }
}
