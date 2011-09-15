<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Manage Item Categories');
?>

<h1><?php echo Yii::t('app', 'Manage Item Categories'); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>Yii::t('app', 'Actions'),
			'class'=>'ButtonColumn',
		),
		'name',
		array(
			'name'=>'ext_table',
			'value'=>'DropDownItem::item(\'itemCategory.ext_table\', $data->ext_table)',
			'filter'=>DropDownItem::items('itemCategory.ext_table'),
		),
	),
)); ?>
