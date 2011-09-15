<?php

class ButtonColumn extends CButtonColumn
{
	public $beforeDeleteMessages = '';
	public $afterDeleteMessages = '';
	
	public function init()
	{
		$this->afterDelete = 'function(link,success,jsondata){var data = jQuery.parseJSON(jsondata); '.$this->beforeDeleteMessages.' if (data.success != null && data.success != "") {$("#flash-common-success div").html(data.success);$("#flash-common-success").dialog({show:"fade",hide:"puff",modal:true,title:"'.Yii::t('app', 'Information').'",autoOpen:true,width:400,minHeight:50,buttons:{"Ok":function(){$(this).dialog("close");}}})} if (data.error != null && data.error != "") {$("#flash-common-error div").html(data.error);$("#flash-common-error").dialog({show:"fade",hide:"puff",modal:true,title:"'.Yii::t('app', 'Error').'",autoOpen:true,width:400,minHeight:50,buttons:{"Ok":function(){$(this).dialog("close");}}})} if (data.notice != null && data.notice != "") {$("#flash-common-notice div").html(data.notice);$("#flash-common-notice").dialog({show:"fade",hide:"puff",modal:true,title:"'.Yii::t('app', 'Information').'",autoOpen:true,width:400,minHeight:50,buttons:{"Ok":function(){$(this).dialog("close");}}})} '.$this->afterDeleteMessages.'}';
		
		cs()->registerCoreScript('jquery.ui');
		cs()->registerCssFile(cs()->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
		parent::init();
	}
}
?>