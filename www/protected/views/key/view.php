<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'View Key');
?>

<h1><?php echo Yii::t('app', 'View Key') . Yii::t('app', ' #') . $model->id; ?></h1>

<?php echo $this->renderPartial('_view', array('model'=>$model)); ?>