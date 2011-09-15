<?php
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app', 'Create Door');
?>

<h1><?php echo Yii::t('app', 'Create Door'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>