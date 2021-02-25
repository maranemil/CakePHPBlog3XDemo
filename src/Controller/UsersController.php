<?php
// src/Controller/UsersController.php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Http\Response;

class UsersController extends AppController {

   /*public function beforeFilter(Event $event)
   {
	   parent::beforeFilter($event);
	   $this->Auth->allow('add');
   }*/

   /**
	*
	*/
   public function index() {
	  $this->set('users', $this->Users->find('all'));
   }

   /**
	* @param $id
	*/
   public function view($id) {
	  $user = $this->Users->get($id);
	  $this->set(compact('user'));
   }

   /**
	* @return Response|null
	* @throws \Aura\Intl\Exception
	*/
   public function add() {
	  $user = $this->Users->newEntity();
	  if ($this->request->is('post')) {
		 // Prior to 3.4.0 $this->request->data() was used.
		 $user = $this->Users->patchEntity($user, $this->request->getData());
		 if ($this->Users->save($user)) {
			$this->Flash->success(__('The user has been saved.'));
			return $this->redirect(['action' => 'add']);
		 }
		 $this->Flash->error(__('Unable to add the user.'));
	  }
	  $this->set('user', $user);
   }

   // Other methods..

   /**
	* @param Event $event
	*
	* @return Response|void|null
	*/
   public function beforeFilter(Event $event) {
	  parent::beforeFilter($event);
	  // Allow users to register and logout.
	  // You should not add the "login" action to allow list. Doing so would
	  // cause problems with normal functioning of AuthComponent.
	  $this->Auth->allow(['add', 'logout']);
   }

   /**
	* @return Response|null
	* @throws \Aura\Intl\Exception
	*/
   public function login() {
	  if ($this->request->is('post')) {
		 $user = $this->Auth->identify();
		 if ($user) {
			$this->Auth->setUser($user);
			return $this->redirect($this->Auth->redirectUrl());
		 }
		 $this->Flash->error(__('Invalid username or password, try again'));
	  }
   }

   public function logout() {
	  return $this->redirect($this->Auth->logout());
   }

}