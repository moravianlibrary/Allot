<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'create_time',
		'modify_time',
		'number',
		'name',
		'floor',
		array(
			'name'=>'building_name',
			'value'=>CHtml::link(CHtml::encode($model->building_name), '#', array('onclick'=>CHtml::ajax(array('url'=>url('building/view',array('id'=>$model->building_id)), 'success'=>'function(data){$("#building-juidialog-content").html(data);$("#building-juidialog").dialog("open");return false;}')))),
			'type'=>'raw',
        ),
		'description',
	),
)); ?>
