<?php 
	echo $this->Form->create('Client');

	echo $this->Form->hidden('id');
	echo $this->Form->input('name', array('label' => 'Название клиента'));
	echo $this->Form->input('description', array('label' => 'Описание'));

	echo $this->element('pages-form-buttons');

	echo $this->Form->end();
?>