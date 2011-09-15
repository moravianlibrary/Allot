<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'create_time',
		'modify_time',
		'name',
		array(
			'name'=>'ext_table',
			'value'=>DropDownItem::item('itemCategory.ext_table', $model->ext_table),
		),
	),
)); ?>
