<?php 
	$html_tasks = null;
	foreach ($client as $task) {

		$add_task_link = $this->Html->link('Создать подзадачу', 
				array('controller' => 'pages', 'action' => 'new_task', 'Task', $task['Task']['id']), 
				array('class' => 'btn btn-success')
			);

		$html_task  = $this->Html->div('col-3', $task['Task']['name']);
		$html_task .= $this->Html->div('col-10', $add_task_link);

		$html_child = null;
		if(!empty($task['children'])){
			$pr = $this->element('clients-tasks-out', array('client' => $task['children']));
			$html_child .= $this->Html->div('child col', $pr);
		}
		
		$html_task .= $html_child;
		$html_tasks .= $this->Html->div('div-parent col-10', $html_task);
	}
	
	echo $html_tasks;
?>