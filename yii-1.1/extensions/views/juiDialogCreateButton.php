<?
echo CHtml::ajaxButton($this->title, url($this->controller_id.'/create', $this->urlParams),
	array("success"=>'function(data){$("#'.$this->dialog_id.'-juidialog-content").html(data.val);$("#'.$this->dialog_id.'-juidialog").dialog("option", "modal", true).dialog("open");return false;}','dataType'=>'json'), array('id'=>'show'.ucfirst($this->dialog_id).'Dialog'));
?>
