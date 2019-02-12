<?php
namespace Qobo\Social\Controller;

use Cake\Core\Configure;
use Qobo\Social\Controller\AppController;

/**
 * Posts Controller
 *
 * @property \Qobo\Social\Model\Table\PostsTable $Posts
 *
 * @method \Qobo\Social\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Accounts', 'LatestPostInteractions']
        ];
        $posts = $this->paginate($this->Posts);

        $this->set(compact('posts'));
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id)
    {
        $post = $this->Posts->get($id, [
            'contain' => ['Accounts', 'Topics', 'LatestPostInteractions']
        ]);

        $this->set('post', $post);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $post = $this->Posts->newEntity();
        $data = is_array($this->request->getData()) ? $this->request->getData() : [];
        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $data, ['validate' => 'publish']);
            if ($this->Posts->save($post)) {
                $this->Flash->success((string)__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The post could not be saved. Please, try again.'));
        }
        $accounts = $this->Posts->Accounts->find('ours')->find('list', ['limit' => 200]);
        $topics = $this->Posts->Topics->find('list', ['limit' => 200]);
        $this->set(compact('post', 'accounts', 'topics'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id)
    {
        $post = $this->Posts->get($id, [
            'contain' => ['Topics']
        ]);
        $data = is_array($this->request->getData()) ? $this->request->getData() : [];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $data);
            if ($this->Posts->save($post)) {
                $this->Flash->success((string)__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The post could not be saved. Please, try again.'));
        }
        $accounts = $this->Posts->Accounts->find('list', ['limit' => 200]);
        $topics = $this->Posts->Topics->find('list', ['limit' => 200]);
        $this->set(compact('post', 'accounts', 'topics'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        if ($this->Posts->delete($post)) {
            $this->Flash->success((string)__('The post has been deleted.'));
        } else {
            $this->Flash->error((string)__('The post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
