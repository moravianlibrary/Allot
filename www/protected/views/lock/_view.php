<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'create_time',
		'modify_time',
		'number',
		'name',
		'count',
		'allotted',
		'description',
	),
)); ?>
