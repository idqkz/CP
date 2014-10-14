<?php 
	echo $this->Html->tag('p' ,
		$this->Html->link('Логин', 		array('controller' => 'pages', 'action' => 'login')));
	echo $this->Html->tag('p', 
		$this->Html->link('Регистрация', 	array('controller' => 'pages', 'action' => 'register')));
	echo $this->Html->tag('p', 
		$this->Html->link('Создать клиента', 		array('controller' => 'pages', 'action' => 'create_client')));
	echo $this->Html->tag('p', 
		$this->Html->link('Клиенты', 		array('controller' => 'pages', 'action' => 'view_all_clients')));
?>