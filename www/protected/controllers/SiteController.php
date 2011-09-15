<?php

class SiteController extends Controller
{
	public $defaultAction = 'login';
	
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	public function actionLogin()
	{
		if (!user()->isGuest) $this->redirect(url('/site/page', array('view'=>'about')));
		
		$model=new LoginForm;

		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			if($model->validate() && $model->login())
			{
				if (am()->checkAccess('Administrator', user()->id))
				{
					sess()->add('PMA_single_signon_user', Yii::app()->db->username);
					sess()->add('PMA_single_signon_password', Yii::app()->db->password);
				}
				$this->redirect(url('/site/page', array('view'=>'about'))); //index.php?r=site/page&view=FileName
			}
		}
		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionSetting()
	{
		$this->render('setting');
	}
}