<?php

class AjaxController extends Controller
{
	public function actionSetactivetab($active_tab)
	{
		user()->setState('active_tab', str_replace('#', '', $active_tab));
		echo CJSON::encode(array('status'=>'OK', 'val'=>'', 'model'=>array()));
		Yii::app()->end();
	}
}