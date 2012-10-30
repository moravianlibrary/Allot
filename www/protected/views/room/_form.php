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
		<?php echo $form->labelEx($model,'floor'); ?>
		<?php echo $form->textField($model,'floor',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'floor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'building_id'); ?>
		<?php echo $form->dropDownList($model,'building_id', CHtml::listData(Building::model()->findAll(), 'id', 'name'), array("prompt"=>"&lt;".t('buildings')."&gt;")); ?>		
		<?php echo $form->error($model,'activity_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'doors'); ?>
		<?
		$this->widget('wsext.emultiselect.EMultiSelect', array('sortable'=>false, 'language'=>app()->language, 'dividerLocation'=>0.5));
		echo CHtml::dropDownList('Room[doors][]', $model->doors, CHtml::listData(Door::model()->findAll(), 'id', 'longname'), array('multiple'=>'multiple', 'class'=>'multiselect'));	
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->