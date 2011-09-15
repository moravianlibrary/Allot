<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Manage Item Types');
?>

<?
$this->widget('wsext.JuiDialogForm', array('model'=>'ItemCategory'));
?>

<h1><?php echo Yii::t('app', 'Manage Item Types'); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-type-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>Yii::t('app', 'Actions'),
			'class'=>'ButtonColumn',
		),
		'name',
		array(
			'name'=>'itemcategory_id',
			'value'=>'CHtml::link(CHtml::encode($data->itemcategory_name), \'#\', array(\'onclick\'=>CHtml::ajax(array(\'url\'=>url(\'itemCategory/view\',array(\'id\'=>$data->itemcategory_id)), \'success\'=>\'function(data){$("#item-category-juidialog-content").html(data);$("#item-category-juidialog").dialog("open");return false;}\'))));',
			'type'=>'raw',
			'filter'=>CHtml::listData(ItemCategory::model()->findAll(array('order'=>'name')), 'id', 'name'),
		),
	),
)); ?>
