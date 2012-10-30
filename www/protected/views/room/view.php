<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'View Room');
?>

<?
$this->widget('wsext.JuiDialogForm', array('model'=>'Building'));
?>

<h1><?php echo Yii::t('app', 'View Room') . Yii::t('app', ' #') . $model->id; ?></h1>

<?php echo $this->renderPartial('_view', array('model'=>$model)); ?>