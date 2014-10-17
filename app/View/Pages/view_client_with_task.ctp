<?php 
	$add_task_link = $this->Html->link('Создать задачу', 
		array('controller' => 'pages', 'action' => 'new_task', 'Client', $client['Client']['id']),
		array('class' => 'btn btn-success')
	);

	echo $this->Html->div('h2', 'Задачи для '.$client['Client']['name'].$add_task_link);
	
	$html_tasks = $this->element('clients-tasks-out', array('client' => $client['Task']));

	echo $html_tasks;
?>