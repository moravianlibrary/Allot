<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Update Key');
?>

<h1><?php echo Yii::t('app', 'Update Key') . Yii::t('app', ' #') . $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>