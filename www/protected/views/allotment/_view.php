<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'create_time',
		'modify_time',
		array(
			'name'=>'user_full_name',
			'value'=>CHtml::link(CHtml::encode($model->user_full_name), '#', array('onclick'=>CHtml::ajax(array('url'=>url('user/view',array('id'=>$model->user_id)), 'success'=>'function(data){$("#user-juidialog-content").html(data);$("#user-juidialog").dialog("open");return false;}')))),
			'type'=>'raw',
        ),
		array(
			'name'=>'item_name',
			'value'=>CHtml::link(CHtml::encode($model->item_name), '#', array('onclick'=>CHtml::ajax(array('url'=>url('item/view',array('id'=>$model->item_id)), 'success'=>'function(data){$("#item-juidialog-content").html(data);$("#item-juidialog").dialog("open");return false;}')))),
			'type'=>'raw',
        ),
		'count',
		'allotment_date',
		'return_date',
		array(
			'name'=>'return_status',
			'value'=>DropDownItem::item('allotment.return_status', $model->return_status),
		)
	),
)); ?>
