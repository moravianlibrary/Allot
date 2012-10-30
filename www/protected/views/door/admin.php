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
	),
)); ?>
