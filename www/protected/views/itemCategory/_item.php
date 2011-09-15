<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ext_table')); ?>:</b>
	<?php echo CHtml::encode(DropDownItem::item('itemCategory.ext_table', $data->ext_table)); ?>
	<br />

</div>