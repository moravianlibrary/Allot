<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Manage Keys');
?>

<h1><?php echo Yii::t('app', 'Manage Keys'); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'key-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>Yii::t('app', 'Actions'),
			'class'=>'ButtonColumn',
			'template'=>'{view} {update}'
		),
		'number',
		'name',
		array(
			'name'=>'count',
			'filter'=>false,
		),
		array(
			'name'=>'allotted',
			'filter'=>false,
		),
	),
)); ?>
