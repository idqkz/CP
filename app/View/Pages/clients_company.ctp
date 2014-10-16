<?php 
	$add_client_link = $this->Html->link('Добавить клиента', 
		array('controller' => 'pages', 'action' => 'add_client_to_company', $id),
		array('class' => 'btn btn-success')
		);

	echo $this->Html->tag('h2', 'Клиенты компании'.$add_client_link);

	$html_clients = null;

	foreach ($clients['Client'] as $client) {

		$html_client = $this->Html->div('col-3', $client['name']);
		$chane_link = $this->Html->link('Изменить', 
			array('controller' => 'pages', 'action' => 'change_client', $client['id']));
		$tasks_for_client_link = $this->Html->link('Задачи', 
			array('controller' => 'pages', 'action' => 'view_client_with_task', $client['id']));

		$html_client .= $this->Html->div('col', $chane_link);
		$html_client .= $this->Html->div('col', $tasks_for_client_link);
		$html_clients .= $this->Html->div('col-10', $html_client);

	}

	echo $html_clients;

?>