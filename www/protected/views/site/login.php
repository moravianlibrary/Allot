<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'System Login');
?>

<h1><?php echo Yii::t('app', 'User Login'); ?></h1>

<p><?php echo Yii::t('app', 'Please fill out the following form with your login credentials'); ?>:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
)); ?>

	<p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Login')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
