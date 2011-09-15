<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Manage Users');
?>

<h1><?php echo Yii::t('app', 'Manage Users'); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>Yii::t('app', 'Actions'),
			'class'=>'ButtonColumn',
			'template'=>'{view}',
		),
		'username',
		'firstname',
		'lastname',
		array(
			'name'=>'email',
			'value'=>'CHtml::mailto(CHtml::encode($data->email), $data->email)',
			'type'=>'raw',
		),
	),
)); ?>
