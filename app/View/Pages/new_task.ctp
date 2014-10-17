<?php 
	echo $this->Form->create('Task');

	echo $this->Form->hidden('client_id');
	echo $this->Form->hidden('parent_id');
	echo $this->Form->hidden('id');

	echo $this->Form->input('name', array('label' => 'Название задачи'));
	echo $this->Form->input('description', array('label' => 'Описание'));
	echo $this->Form->input('due_date', 
			array(
				'label' => 'Конец срока', 
				'dateFormat' => 'DMY', 
				'minYear' => date('Y'),
				'maxYear' => date('Y') + 5,
				)
		);
	echo $this->element('pages-form-buttons');

	echo $this->Form->end();
?>