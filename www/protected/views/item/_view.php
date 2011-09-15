<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'create_time',
		'modify_time',
		'number',
		'name',
		'itemtype_name',
		'count',
		'allotted',
		'remaining',
		'description',
	),
)); ?>
