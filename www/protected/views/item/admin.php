<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Manage Items');
?>

<?
$this->widget('wsext.JuiDialogForm', array('model'=>'ItemType'));
$this->widget('wsext.JuiDialogForm', array('model'=>'ItemCategory'));
?>

<h1><?php echo Yii::t('app', 'Manage Items'); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>Yii::t('app', 'Actions'),
			'class'=>'ButtonColumn',
		),
		'number',
		'name',
		array(
			'name'=>'itemtype_id',
			'value'=>'CHtml::link(CHtml::encode($data->itemtype_name), \'#\', array(\'onclick\'=>CHtml::ajax(array(\'url\'=>url(\'itemType/view\',array(\'id\'=>$data->itemtype_id)), \'success\'=>\'function(data){$("#item-type-juidialog-content").html(data);$("#item-type-juidialog").dialog("open");return false;}\'))));',
			'type'=>'raw',
			'filter'=>CHtml::listData(ItemType::model()->findAll(array('order'=>'name')), 'id', 'name'),
		),
		array(
			'name'=>'itemcategory_id',
			'value'=>'CHtml::link(CHtml::encode($data->itemcategory_name), \'#\', array(\'onclick\'=>CHtml::ajax(array(\'url\'=>url(\'itemCategory/view\',array(\'id\'=>$data->itemcategory_id)), \'success\'=>\'function(data){$("#item-category-juidialog-content").html(data);$("#item-category-juidialog").dialog("open");return false;}\'))));',
			'type'=>'raw',
			'filter'=>CHtml::listData(ItemCategory::model()->findAll(array('order'=>'name')), 'id', 'name'),
		),
		array(
			'name'=>'count',
			'filter'=>false,
		),
		array(
			'name'=>'allotted',
			'filter'=>false,
		),
		array(
			'name'=>'remaining',
			'filter'=>false,
		),
	),
)); ?>
