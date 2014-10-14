<?php

App::uses('AppController', 'Controller');

class PagesController extends AppController {

	public $components = array(
		'Auth' => array(
			'all' => array('userModel' => 'User'),
			'authenticate' => array(
	             'Form' => array(
	                 'fields' => array('username' => 'email', 'password' => 'password')
	             )
	         ),
		    'loginAction' => array(
		        'controller' => 'admin',
		        'action' => 'login'
		    ),
		    'authError' => 'Неверный логин или пароль',
		),
		'Paginator'
	);

	public $uses = array('User', 'Client', 'Task', 'ClientsUser');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
		$this->layout = 'admin';
	}

	public function beforeRender() {
		parent::beforeRender();
		$title_for_layout = 'Control-project';
		
		$main_menu_items = array(
			'Логин'				=>	array('controller' => 'pages', 'action' => 'login'),
			'Регистрация'			=>	array('controller' => 'pages', 'action' => 'register'),	
			'Создать клиент'				=>	array('controller' => 'pages', 'action' => 'create_client'),
			'Все клиенты'			=>	array('controller' => 'pages', 'action' => 'view_all_clients')
		);

		$this->set(compact('title_for_layout', 'main_menu_items'));
	}

	public function index() {
		$this->redirect(array('controller' => 'pages', 'action' => 'home'));	
	}

	public function home() {
		// $items = $this->Item->find('all');
		// $this->set(compact('items'));
	}

	public function register() {
		if (!empty($this->data)){
			$count = $this->User->find('count', array('conditions' => array('email' => $this->data['User']['email'])));
			($count == 0 ? $result = true : $result = false);
			if ($result){
				$this->request->data['User']['group_id'] = $this->Group->get_users_id();
				// debug($this->data);
				$this->User->save($this->data);
			}
		}
	}

	public function login() {
		if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	        	// $this->User->update_last_login($this->Auth->user('id'));

	        	$this->Session->setFlash($this->Auth->user('name') .' добро пожаловать ');
	            return $this->redirect(array('controller' => 'admin', 'action' => null));
	        } else {
	        	$this->Session->setFlash('Войти не удалось');
	        }
	    }
	}

	public function create_client() {
		if(!empty($this->data)){
			$this->Client->save($this->data);
			$data_ClientsUser = array(
					'user_id' => $this->Auth->user('id'),
					'client_id' => $this->Client->getLastInsertId(),
				);
			$this->ClientsUser->save($data_ClientsUser);
		}
	}

	public function delete_change_client($id = null) {
		if($id != null){
			$this->Client->delete($id);
			$this->redirect(array('controller' => 'pages', 'action' => 'view_all_clients'));
		}
	}

	public function change_client($id = null) {
		if(!empty($this->data)){
			$this->Client->save($this->data['Client']);
			$this->redirect(array('controller' => 'pages', 'action' => 'view_all_clients'));
		}

		if($id != null){
			$this->request->data = $this->Client->findById($id);
		}
		$this->render('create_client');
	}

	public function view_client_with_task($id) {
		// $this->client->recursive = 2;
		$client = $this->Client->findById($id);
		$this->Task->recursive = 3;
		$task = $this->Task->find('threaded', array(
			'conditions' => array(
				'client_id' => $id,
				),
			));
	
		$client['Task'] = $task;
		// debug($client);
		// die();
		$this->set(compact('client'));
	}

	public function view_all_clients() {
		$this->Auth->user('id');
		$this->User->recursive = 2;
		$clients = $this->User->findById($this->Auth->user('id'));
		// debug($clients);
		// die();

		$this->set(compact('clients'));
	}

	public function new_task($type, $id = null) {

		if(!empty($this->data)){
			if(empty($this->data['Task']['parent_id']))
			$this->request->data['Task']['parent_id'] = null;
			$this->Task->save($this->data);
			$this->redirect(array('controller' => 'pages', 'action' => 'view_client_with_task', $this->data['Task']['client_id']));
		}

		$this->request->data['Task']['client_id'] = $id;
		if ($type == 'Task') {
			$task = $this->Task->findById($id);
			$this->request->data['Task']['client_id'] = 
			$task['Task']['client_id'];
			$this->request->data['Task']['parent_id'] = $id;
		}
	}

	public function edit_task($id = null) {
		if(!empty($this->data)){
			$this->Task->save($this->data);
			$client_id = $this->data['Task']['client_id'];
			unset($this->data);
			$this->redirect(array('controller' => 'pages', 'action' => 'view_client_with_task', $client_id));
		}

		if($id != null){
			$this->request->data = $this->Task->findById($id);
		}
		$this->render('new_task');
	}

	public function delete_edit_task($id = null) {
		if($id != null){
			$client_id = $this->Task->findById($id);
			$client_id = $client_id['Task']['client_id'];
			$this->Task->delete($id);
			$this->redirect(array('controller' => 'pages', 'action' => 'view_client_with_task', $client_id));
		}
	}

	// public function view_client_with_task() {

	// }

}
