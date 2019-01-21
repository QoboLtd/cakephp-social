<?php
namespace Qobo\Social\Controller;

use Qobo\Social\Controller\AppController;

/**
 * Accounts Controller
 *
 * @property \Qobo\Social\Model\Table\AccountsTable $Accounts
 *
 * @method \Qobo\Social\Model\Entity\Account[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccountsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Networks']
        ];
        $accounts = $this->paginate($this->Accounts);

        $this->set(compact('accounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id)
    {
        $account = $this->Accounts->get($id, [
            'contain' => ['Networks', 'Posts']
        ]);

        $this->set('account', $account);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $account = $this->Accounts->newEntity();
        if ($this->request->is('post')) {
            $account = $this->Accounts->patchEntity($account, $this->request->getData());
            if ($this->Accounts->save($account)) {
                $this->Flash->success((string)__('The account has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The account could not be saved. Please, try again.'));
        }
        $networks = $this->Accounts->Networks->find('list', ['limit' => 200]);
        $this->set(compact('account', 'networks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id)
    {
        $account = $this->Accounts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $account = $this->Accounts->patchEntity($account, $this->request->getData());
            if ($this->Accounts->save($account)) {
                $this->Flash->success((string)__('The account has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The account could not be saved. Please, try again.'));
        }
        $networks = $this->Accounts->Networks->find('list', ['limit' => 200]);
        $this->set(compact('account', 'networks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $account = $this->Accounts->get($id);
        if ($this->Accounts->delete($account)) {
            $this->Flash->success((string)__('The account has been deleted.'));
        } else {
            $this->Flash->error((string)__('The account could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
