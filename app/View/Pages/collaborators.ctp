<?php 
	// echo $this->Html->link('123', 
	// 	array(
	// 		'controller' => 'pages', 
	// 		'action' => 'register_collaborator', 
	// 		$info['Company']['name'],
	// 		$info['Company']['code'],
	// 		)
	// 	);
	$register_link = $this->Form->input('Ссылка для регистрации сотдрудника:', 
		array('value' => env('HTTP_HOST').'/pages/register_collaborator/'.$info['Company']['name'].'/'.$info['Company']['code'])
		);

	echo $this->Html->div('col-10', $register_link);

	echo $this->Html->tag('h2','Сотрудники компании');

	$html_users = null;
	foreach ($info['Company']['User'] as $user) {
		$html_user = null;
		$html_user = $this->Html->div('col-1', $user['id']);
		$html_user .= $this->Html->div('col-4', $user['name']);

		$html_users .= $this->Html->div('col-10', $html_user);
	}

	echo $html_users;
?>