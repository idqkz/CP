<?php 
	echo $this->Html->tag('h2', 'Задача "'.$this->data['Task']['name'].'"');

	echo $this->Form->create('Task');

	echo $this->Form->hidden('id');
	echo $this->Form->input('status', array('options' => $task_status_list, 'label' => 'Статус'));

	echo $this->Form->submit('OK', array('class' => 'btn btn-success'));
	echo $this->Form->end();
?>