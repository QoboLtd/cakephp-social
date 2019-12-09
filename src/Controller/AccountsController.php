<?php
namespace Qobo\Social\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Qobo\Social\Controller\AppController;
use Qobo\Social\Model\Entity\Account;
use RuntimeException;

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
            'contain' => ['Networks'],
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
            'contain' => ['Networks', 'Posts'],
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
        $data = is_array($this->request->getData()) ? $this->request->getData() : [];
        if ($this->request->is('post')) {
            $account = $this->Accounts->patchEntity($account, $data);
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
            'contain' => [],
        ]);
        $data = is_array($this->request->getData()) ? $this->request->getData() : [];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $account = $this->Accounts->patchEntity($account, $data);
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

    /**
     * Connect our own social network account.
     *
     * @param string $type Event name
     * @return \Cake\Http\Response|null
     */
    public function connect(string $type): ?Response
    {
        $eventManager = $this->getEventManager();
        $eventName = sprintf('Qobo/Social.connectAccount.%s', mb_strtolower($type));
        $listeners = $eventManager->listeners($eventName);
        if (empty($listeners)) {
            throw new NotFoundException();
        }

        $event = new Event($eventName, $this, ['request' => $this->getRequest()]);
        $eventManager->dispatch($event);
        if ($event->isStopped()) {
            throw new RuntimeException();
        }

        $result = $event->getResult();
        if ($result instanceof Response) {
            return $result;
        }
        if (!($result instanceof Account)) {
            throw new RuntimeException('Event must return an instance of Account model.');
        }

        return $this->connectAccount($result);
    }

    /**
     * Processes the result from {@link self::connect()} method and returns
     * the appropriate response.
     *
     * @param \Qobo\Social\Model\Entity\Account $result Result.
     * @return \Cake\Http\Response|null
     */
    protected function connectAccount(Account $result): ?Response
    {
        if (!$this->Accounts->save($result)) {
            $this->Flash->error((string)__('Could not connect account.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->success((string)__('The account has been saved.'));

        return $this->redirect(['action' => 'view', $result->get('id')]);
    }
}
