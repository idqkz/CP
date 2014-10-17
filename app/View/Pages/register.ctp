<?php 
	echo $this->Form->create('User');

	echo $this->Form->input('User.name', array('label' => 'Ф.И.О.'));
	echo $this->Form->input('User.email', array('label' => 'E-mail', 'placeholder' => 'example@mail.com'));
	echo $this->Form->input('User.password', array('label' => 'Пароль', 'placeholder' => 'пароль'));
	echo $this->Form->input('User.phone', array('label' => 'Сот. телефон', 'placeholder' => '87011231212'));

	echo $this->Form->input('Company.name', array('label' => 'Название компании'));
	echo $this->Form->input('Company.description', array('label' => 'Описание'));

	echo $this->Form->submit('Зарегистрироваться', array('class' => 'btn btn-success'));

	echo $this->Form->end();
?>