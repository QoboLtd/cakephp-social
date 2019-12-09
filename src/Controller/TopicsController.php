<?php
namespace Qobo\Social\Controller;

use Qobo\Social\Controller\AppController;

/**
 * Topics Controller
 *
 * @property \Qobo\Social\Model\Table\TopicsTable $Topics
 *
 * @method \Qobo\Social\Model\Entity\Topic[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TopicsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $topics = $this->paginate($this->Topics);

        $this->set(compact('topics'));
    }

    /**
     * View method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id)
    {
        $topic = $this->Topics->get($id, [
            'contain' => ['Posts', 'Keywords'],
        ]);

        $this->set('topic', $topic);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $topic = $this->Topics->newEntity();
        $data = is_array($this->request->getData()) ? $this->request->getData() : [];
        if ($this->request->is('post')) {
            $topic = $this->Topics->patchEntity($topic, $data);
            if ($this->Topics->save($topic)) {
                $this->Flash->success((string)__('The topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The topic could not be saved. Please, try again.'));
        }
        $posts = $this->Topics->Posts->find('list', ['limit' => 200]);
        $this->set(compact('topic', 'posts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id)
    {
        $topic = $this->Topics->get($id, [
            'contain' => ['Posts'],
        ]);
        $data = is_array($this->request->getData()) ? $this->request->getData() : [];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $topic = $this->Topics->patchEntity($topic, $data);
            if ($this->Topics->save($topic)) {
                $this->Flash->success((string)__('The topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The topic could not be saved. Please, try again.'));
        }
        $posts = $this->Topics->Posts->find('list', ['limit' => 200]);
        $this->set(compact('topic', 'posts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $topic = $this->Topics->get($id);
        if ($this->Topics->delete($topic)) {
            $this->Flash->success((string)__('The topic has been deleted.'));
        } else {
            $this->Flash->error((string)__('The topic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
