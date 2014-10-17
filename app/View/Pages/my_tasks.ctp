<?php
	echo $this->Html->tag('h2', 'Мои задачи');

	$html_tasks = null;
	foreach ($tasks as $task) {
			$edit_link = $this->Html->div('col', $this->Html->link('ред', 
				array('controller' => 'pages', 'action' => 'edit_task', $task['id']), 
				array('class' => 'btn btn-success')));
			$commit_task = $this->Html->div('col', $this->Html->link('комент', 
						array('controller' => 'pages', 'action' => 'commit_task', $task['id']), 
						array('class' => 'btn btn-success')));

			$html_task = $this->Html->div('col-3', $task['name']);
			$html_task .= $edit_link;
			$html_task .= $commit_task;
			$html_tasks .= $this->Html->div('col-10', $html_task);
	}

	echo $html_tasks;
?>