<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'create_time',
		'modify_time',
		'title_before_name',
		'firstname',
		'lastname',
		'title_after_name',
		'email:email',
	),
)); ?>
