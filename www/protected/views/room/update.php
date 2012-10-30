<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Update Room');
?>

<h1><?php echo Yii::t('app', 'Update Room') . Yii::t('app', ' #') . $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>