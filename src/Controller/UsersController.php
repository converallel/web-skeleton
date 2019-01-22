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
        $this->get($id, ['finder' => 'basicInfo']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Username or password is incorrect'));
        }
    }

    public function signUp()
    {
        if ($this->request->is('post')) {

        }
    }
}
