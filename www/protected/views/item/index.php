<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Items');
?>

<h1><?php echo Yii::t('app', 'Items'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_item',
)); ?>
