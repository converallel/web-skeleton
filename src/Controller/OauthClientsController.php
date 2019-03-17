<?php

namespace Skeleton\Controller;

/**
 * OauthClients Controller
 *
 * @property \Skeleton\Model\Table\OauthClientsTable $OauthClients
 *
 * @method \Skeleton\Model\Entity\OauthClient[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OauthClientsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $oauthClients = $this->paginate($this->OauthClients);

        $this->set(compact('oauthClients'));
    }

    /**
     * View method
     *
     * @param string|null $id Oauth Client id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $oauthClient = $this->OauthClients->get($id, [
            'contain' => ['Users', 'OauthScopes', 'OauthAccessTokens', 'OauthAuthorizationCodes']
        ]);

        $this->set('oauthClient', $oauthClient);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $oauthClient = $this->OauthClients->newEntity();
        if ($this->request->is('post')) {
            $oauthClient = $this->OauthClients->patchEntity($oauthClient, $this->request->getData());
            if ($this->OauthClients->save($oauthClient)) {
                $this->Flash->success(__('The oauth client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The oauth client could not be saved. Please, try again.'));
        }
        $users = $this->OauthClients->Users->find('list', ['limit' => 200]);
        $oauthScopes = $this->OauthClients->OauthScopes->find('list', ['limit' => 200]);
        $this->set(compact('oauthClient', 'users', 'oauthScopes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Oauth Client id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $oauthClient = $this->OauthClients->get($id, [
            'contain' => ['OauthScopes']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $oauthClient = $this->OauthClients->patchEntity($oauthClient, $this->request->getData());
            if ($this->OauthClients->save($oauthClient)) {
                $this->Flash->success(__('The oauth client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The oauth client could not be saved. Please, try again.'));
        }
        $users = $this->OauthClients->Users->find('list', ['limit' => 200]);
        $oauthScopes = $this->OauthClients->OauthScopes->find('list', ['limit' => 200]);
        $this->set(compact('oauthClient', 'users', 'oauthScopes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Oauth Client id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $oauthClient = $this->OauthClients->get($id);
        if ($this->OauthClients->delete($oauthClient)) {
            $this->Flash->success(__('The oauth client has been deleted.'));
        } else {
            $this->Flash->error(__('The oauth client could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
