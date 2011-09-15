<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'item-form',
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
		<?php echo $form->labelEx($model,'itemtype_id'); ?>
		<?php echo $form->dropDownList($model,'itemtype_id', CHtml::listData(ItemType::model()->findAll(), 'id', 'longname'), array("prompt"=>"&lt;".t('item types')."&gt;")); ?>		
		<?php echo $form->error($model,'itemtype_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'count'); ?>
		<?php echo $form->textField($model,'count',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'allotted'); ?>
		<?php echo CHtml::textField('allotted', $model->allotted, array('size'=>5, 'readonly'=>'readonly', 'class'=>'readonly')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'remaining'); ?>
		<?php echo CHtml::textField('remaining', $model->remaining, array('size'=>5, 'readonly'=>'readonly', 'class'=>'readonly')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->