<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lock-form',
)); ?>

	<p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo CHtml::hiddenField('Lock[dummy]'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'keys'); ?>
		<?
		$this->widget('wsext.emultiselect.EMultiSelect', array('sortable'=>false, 'language'=>app()->language, 'dividerLocation'=>0.5));
		echo CHtml::dropDownList('Lock[keys][]', $model->keys, CHtml::listData(Key::model()->findAll(), 'id', 'longname'), array('multiple'=>'multiple', 'class'=>'multiselect'));	
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'doors'); ?>
		<?
		$this->widget('wsext.emultiselect.EMultiSelect', array('sortable'=>false, 'language'=>app()->language, 'dividerLocation'=>0.5));
		echo CHtml::dropDownList('Lock[doors][]', $model->doors, CHtml::listData(Door::model()->findAll(), 'id', 'longname'), array('multiple'=>'multiple', 'class'=>'multiselect'));	
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->