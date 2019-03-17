<?php

namespace Skeleton\Controller;


/**
 * OauthAccessTokens Controller
 *
 * @property \Skeleton\Model\Table\OauthAccessTokensTable $OauthAccessTokens
 *
 * @method \Skeleton\Model\Entity\OauthAccessToken[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OauthAccessTokensController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'OauthClients']
        ];
        $oauthAccessTokens = $this->paginate($this->OauthAccessTokens);

        $this->set(compact('oauthAccessTokens'));
    }

    /**
     * View method
     *
     * @param string|null $id Oauth Access Token id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $oauthAccessToken = $this->OauthAccessTokens->get($id, [
            'contain' => ['Users', 'OauthClients', 'OauthScopes', 'OauthRefreshTokens']
        ]);

        $this->set('oauthAccessToken', $oauthAccessToken);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $oauthAccessToken = $this->OauthAccessTokens->newEntity();
        if ($this->request->is('post')) {
            $oauthAccessToken = $this->OauthAccessTokens->patchEntity($oauthAccessToken, $this->request->getData());
            if ($this->OauthAccessTokens->save($oauthAccessToken)) {
                $this->Flash->success(__('The oauth access token has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The oauth access token could not be saved. Please, try again.'));
        }
        $users = $this->OauthAccessTokens->Users->find('list', ['limit' => 200]);
        $oauthClients = $this->OauthAccessTokens->OauthClients->find('list', ['limit' => 200]);
        $oauthScopes = $this->OauthAccessTokens->OauthScopes->find('list', ['limit' => 200]);
        $this->set(compact('oauthAccessToken', 'users', 'oauthClients', 'oauthScopes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Oauth Access Token id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $oauthAccessToken = $this->OauthAccessTokens->get($id, [
            'contain' => ['OauthScopes']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $oauthAccessToken = $this->OauthAccessTokens->patchEntity($oauthAccessToken, $this->request->getData());
            if ($this->OauthAccessTokens->save($oauthAccessToken)) {
                $this->Flash->success(__('The oauth access token has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The oauth access token could not be saved. Please, try again.'));
        }
        $users = $this->OauthAccessTokens->Users->find('list', ['limit' => 200]);
        $oauthClients = $this->OauthAccessTokens->OauthClients->find('list', ['limit' => 200]);
        $oauthScopes = $this->OauthAccessTokens->OauthScopes->find('list', ['limit' => 200]);
        $this->set(compact('oauthAccessToken', 'users', 'oauthClients', 'oauthScopes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Oauth Access Token id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $oauthAccessToken = $this->OauthAccessTokens->get($id);
        if ($this->OauthAccessTokens->delete($oauthAccessToken)) {
            $this->Flash->success(__('The oauth access token has been deleted.'));
        } else {
            $this->Flash->error(__('The oauth access token could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
