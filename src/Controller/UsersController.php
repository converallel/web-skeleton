<?php

namespace Skeleton\Controller;

use Cake\ORM\TableRegistry;
use Cake\Validation\Validation;
use http\Exception\InvalidArgumentException;

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
        $data = $this->getRequest()->getData();

        if ($email = $data['email'] ?? null) {
            if (!Validation::email($email)) {
                throw new InvalidArgumentException('Invalid email address.');
            }
            $data['contacts'][] = [
                'user_id' => $this->currentUser->id,
                'contact' => $email,
                'type' => 'Email'
            ];
        }

        if ($phoneNumber = $data['phone_number'] ?? null) {
            if (!Validation::naturalNumber($phoneNumber)) {
                throw new InvalidArgumentException('Invalid phone number.');
            }
            $data['contacts'][] = [
                'user_id' => $this->currentUser->id,
                'contact' => $phoneNumber,
                'type' => 'Mobile'
            ];
        }

        $this->setRequest($this->getRequest()->withParsedBody($data));
        $this->Crud->add([], ['template' => 'Common/add']);
    }
}
