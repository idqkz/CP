<?php 
	$add_task_link = $this->Html->link('Создать задачу', 
		array('controller' => 'pages', 'action' => 'new_task', 'Client', $client['Client']['id']),
		array('class' => 'btn btn-success')
		);

	echo $this->Html->div('h2', 'Задачи для '.$client['Client']['name'].$add_task_link);

	$html_tasks = null;

	// Вывод элементом
	// $html_tasks = $this->element('clients-tasks-out', array('client' => $client['Task']));

	// Вывод хелперомы
	$html_tasks = $this->View->clients_tasks_out($client['Task']);

	echo $html_tasks;
?>