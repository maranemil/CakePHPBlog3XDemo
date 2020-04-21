<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 *
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController {


	/*
	public function index()
		{
			 $this->set('articles', $this->Articles->find('all'));
		}

		public function view($id = null)
		{
			$article = $this->Articles->get($id);
			$this->set(compact('article'));
		}

	public function initialize()
		{
			parent::initialize();

			$this->loadComponent('Flash'); // Include the FlashComponent
		}

		public function index()
		{
			$this->set('articles', $this->Articles->find('all'));
		}

		public function view($id)
		{
			$article = $this->Articles->get($id);
			$this->set(compact('article'));
		}

		public function add()
		{
			$article = $this->Articles->newEntity();
			if ($this->request->is('post')) {
				// Prior to 3.4.0 $this->request->data() was used.
				$article = $this->Articles->patchEntity($article, $this->request->getData());
				if ($this->Articles->save($article)) {
					$this->Flash->success(__('Your article has been saved.'));
					return $this->redirect(['action' => 'index']);
				}
				$this->Flash->error(__('Unable to add your article.'));
			}
			$this->set('article', $article);
		}



	 */

	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */
	public function index() {
		$articles = $this->paginate($this->Articles);

		$this->set(compact('articles'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Article id.
	 *
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$article = $this->Articles->get($id, [
			'contain' => []
		]);

		$this->set('article', $article);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	/*public function add()
	{
		$article = $this->Articles->newEntity();
		if ($this->request->is('post')) {
			$article = $this->Articles->patchEntity($article, $this->request->getData());
			if ($this->Articles->save($article)) {
				$this->Flash->success(__('The article has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The article could not be saved. Please, try again.'));
		}
		$this->set(compact('article'));
	}*/

	// src/Controller/ArticlesController.php

	public function add() {
		$article = $this->Articles->newEntity();
		if ($this->request->is('post')) {
			// Prior to 3.4.0 $this->request->data() was used.
			$article = $this->Articles->patchEntity($article, $this->request->getData());
			// Added this line
			$article->user_id = $this->Auth->user('id');
			// You could also do the following
			//$newData = ['user_id' => $this->Auth->user('id')];
			//$article = $this->Articles->patchEntity($article, $newData);
			if ($this->Articles->save($article)) {
				$this->Flash->success(__('Your article has been saved.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Unable to add your article.'));
		}
		$this->set('article', $article);

		// Just added the categories list to be able to choose
		// one category for an article
		$categories = $this->Articles->Categories->find('treeList');
		$this->set(compact('categories'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Article id.
	 *
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$article = $this->Articles->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$article = $this->Articles->patchEntity($article, $this->request->getData());
			if ($this->Articles->save($article)) {
				$this->Flash->success(__('The article has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The article could not be saved. Please, try again.'));
		}
		$this->set(compact('article'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Article id.
	 *
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$article = $this->Articles->get($id);
		if ($this->Articles->delete($article)) {
			$this->Flash->success(__('The article has been deleted.'));
		}
		else {
			$this->Flash->error(__('The article could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	// src/Controller/ArticlesController.php

	public function isAuthorized($user) {
		// All registered users can add articles
		// Prior to 3.4.0 $this->request->param('action') was used.
		if ($this->request->getParam('action') === 'add') {
			return true;
		}

		// The owner of an article can edit and delete it
		// Prior to 3.4.0 $this->request->param('action') was used.
		if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
			// Prior to 3.4.0 $this->request->params('pass.0')
			$articleId = (int)$this->request->getParam('pass.0');
			if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
				return true;
			}
		}

		return parent::isAuthorized($user);
	}


}
