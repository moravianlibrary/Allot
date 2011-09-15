<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'View Allotment');
?>

<?
$this->widget('wsext.JuiDialogForm', array('model'=>'User'));
$this->widget('wsext.JuiDialogForm', array('model'=>'Item'));
?>

<h1><?php echo Yii::t('app', 'View Allotment') . Yii::t('app', ' #') . $model->id; ?></h1>

<?php echo $this->renderPartial('_view', array('model'=>$model)); ?>