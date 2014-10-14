<?php
App::uses('Model', 'Model');

class Group extends AppModel {

	public function beforeSave($options = array()) {

    }

    public function afterSave($created, $options = array()){
    	
    }

	public function get_users_id(){
		$result = $this->find('first', array('conditions' => array('description' => 'users')));
		$result = $result['Group']['id'];
		return $result;
	}
}