<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?echo app()->language?>" lang="<?echo app()->language?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="<?echo app()->language?>" />
	
	<?
	cs()->registerCoreScript('jquery.ui');
	cs()->registerCssFile(cs()->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
	?>

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
	<div id="flash-common-success" style="display: none;"><div class="flash-success" style="margin-bottom: 0;"></div></div>
	<div id="flash-common-error" style="display: none;"><div class="flash-error" style="margin-bottom: 0;"></div></div>
	<div id="flash-common-notice" style="display: none;"><div class="flash-notice" style="margin-bottom: 0;"></div></div>
	<?
	if ($flashes = user()->getFlashes()) 
	{
		foreach ($flashes as $k=>$msg)
		{
			if ($k == 'counters') continue;
			$a = explode('.', $k);
			$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id'=>str_replace('.', '_', $k),
				'options'=>array(
					'show' => 'fade',
					'hide' => 'puff',
					'modal' => 'true',
					'title' => t(ucfirst($a[0])),
					'autoOpen'=>true,
					'width'=>'400',
					'height'=>'auto',
					'minHeight'=>50,
					'buttons'=>array(
						'Ok'=>'js:function(){$(this).dialog("close");}',
						),
					),
				));
				echo "<div class=\"flash-{$a[0]}\" style=\"margin-bottom: 0;\" id=\"{$a[1]}\">${msg}</div>";
			$this->endWidget('zii.widgets.jui.CJuiDialog');
		}
	}
	?>
	<div id="header">
		<div id="logo"><?php echo CHtml::link(CHtml::encode(Yii::app()->name), Yii::app()->createUrl('/site/page', array('view'=>'about'))); ?></div>
		<?if (!Yii::app()->user->isGuest) {?><div id="username"><?php echo Yii::t('app', 'User'); ?>: <?php echo CHtml::encode(user()->full_name); ?> | <?echo CHtml::link(Yii::t('app', 'Logout'), array('/site/logout'))?></div><?}?>
		<div class="clear"></div>
	</div><!-- header -->

	<?if (!Yii::app()->user->isGuest) {?>

	<div id="mainmenu">
		<?
		$this->widget('zii.widgets.CMenu',array(
			'items'=>$this->menu->items('_main'),
		)); ?>
		<div class="clear"></div>
	</div><!-- mainmenu -->

	<?}?>

	<?/*php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif*/?>

	<?php echo $content; ?>

	<?/*
	<div id="footer">
		&copy; <?php echo date('Y'); ?> <a href="http://www.mzk.cz/">Moravská zemská knihovna v Brně</a>, <a href="http://www.webstep.net/">WebStep s.r.o.</a><br/>
		Všechna práva vyhrazena.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->
	*/?>

</div><!-- page -->

</body>
</html>