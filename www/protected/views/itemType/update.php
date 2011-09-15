<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Update Item Type');
?>

<h1><?php echo Yii::t('app', 'Update Item Type') . Yii::t('app', ' #') . $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>