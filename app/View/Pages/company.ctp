<?php 
	echo $this->Form->create('Company');

	echo $this->Form->hidden('id');
	echo $this->Form->input('name', array('label' => 'Название компании'));
	echo $this->Form->input('description', array('label' => 'Описание'));
	echo $this->Form->submit('Сохранить', array('class' => 'btn btn-success'));

	echo $this->Form->end();
?>