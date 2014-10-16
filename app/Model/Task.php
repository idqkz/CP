<?php
App::uses('Model', 'Model');

class Task extends AppModel {

	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User'
		)
	);

	public function beforeSave($options = array()) {

    }

    public function afterSave($created, $options = array()){
    	
    }
}