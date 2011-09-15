<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'create_time',
		'modify_time',
		'name',
		'street',
		'land_registry_number',
		'house_number',
		'postal_code',
		'city',
		'description',
	),
)); ?>
