<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'View User');
?>

<?php
$this->insertDialog(array('Allotment'=>array('success'=>'$.fn.yiiGridView.update("allotment-grid"); $.fn.yiiGridView.update("allotment2-grid");', 'forceDialog'=>true)));
$this->widget('wsext.JuiDialogForm', array('model'=>'Allotment', 'dialog_id'=>'allotment2', 'success'=>'$.fn.yiiGridView.update("allotment2-grid"); $.fn.yiiGridView.update("allotment-grid");', 'forceDialog'=>true));
?>


<h1><?php echo Yii::t('app', 'View User') . Yii::t('app', ' #') . $model->id; ?></h1>

<?php echo $this->renderPartial('_view', array('model'=>$model)); ?>

<hr />

<h2>Aktuální zápůjčky</h2>

<?php $this->widget('wsext.JuiDialogCreateButton', array('model'=>'Allotment', 'urlParams'=>array('user_id'=>$model->id)));?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'allotment-grid',
	'dataProvider'=>$actual->search(),
	'filter'=>$actual,
	'columns'=>array(
		array(
			'header'=>Yii::t('app', 'Actions'),
			'class'=>'ButtonColumn',
			'template'=>(user()->checkAccess('AllotmentAdmin')) ? '{view} {update} {delete}' : '{view}',
			'updateButtonUrl'=>'Yii::app()->createUrl(\'allotment/update\', array(\'id\'=>$data->id, \'user_id\'=>$data->user_id))',
			'deleteButtonUrl'=>'Yii::app()->createUrl(\'allotment/delete\', array(\'id\'=>$data->id))',
			'viewButtonUrl'=>'Yii::app()->createUrl(\'allotment/view\', array(\'id\'=>$data->id))',
		),
		array(
			'name'=>'item_name',
			'value'=>'CHtml::link(CHtml::encode($data->item_name), \'#\', array(\'onclick\'=>CHtml::ajax(array(\'url\'=>url(\'item/view\',array(\'id\'=>$data->item_id)), \'success\'=>\'function(data){$("#item-juidialog-content").html(data);$("#item-juidialog").dialog("open");return false;}\'))));',
			'type'=>'raw',
		),
		array(
			'name'=>'itemtype_id',
			'value'=>'CHtml::link(CHtml::encode($data->itemtype_name), \'#\', array(\'onclick\'=>CHtml::ajax(array(\'url\'=>url(\'itemType/view\',array(\'id\'=>$data->itemtype_id)), \'success\'=>\'function(data){$("#item-type-juidialog-content").html(data);$("#item-type-juidialog").dialog("open");return false;}\'))));',
			'type'=>'raw',
			'filter'=>CHtml::listData(ItemType::model()->findAll(array('order'=>'name')), 'id', 'name'),
		),
		'count',
		'allotment_date',
	),
)); ?>

<hr />

<h2>Historie</h2>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'allotment2-grid',
	'dataProvider'=>$history->search(),
	'filter'=>$history,
	'columns'=>array(
		array(
			'header'=>Yii::t('app', 'Actions'),
			'class'=>'ButtonColumn',
			'template'=>(user()->checkAccess('AllotmentAdmin')) ? '{view} {update} {delete}' : '{view}',
			'updateButtonUrl'=>'Yii::app()->createUrl(\'allotment/update\', array(\'id\'=>$data->id, \'user_id\'=>$data->user_id))',
			'deleteButtonUrl'=>'Yii::app()->createUrl(\'allotment/delete\', array(\'id\'=>$data->id))',
			'viewButtonUrl'=>'Yii::app()->createUrl(\'allotment/view\', array(\'id\'=>$data->id))',
		),
		array(
			'name'=>'item_name',
			'value'=>'CHtml::link(CHtml::encode($data->item_name), \'#\', array(\'onclick\'=>CHtml::ajax(array(\'url\'=>url(\'item/view\',array(\'id\'=>$data->item_id)), \'success\'=>\'function(data){$("#item-juidialog-content").html(data);$("#item-juidialog").dialog("open");return false;}\'))));',
			'type'=>'raw',
			'filter'=>CHtml::textField('Allotment2[item_name]', $history->item_name, array('id'=>false)),
		),
		array(
			'name'=>'itemtype_id',
			'value'=>'CHtml::link(CHtml::encode($data->itemtype_name), \'#\', array(\'onclick\'=>CHtml::ajax(array(\'url\'=>url(\'itemType/view\',array(\'id\'=>$data->itemtype_id)), \'success\'=>\'function(data){$("#item-type-juidialog-content").html(data);$("#item-type-juidialog").dialog("open");return false;}\'))));',
			'type'=>'raw',
			'filter'=>CHtml::dropDownList('Allotment2[itemtype_id]', $history->itemtype_id, CHtml::listData(ItemType::model()->findAll(array('order'=>'name')), 'id', 'name'), array('id'=>false,'prompt'=>'')),
		),
		array(
			'name'=>'count',
			'filter'=>CHtml::textField('Allotment2[count]', $history->count, array('id'=>false)),
		),
		array(
			'name'=>'allotment_date',
			'filter'=>CHtml::textField('Allotment2[allotment_date]', $history->allotment_date, array('id'=>false)),
		),
		array(
			'name'=>'return_date',
			'filter'=>CHtml::textField('Allotment2[return_date]', $history->return_date, array('id'=>false)),
		),
		array(
			'name'=>'return_status',
			'value'=>'$data->return_status_f',
			'filter'=>CHtml::dropDownList('Allotment2[return_status]', (is_string($history->return_status) ? $history->return_status : ''), DropDownItem::items('allotment.return_status'), array('id'=>false,'prompt'=>'')),
		),
	),
)); ?>


