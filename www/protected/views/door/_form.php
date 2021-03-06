<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'door-form',
)); ?>

	<p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'number'); ?>
		<?php echo $form->textField($model,'number',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'locks'); ?>
		<?
		$this->widget('wsext.emultiselect.EMultiSelect', array('sortable'=>false, 'language'=>app()->language, 'dividerLocation'=>0.5));
		echo CHtml::dropDownList('Door[locks][]', $model->locks, CHtml::listData(Lock::model()->findAll(), 'id', 'longname'), array('multiple'=>'multiple', 'class'=>'multiselect'));	
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rooms'); ?>
		<?
		$this->widget('wsext.emultiselect.EMultiSelect', array('sortable'=>false, 'language'=>app()->language, 'dividerLocation'=>0.5));
		echo CHtml::dropDownList('Door[rooms][]', $model->rooms, CHtml::listData(Room::model()->findAll(), 'id', 'longname'), array('multiple'=>'multiple', 'class'=>'multiselect'));	
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->