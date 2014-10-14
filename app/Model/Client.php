<?php
App::uses('Model', 'Model');

class Client extends AppModel {

	public $hasMany = array(
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'client_id',
			'dependent' => 'true'
		)
	);

	public function beforeSave($options = array()) {

    }

    public function afterSave($created, $options = array()){
    	
    }
}