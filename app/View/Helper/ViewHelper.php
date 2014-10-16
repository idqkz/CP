<?
class ViewHelper extends AppHelper{

	public $helpers = array('Html');

	public $components = array('Auth');

	function clients_tasks_out($client){
		$html_tasks = null;
		foreach ($client as $task) {

			$add_task_link = $this->Html->link('Создать подзадачу', 
					array('controller' => 'pages', 'action' => 'new_task', 'Task', $task['Task']['id']), 
					array('class' => 'btn btn-success')
				);
			$edit_link = $this->Html->link('ред', 
					array('controller' => 'pages', 'action' => 'edit_task', $task['Task']['id']), 
					array('class' => 'btn btn-success')
				);

			$give_link = $this->Html->link('отдать', 
					array('controller' => 'pages', 'action' => 'give_task', $task['Task']['id']), 
					array('class' => 'btn btn-success')
				);
			$take_link = $this->Html->link('взять', 
					array('controller' => 'pages', 'action' => 'take_task', $task['Task']['id']), 
					array('class' => 'btn btn-success')
				);


			$html_task  = $this->Html->div('col-5', $task['Task']['name']);
			$html_task .= $this->Html->div('col', $add_task_link);
			$html_task .= $this->Html->div('col', $edit_link);
			$html_task .= $this->Html->div('col', $give_link);
			$html_task .= $this->Html->div('col', $take_link);

			$html_child = null;
			if(!empty($task['children'])){
				$pr = $this->clients_tasks_out($task['children']);
				$html_child .= $this->Html->div('child col-10', $pr);
			}

			$html_task .= $html_child;
			$html_tasks .= $this->Html->div('div-parent col-10', $html_task);
		}
		
		return $html_tasks;
	}
}
?>