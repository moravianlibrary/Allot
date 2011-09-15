<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Update Allotment');
?>

<h1><?php echo Yii::t('app', 'Update Allotment') . Yii::t('app', ' #') . $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>