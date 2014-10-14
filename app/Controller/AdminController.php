<?php

App::uses('AppController', 'Controller');

class AdminController extends AppController {

	// public $uses = array('Item', 'Order', 'ItemsOrder', 'User', 'Group', 'Image');

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

	public function beforeRender() {
		parent::beforeRender();
		$main_menu_items_for_operator = array(
			'Заказы'			=>	array('controller' => 'admin', 'action' => 'orders_all'),	
			'Меню'				=>	array('controller' => 'admin', 'action' => 'menu_item_all')
			);		

		$main_menu_items = array(
			'Настройки'				=>	array('controller' => 'admin', 'action' => 'settings'),
			'Заказы'				=>	array('controller' => 'admin', 'action' => 'orders_all'),	
			'Меню'					=>	array('controller' => 'admin', 'action' => 'menu_item_all'),
			'Пользователи'			=>	array('controller' => 'admin', 'action' => 'users')
		);

		if (!$this->Auth->user()) {
			$main_menu_items = null;
		}
		// $users_id = $this->Group->find('all', array('conditions' => array('Group.name' => 'Операторы')));

		// if($this->Auth->user('group_id') == $users_id[0]['Group']['id']){
		// 	$main_menu_items = $main_menu_items_for_operator;
		// }

		$title_for_layout = 'Страницы управления';
		$this->set(compact('title_for_layout', 'main_menu_items'));
	}

	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'admin';
		// $this->Auth->allow(array('login'));
		// $this->Auth->authorize = array('Controller');

		// $this->Auth->deny();
		$this->Auth->allow();
	}

	public function login() {
		if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	        	$this->User->update_last_login($this->Auth->user('id'));

	        	$this->Session->setFlash($this->Auth->user('name') .' добро пожаловать ');
	            return $this->redirect(array('controller' => 'admin', 'action' => null));
	        } else {
	        	$this->Session->setFlash('Войти не удалось');
	        }
	    }
	}

	public function index(){

	}

}
