<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Manage Doors');
?>

<?
$this->widget('wsext.JuiDialogForm', array('model'=>'Building'));
?>

<h1><?php echo Yii::t('app', 'Manage Doors'); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'door-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>Yii::t('app', 'Actions'),
			'class'=>'ButtonColumn',
		),
		'number',
		'name',
		'floor',
		array(
			'name'=>'building_id',
			'value'=>'CHtml::link(CHtml::encode($data->building_name), \'#\', array(\'onclick\'=>CHtml::ajax(array(\'url\'=>url(\'building/view\',array(\'id\'=>$data->building_id)), \'success\'=>\'function(data){$("#building-juidialog-content").html(data);$("#building-juidialog").dialog("open");return false;}\'))));',
			'type'=>'raw',
			'filter'=>CHtml::listData(Building::model()->findAll(array('order'=>'name')), 'id', 'name'),
		),
	),
)); ?>
