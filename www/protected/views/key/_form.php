<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'key-form',
)); ?>

	<p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo CHtml::hiddenField('Key[dummy]'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'locks'); ?>
		<?
		$this->widget('wsext.emultiselect.EMultiSelect', array('sortable'=>false, 'language'=>app()->language, 'dividerLocation'=>0.5));
		echo CHtml::dropDownList('Key[locks][]', $model->locks, CHtml::listData(Lock::model()->findAll(), 'id', 'longname'), array('multiple'=>'multiple', 'class'=>'multiselect'));	
		?>
	</div>	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->