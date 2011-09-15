<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_full_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_id')); ?>:</b>
	<?php echo CHtml::encode($data->item_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('count')); ?>:</b>
	<?php echo CHtml::encode($data->count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allotment_date')); ?>:</b>
	<?php echo CHtml::encode($data->allotment_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('return_date')); ?>:</b>
	<?php echo CHtml::encode($data->return_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('return_status')); ?>:</b>
	<?php echo CHtml::encode(DropDownItem::item('allotment.return_status', $data->return_status)); ?>
	<br />

</div>