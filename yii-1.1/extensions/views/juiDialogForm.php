<?
cs()->registerCssFile(asm()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/detailview/styles.css');

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>$this->dialog_id.'-juidialog',
	'options'=>array(
		'show'=>$this->show,
		'hide'=>$this->hide,
		'title'=>$this->title,
		'autoOpen'=>false,
		'modal'=>$this->modal,
		'width'=>$this->width,
		'height'=>$this->height,
		'draggable'=>$this->draggable,
	),
));
echo '<div id="'.$this->dialog_id.'-juidialog-content"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');

if ($this->registerScripts)
{
	if ($this->success === null || $this->forceDialog)
	{
		if ($this->success === null) $this->success = '$.fn.yiiGridView.update("'.$this->dialog_id.'-grid");';
		if ($this->controller_id == $this->controller->id) cs()->registerScript("menu-create-script", "
			var menu_create_href = jQuery('#menu-create-record').attr('href');
			jQuery('#menu-create-record').attr('href', '#');
			jQuery('#menu-create-record').click(function() {
				jQuery.ajax({'success':function(data) {
					jQuery('#".$this->dialog_id."-juidialog-content').html(data.val);
					jQuery('#".$this->dialog_id."-juidialog').dialog('option', 'modal', true).dialog('open');
					return false;
				},'url':menu_create_href,'cache':false,'dataType':'json'});
				return false;
			});
			",
			CClientScript::POS_READY);
		cs()->registerScript($this->dialog_id."-script", "
			jQuery('#".$this->dialog_id."-grid a.update').live('click',function() {
				jQuery.ajax({'success':function(data) {
					jQuery('#".$this->dialog_id."-juidialog-content').html(data.val);
					jQuery('#".$this->dialog_id."-juidialog').dialog('option', 'modal', true).dialog('open');
					return false;
				},'url':\$(this).attr('href'),'cache':false,'dataType':'json'});
				return false;
			});
			jQuery('#".$this->dialog_id."-grid a.view').live('click',function() {
				jQuery.ajax({'success':function(data) {
					jQuery('#".$this->dialog_id."-juidialog-content').html(data);
					jQuery('#".$this->dialog_id."-juidialog').dialog('option', 'modal', true).dialog('open');
					return false;
				},'url':\$(this).attr('href'),'cache':false,'dataType':'html'});
				return false;
			});
			",
			CClientScript::POS_READY);
	}
	cs()->registerScript('close'.ucfirst($this->dialog_id).'Dialog-script', "
		jQuery('#".$this->dialog_id."-juidialog-content form').live('submit',function() {
			jQuery.ajax({'success': function(data) {
				if (data.status == 'OK')
				{
					jQuery('#".$this->dialog_id."-juidialog-content').empty();
					jQuery('#".$this->dialog_id."-juidialog').dialog('close');
					".$this->success."
					if (data.msg != '')
					{
						jQuery('#flash-common-success div').html(data.msg);
						jQuery('#flash-common-success').dialog({show:'fade', hide:'puff', modal:true, title:'".Yii::t('app', 'Information')."', autoOpen:true, width:400, minHeight:50, buttons:{'Ok':function(){\$(this).dialog('close');}}});
					}
				}
				else
				{
					jQuery('#".$this->dialog_id."-juidialog-content').html(data.val);
					if (data.msg != '')
					{
						jQuery('#flash-common-error div').html(data.msg);
						jQuery('#flash-common-error').dialog({show:'fade', hide:'puff', modal:true, title:'".Yii::t('app', 'Error')."', autoOpen:true, width:400, minHeight:50, buttons:{'Ok':function(){\$(this).dialog('close');}}});
					}
				}
				return false;
			},'type':'POST','url':jQuery(this).attr('action'),'cache':false,'data':jQuery(this).serialize(),'dataType':'json'});
			return false;
		});",
		CClientScript::POS_READY);
}
?>
