<?php 
	echo $this->Form->create('User');

	echo $this->Form->input('name', array('label' => 'Ф.И.О.'));
	echo $this->Form->input('email', array('label' => 'E-mail', 'placeholder' => 'example@mail.com'));
	echo $this->Form->input('password', array('label' => 'Пароль', 'placeholder' => 'пароль'));
	echo $this->Form->input('phone', array('label' => 'Сот. телефон', 'placeholder' => '87011231212'));

	echo $this->Form->submit('Зарегистрироваться', array('class' => 'btn btn-success'));

	echo $this->Form->end();
?>