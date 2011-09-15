<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'item-type-form',
)); ?>

	<p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'itemcategory_id'); ?>
		<?php echo $form->dropDownList($model,'itemcategory_id', CHtml::listData(ItemCategory::model()->findAll(), 'id', 'name'), array("prompt"=>"&lt;".t('item categories')."&gt;")); ?>		
		<?php echo $form->error($model,'itemcategory_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->