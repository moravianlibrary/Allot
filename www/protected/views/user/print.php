<div class="noprint">
<fieldset>
	<legend><?echo t('Filter')?></legend>
	<?
	echo CHtml::beginForm(url('user/print', array('id'=>$model->id)), 'get');
	echo t('Print History').': '.CHtml::checkBox('history', $showHistory);
	echo "&nbsp;&nbsp;&nbsp;".CHtml::submitButton(t('Apply'));
	echo CHtml::endForm();
	echo "<br />";
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$allotment,
		'cssFile'=>false,
		'nullDisplay'=>'',
		'itemTemplate'=>"<tr class=\"{class}\"><td style=\"text-align: left; font-weight: bold;\">{label}</td><td>{value}</td></tr>\n",
		'attributes'=>array(
			'item_name',
			'itemtype_name',
			'count',
			'allotment_date',
		),
	)); ?>
</fieldset>
</div>

<h1>Karta předmětu<?if ($allotment->itemtype_name) echo ': '.$allotment->itemtype_name?></h1>

<h2>Přebírající</h2>
<?php echo $model->full_name; ?>

<br /><br />

<h2>Předávající</h2>
<?php echo user()->full_name; ?>

<br /><br />

<h2><?php echo t('Allotments'); ?></h2>
<?php
$columns = array(
	array(
		'header'=>'Pol.',
		'value'=>'$row + 1',
	),
	array(
		'header'=>'Datum předání',
		'name'=>'allotment_date',
	)
);
if (!$allotment->itemtype_name)
	$columns = array_merge(
		$columns,
		array(
			array(
				'header'=>'Název předmětu',
				'name'=>'item_name',
			),
		)
	);
$columns = array_merge(
	$columns,
	array(
		array(
			'header'=>'Číslo předmětu',
			'name'=>'item.number',
		),
		array(
			'header'=>'Počet předaných kusů',
			'name'=>'count',
		),
	)
);
if ($showHistory)
	$columns = array_merge(
		$columns,
		array(
			'return_date',
			'return_status_f',
		)
	);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'basic-list',
	'dataProvider'=>$allotment->search(),
	'template'=>'{items}',
	'emptyText'=>'',
	'enableSorting'=>false,
	'itemsCssClass'=>'blackborder',
	'columns'=>$columns,
	));
?>
