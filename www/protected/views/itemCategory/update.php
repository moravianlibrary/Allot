<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Update Item Category');
?>

<h1><?php echo Yii::t('app', 'Update Item Category') . Yii::t('app', ' #') . $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>