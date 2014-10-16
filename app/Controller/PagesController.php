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
		        'controller' => 'pages',
		        'action' => 'login'
		    ),
		    'authError' => 'Неверный логин или пароль',
		),
		'Paginator'
	);

	public $uses = array('User', 'Client', 'Task', 'Company', 'ClientsCompany', 'CompaniesUser', 'TasksUser');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('login'));
		$this->Auth->allow();
		$this->layout = 'admin';
	}

	public function beforeRender() {
		parent::beforeRender();
		$title_for_layout = 'Control-project';
		
		$main_menu_items = array(
			'Логин'				=>	array('controller' => 'pages', 'action' => 'login'),
			'Регистрация компании'			=>	array('controller' => 'pages', 'action' => 'register'),	
			'Клиенты компании'			=>	array('controller' => 'pages', 'action' => 'view_all_clients',
				'sub_menu' => array(
						'Создать клиента' => array('controller' => 'pages', 'action' => 'create_client'),
					)
				),
			'Сотдрудники'			=>	array('controller' => 'pages', 'action' => 'collaborators'),
			'Ред. компанию'			=>	array('controller' => 'pages', 'action' => 'change_company'),			
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
			if ($count == 0){
				$this->User->save($this->data['User']);
				$this->request->data['Company']['user_id'] = $this->User->getLastInsertId();
				$this->Company->save($this->data['Company']);
				$this->request->data['User']['company_id'] = $this->Company->getLastInsertId();
				$data_save['user_id'] = $this->request->data['user_id'];
				$data_save['company_id'] = $this->Company->getLastInsertId();
				$this->CompaniesUser->save($data_save);
			}
		}
	}

	public function login() {
		if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	        	// $this->User->update_last_login($this->Auth->user('id'));
	        	$this->Session->setFlash($this->Auth->user('name') .' добро пожаловать ');
	            return $this->redirect(array('controller' => 'pages', 'action' => null));
	        } else {
	        	$this->Session->setFlash('Войти не удалось');
	        }
	    }
	}

	public function create_client() {
		if(!empty($this->data)){
			$this->Client->save($this->data);
			$data_ClientsCompany = array(
					'client_id' => $this->Client->getLastInsertId(),
					'company_id' =>  $this->Auth->user('company_id'),
				);
			$this->ClientsCompany->save($data_ClientsCompany);
		}
	}

	public function delete_change_client($id = null) {
		if($id != null){
			$this->Clientjj->delete($id);
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
		$this->Task->Behaviors->load('Containable');
		$this->Task->contain('User');
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
		$user_id = $this->Auth->user('id');
		$this->set(compact('client', 'user_id'));
	}

	public function view_all_clients() {
		$this->User->Behaviors->load('Containable');
		$this->User->contain('Company', 'Company.Client');
		$clients = $this->User->findById($this->Auth->user('id'));
		
		$this->set(compact('clients'));
	}

	public function new_task($type, $id = null) {

		if(!empty($this->data)){
			if(empty($this->data['Task']['parent_id']))
			$this->request->data['Task']['parent_id'] = null;
			$this->request->data['Task']['status'] = 1;
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

	public function give_task($id = null) {
		if(!empty($this->data)){
			$this->TasksUser->save($this->data);
			unset($this->data);
		}

		$users = $this->User->find('list');

		$this->set(compact('users', 'id'));
	}

	public function take_task($id = null) {
		$this->autoRender = false;
		if($id != null){
			$save_data['task_id'] = $id;
			$save_data['user_id'] = $this->Auth->user('id');
			$this->TasksUser->save($save_data);
			unset($save_data);
			$save_data['id'] = $id;
			$save_data['status'] = 2;
			$this->Task->save($save_data);
		}
	}

	public function commit_task($id = null) {
		if (isset($this->data['Task']['id'])) {
			if($this->data['Task']['status'] == 1){
				$this->TasksUser->deleteAll(array('task_id' => $this->data['Task']['id']));
			}
			$this->Task->save($this->data);
			unset($this->data);
		}

		$task_status_list = array(
				'0' => 'Выберите статус',
				'1' => 'Ничей',
				'2' => 'В процесе',
				'3' => 'Выполнен',
			);

		if($id != null){
			$this->request->data = $this->Task->findById($id);
		}

		$this->set(compact('task', 'task_status_list'));
	}

	public function delete_edit_task($id = null) {
		if($id != null){
			$client_id = $this->Task->findById($id);
			$client_id = $client_id['Task']['client_id'];
			$this->Task->delete($id);
			$this->redirect(array('controller' => 'pages', 'action' => 'view_client_with_task', $client_id));
		}
	}

	public function create_company() {
		if(!empty($this->data)){
			$this->request->data['Company']['user_id'] = $this->Auth->user('id');
			$this->Company->save($this->data);
			$companies_user_data['company_id'] = $this->Company->getLastInsertId();
			$companies_user_data['user_id'] = $this->Auth->user('id');
			$this->CompaniesUser->save($companies_user_data);
			unset($this->data);
			$this->redirect(array('controller' => 'pages', 'action' => null));
		}

		$this->render('company');
	}

	public function change_company($id = null) {
		if(!empty($this->data)){
			$this->Company->save($this->data);
			unset($this->data);
			// $this->redirect(array('controller' => 'pages', 'action' => 'my_companies'));
		}

		if($id != null){
			$this->request->data = $this->Company->findById($id);
		}

		$this->User->Behaviors->load('Containable');
		$this->User->contain('Company', 'Company.Client');
		$user = $this->User->findById($this->Auth->user('id'));
		$this->request->data['Company'] = $user['Company'];
		// $this->request->data = $this->Company->findById($company['Company']['id']);

		$this->render('company');
	}

	/*public function my_companies() {
		$this->User->Behaviors->load('Containable');
		$this->User->contain('Company');
		$user = $this->User->findById($this->Auth->user('id'));

		$companies = $user['Company'];
		$this->set(compact('companies'));
	}*/

	public function clients_company($id = null) {
		if ($id != null){
			$clients = $this->Company->findById($id);
		}
		$this->set(compact('id', 'clients'));
	}

	public function collaborators() {
		$this->User->Behaviors->load('Containable');
		$this->User->contain('Company', 'Company.User');
		$info = $this->User->findById($this->Auth->user('id'));

		$this->set(compact('info'));
	}

	public function register_collaborator($name = null, $code = null) {
		$this->Company->Behaviors->load('Containable');
		$this->Company->contain();
		$company = $this->Company->find('all', array(
			'conditions' => array('Company.name' => $name, 'Company.code' => $code),
			)
		);

		if(count($company) == 1) {
			if(!empty($this->data)){
				$count = $this->User->find('count', array('conditions' => array('email' => $this->data['User']['email'])));
				if ($count == 0){
					$this->request->data['User']['company_id'] = $company[0]['Company']['id'];
					debug($company);
					debug($this->data);
					// die();
					$this->User->save($this->data);
				}
			}
		}
		
	}
	

	/*public function add_client_to_company($id = null){
		if(!empty($this->data)){
			$this->ClientsCompany->save($this->data);
			unset($this->data);
		}

		if($id != null){
			$clients_list = null;
			$clients = $this->User->findById($this->Auth->user('id'));
			$clients = $clients['Client'];			
			foreach ($clients as $client) {
				$clients_list[$client['id']] = $client['name'];

			}
		}

		$this->set(compact('clients_list', 'id'));
	}*/

	/*public function user_add_to_company($id = null){
		if(!empty($this->data)){
			$this->CompaniesUser->save($this->data);
			unset($this->data);
		}

		$users = $this->User->find('list');

		$this->set(compact('users', 'id'));
	}*/

	/*public function add_client_to_company($id = null){
		id($id != null){

		}
	}*/


}
