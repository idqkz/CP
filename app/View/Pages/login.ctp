<?php

	echo $this->Form->create('User', 		array('inputDefaults' => array('class' => 'input-text', 'label' => false)));
	echo $this->Form->input('email', 	array('placeholder' => 'Ваш E-mail', 'type' => 'email'));
?>
	<div class="input-password visible">
		<?php echo $this->Form->input('User.password', array('placeholder'=>'Пароль', 'div' => false)); ?>
		<i class='glyphicon link link-primary'>показать</i>
	</div>
<?
	echo $this->Form->submit('войти', array('class' => 'btn btn-success'));
	echo $this->Form->end();

	// echo $this->Html->script('view-pass');

?>