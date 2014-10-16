<?php 
	$html_tasks = null;
	foreach ($client as $task) {

		$add_task_link = $this->Html->div('col', $this->Html->link('Создать подзадачу', 
			array('controller' => 'pages', 'action' => 'new_task', 'Task', $task['Task']['id']), 
			array('class' => 'btn btn-success')));
		$edit_link = $this->Html->div('col', $this->Html->link('ред', 
			array('controller' => 'pages', 'action' => 'edit_task', $task['Task']['id']), 
			array('class' => 'btn btn-success')));
		$take_link = $this->Html->div('col', $this->Html->link('взять', 
			array('controller' => 'pages', 'action' => 'take_task', $task['Task']['id']), 
			array('class' => 'btn btn-success')));

		foreach ($task['User'] as $user) {
			if($user['id'] == $user_id){
				$take_link = $this->Html->div('col', $this->Html->link('комент', 
					array('controller' => 'pages', 'action' => 'commit_task', $task['Task']['id']), 
					array('class' => 'btn btn-success')));
				$edit_link = null;
				break;
			} else{
				$take_link = null;
				$edit_link = null;
			}

		}

		$html_child = null;
		if(!empty($task['children'])){
			$pr = $this->element('clients-tasks-out', array('client' => $task['children']));
			$html_child .= $this->Html->div('child col-10', $pr);
			$take_link = null;
		}

		$html_task  = $this->Html->div('col-5', $task['Task']['name']);
		$html_task .= $add_task_link;
		$html_task .= $edit_link;
		$html_task .= $take_link;

		
		
		$html_task .= $html_child;
		$html_tasks .= $this->Html->div('div-parent col-10', $html_task);
	}
	
	echo $html_tasks;
?>