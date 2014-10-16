<?php
App::uses('Model', 'Model');

class User extends AppModel {

	public $hasAndBelongsToMany = array(
		'Task' => array(
			'className' => 'Task'
		)
	);

	public $belongsTo = array('Company');

	public function beforeSave($options = array()) {

		if (!empty($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		} else {
			unset($this->data['User']['password']);
		}

		return true;
	}

	public function afterSave($created, $options = array()){
		// Оправка email-о регистрации 
	}
}