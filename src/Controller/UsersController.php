<?php

namespace Skeleton\Controller;

use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \Skeleton\Model\Table\UsersTable $Users
 *
 * @method \Skeleton\Model\Entity\User[]
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
//        $this->Auth->allow(['add', 'login']);
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'finder' => 'details',
            'contain' => ['AccessTokens', 'AuthorizationCodes', 'Clients', 'Contacts']
        ]);
        $this->Crud->view($user);
    }

    public function login()
    {
        $request = $this->getRequest();
        if ($request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                if ($this->Auth->authenticationProvider()->needsPasswordRehash()) {
                    $user = $this->Users->get($this->Auth->user('id'));
                    $user->password = $request->getData('password');
                    $this->Users->save($user);
                }

                $browser = $request->getEnv('HTTP_USER_AGENT');
                $ip_address = $request->clientIp();
                $device_id = $request->getData('device_id');

                $logins = TableRegistry::getTableLocator()->get('Skeleton.Logins');
                $login = $logins->newEntity(compact('browser', 'ip_address', 'device_id'));

                $logins->save($login);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Username or password is incorrect'));
        }
    }

    public function signUp()
    {
        $this->Crud->add([], ['template' => 'Common/add']);
    }
}
