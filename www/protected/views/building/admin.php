<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Manage Buildings');
?>

<h1><?php echo Yii::t('app', 'Manage Buildings'); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'building-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>Yii::t('app', 'Actions'),
			'class'=>'ButtonColumn',
		),
		'name',
		'street',
		'land_registry_number',
		'house_number',
		'postal_code',
		'city',
	),
)); ?>
