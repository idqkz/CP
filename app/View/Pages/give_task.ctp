<?php
	echo $this->Html->tag('h2', 'Дать задачю пользователю');

	echo $this->Form->create('TasksUser');

	echo $this->Form->hidden('task_id', array('value' => $id));
	echo $this->Form->input('user_id', array('label' => 'Выберите юзера', 'options' => $users));
	echo $this->Form->submit('Добавить', array('class' => 'btn btn-success'));

	echo $this->Form->end();
?>