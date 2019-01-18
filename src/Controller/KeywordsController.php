<?php
namespace Qobo\Social\Controller;

use App\Controller\AppController;

/**
 * Keywords Controller
 *
 * @property \Qobo\Social\Model\Table\KeywordsTable $Keywords
 *
 * @method \Qobo\Social\Model\Entity\Keyword[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KeywordsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Topics']
        ];
        $keywords = $this->paginate($this->Keywords);

        $this->set(compact('keywords'));
    }

    /**
     * View method
     *
     * @param string|null $id Keyword id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $keyword = $this->Keywords->get($id, [
            'contain' => ['Topics']
        ]);

        $this->set('keyword', $keyword);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $keyword = $this->Keywords->newEntity();
        if ($this->request->is('post')) {
            $keyword = $this->Keywords->patchEntity($keyword, $this->request->getData());
            if ($this->Keywords->save($keyword)) {
                $this->Flash->success((string)__('The keyword has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The keyword could not be saved. Please, try again.'));
        }
        $topics = $this->Keywords->Topics->find('list', ['limit' => 200]);
        $this->set(compact('keyword', 'topics'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Keyword id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $keyword = $this->Keywords->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $keyword = $this->Keywords->patchEntity($keyword, $this->request->getData());
            if ($this->Keywords->save($keyword)) {
                $this->Flash->success((string)__('The keyword has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error((string)__('The keyword could not be saved. Please, try again.'));
        }
        $topics = $this->Keywords->Topics->find('list', ['limit' => 200]);
        $this->set(compact('keyword', 'topics'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Keyword id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $keyword = $this->Keywords->get($id);
        if ($this->Keywords->delete($keyword)) {
            $this->Flash->success((string)__('The keyword has been deleted.'));
        } else {
            $this->Flash->error((string)__('The keyword could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
