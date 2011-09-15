<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Manage Allotments');
?>

<?
$this->widget('wsext.JuiDialogForm', array('model'=>'User'));
$this->widget('wsext.JuiDialogForm', array('model'=>'Item'));
?>

<h1><?php echo Yii::t('app', 'Manage Allotments'); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'allotment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>Yii::t('app', 'Actions'),
			'class'=>'ButtonColumn',
			'template'=>(user()->checkAccess('AllotmentAdmin')) ? '{view} {update} {delete}' : '{view}',
		),
		array(
			'name'=>'user_full_name',
			'value'=>'CHtml::link(CHtml::encode($data->user_full_name), \'#\', array(\'onclick\'=>CHtml::ajax(array(\'url\'=>url(\'user/view\',array(\'id\'=>$data->user_id)), \'success\'=>\'function(data){$("#user-juidialog-content").html(data);$("#user-juidialog").dialog("open");return false;}\'))));',
			'type'=>'raw',
		),
		array(
			'name'=>'item_name',
			'value'=>'CHtml::link(CHtml::encode($data->item_name), \'#\', array(\'onclick\'=>CHtml::ajax(array(\'url\'=>url(\'item/view\',array(\'id\'=>$data->item_id)), \'success\'=>\'function(data){$("#item-juidialog-content").html(data);$("#item-juidialog").dialog("open");return false;}\'))));',
			'type'=>'raw',
		),
		'count',
		'allotment_date',
		'return_date',
		array(
			'name'=>'return_status',
			'value'=>'DropDownItem::item(\'allotment.return_status\', $data->return_status)',
			'filter'=>DropDownItem::items('allotment.return_status'),
		),
	),
)); ?>
