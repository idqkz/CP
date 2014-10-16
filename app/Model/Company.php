<?php
App::uses('Model', 'Model');

class Company extends AppModel {

	public $hasAndBelongsToMany = array(
		'Client' => array(
			'className' => 'Client'
		)
	);

	public $hasMany = array('User');

	public function beforeSave($options = array()) {
		$this->data['Company']['code'] = $this->generate_code();
    }

    public function afterSave($created, $options = array()){
    	// if ($)
    }

    function generate_code($length = 10, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
		$str = '';
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count-1)];
		}
		return $str;
	}

	public function get_users_id(){
		$result = $this->find('first', array('conditions' => array('description' => 'users')));
		$result = $result['Group']['id'];
		return $result;
	}
}