<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('number')); ?>:</b>
	<?php echo CHtml::encode($data->number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemtype_name')); ?>:</b>
	<?php echo CHtml::encode($data->itemtype_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('count')); ?>:</b>
	<?php echo CHtml::encode($data->count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allotted')); ?>:</b>
	<?php echo CHtml::encode($data->allotted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remaining')); ?>:</b>
	<?php echo CHtml::encode($data->remaining); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode(t('Allotments')); ?>:</b>
	<?php echo CHtml::link(t('Create Allotment'), array('allotment/create', 'item_id'=>$data->id)); ?>
	<br />

</div>