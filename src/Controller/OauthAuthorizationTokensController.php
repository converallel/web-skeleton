<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OauthAuthorizationTokens Controller
 *
 *
 * @method \App\Model\Entity\OauthAuthorizationToken[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OauthAuthorizationTokensController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $oauthAuthorizationTokens = $this->paginate($this->OauthAuthorizationTokens);

        $this->set(compact('oauthAuthorizationTokens'));
    }

    /**
     * View method
     *
     * @param string|null $id Oauth Authorization Token id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $oauthAuthorizationToken = $this->OauthAuthorizationTokens->get($id, [
            'contain' => []
        ]);

        $this->set('oauthAuthorizationToken', $oauthAuthorizationToken);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $oauthAuthorizationToken = $this->OauthAuthorizationTokens->newEntity();
        if ($this->request->is('post')) {
            $oauthAuthorizationToken = $this->OauthAuthorizationTokens->patchEntity($oauthAuthorizationToken, $this->request->getData());
            if ($this->OauthAuthorizationTokens->save($oauthAuthorizationToken)) {
                $this->Flash->success(__('The oauth authorization token has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The oauth authorization token could not be saved. Please, try again.'));
        }
        $this->set(compact('oauthAuthorizationToken'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Oauth Authorization Token id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $oauthAuthorizationToken = $this->OauthAuthorizationTokens->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $oauthAuthorizationToken = $this->OauthAuthorizationTokens->patchEntity($oauthAuthorizationToken, $this->request->getData());
            if ($this->OauthAuthorizationTokens->save($oauthAuthorizationToken)) {
                $this->Flash->success(__('The oauth authorization token has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The oauth authorization token could not be saved. Please, try again.'));
        }
        $this->set(compact('oauthAuthorizationToken'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Oauth Authorization Token id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $oauthAuthorizationToken = $this->OauthAuthorizationTokens->get($id);
        if ($this->OauthAuthorizationTokens->delete($oauthAuthorizationToken)) {
            $this->Flash->success(__('The oauth authorization token has been deleted.'));
        } else {
            $this->Flash->error(__('The oauth authorization token could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
