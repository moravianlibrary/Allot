<?
$this->widget('wsext.JuiDialogForm', array('model'=>'Item', 'success'=>"\$('#Allotment_item_id').val(data.model.id);\$('#item_id_save').val(data.model.name);\$('#item_id_lookup').val(data.model.name);"));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'allotment-form',
)); ?>

	<p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?
		$this->widget('wsext.EJuiAutoCompleteFkField', array(
			'model'=>$model, 
			'attribute'=>'userName',
			'sourceUrl'=>array('findUser'), 
			'relName'=>'user',
			'displayAttr'=>'full_name',
			'autoCompleteLength'=>60,
			'options'=>array(
				'minLength'=>1, 
			),
		));
		?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item_id'); ?>
		<?php
		if ($model->isNewRecord) 
		{
			$this->widget('wsext.EJuiAutoCompleteFkField', array(
				'model'=>$model, 
				'attribute'=>'item_id',
				'sourceUrl'=>array('findItem'), 
				'relName'=>'item',
				'displayAttr'=>'longname',
				'autoCompleteLength'=>60,
				'options'=>array(
					'minLength'=>1, 
				),
			));
			if (user()->checkAccess('ItemAdmin')) $this->widget('wsext.JuiDialogCreateButton', array('model'=>'Item'));
		}
		else
			echo CHtml::textField('item_id', $model->item->name, array('size'=>60, 'readonly'=>'readonly', 'class'=>'readonly'));
		?>
		<?php echo $form->error($model,'item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'count'); ?>
		<?php if ($model->isNewRecord || !$model->returned) echo $form->textField($model,'count',array('size'=>5,'maxlength'=>5)); else echo CHtml::textField('count', $model->count, array('size'=>5, 'readonly'=>'readonly', 'class'=>'readonly')); ?>
		<?php echo $form->error($model,'count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'allotment_date'); ?>
		<?
		$htmlOptions = array();
		if ($model->hasErrors('allotment_date')) $htmlOptions = array('class'=>'error');
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'Allotment[allotment_date]',
			'language'=>app()->language,
			'value'=>($model->allotment_date == '' ? DT::locToday() : $model->allotment_date),
			'options'=>array(
				'showAnim'=>'fold',
				'dateFormat'=>'d.m.yy',
			),
			'htmlOptions'=>$htmlOptions,
		));
		?>
		<?php echo $form->error($model,'allotment_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'return_date'); ?>
		<?
		$htmlOptions = array();
		if ($model->hasErrors('return_date')) $htmlOptions = array('class'=>'error');
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'Allotment[return_date]',
			'language'=>app()->language,
			'value'=>$model->return_date,
			'options'=>array(
				'showAnim'=>'fold',
				'dateFormat'=>'d.m.yy',
			),
			'htmlOptions'=>$htmlOptions,
		));
		?>
		<?php echo $form->error($model,'return_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'return_status'); ?>
		<?php echo $form->dropDownList($model, 'return_status', DropDownItem::items('allotment.return_status'), array("prompt"=>"&lt;".t('statusses')."&gt;")); ?>
		<?php echo $form->error($model,'return_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->