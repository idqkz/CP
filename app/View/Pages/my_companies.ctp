<?php 
	/*echo $this->Html->tag('h2', 'Мои компании');

	$html_companies = null;
	foreach ($companies as $company) {

		$html_company = $this->Html->div('col-3', $company['name']);
		$edit_link = $this->Html->link('Изменить', 
			array('controller' => 'pages', 'action' => 'change_company', $company['id']));
		$clients_link = $this->Html->link('Клиенты', 
			array('controller' => 'pages', 'action' => 'clients_company', $company['id']));
		$add_user_link = $this->Html->link('+User', 
			array('controller' => 'pages', 'action' => 'user_add_to_company', $company['id']));

		$html_company .= $this->Html->div('col', $edit_link);
		$html_company .= $this->Html->div('col', $clients_link);
		$html_company .= $this->Html->div('col', $add_user_link);
		$html_companies .= $this->Html->div('col-10', $html_company);

	}
	echo $html_companies;*/
?>