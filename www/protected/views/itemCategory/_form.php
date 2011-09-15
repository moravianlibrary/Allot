<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'item-category-form',
)); ?>

	<p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ext_table'); ?>
		<?php echo $form->dropDownList($model, 'ext_table', DropDownItem::items('itemCategory.ext_table'), array("prompt"=>"&lt;".t('tables')."&gt;")); ?>
		<?php echo $form->error($model,'ext_table'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->