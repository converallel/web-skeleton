<?php

namespace Skeleton\Controller;

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
        $this->get($id, ['finder' => 'details']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                if ($this->Auth->authenticationProvider()->needsPasswordRehash()) {
                    $user = $this->Users->get($this->Auth->user('id'));
                    $user->password = $this->request->getData('password');
                    $this->Users->save($user);
                }
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Username or password is incorrect'));
            }
        }
    }
}
