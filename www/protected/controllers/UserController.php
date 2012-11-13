<?php

class UserController extends Controller
{
	public function actionView($id)
	{
		$model = $this->loadModel($id);

		$actual=new Allotment('search');
		$actual->unsetAttributes();
		if(isset($_GET['Allotment']))
			user()->setState('Allotment', $_GET['Allotment']);
		if(user()->getState('Allotment'))
			$actual->attributes=user()->getState('Allotment');
		$actual->user_id = $id;
		$actual->return_date = '0000-00-00';

		$history=new Allotment('search');
		$history->unsetAttributes();
		if(isset($_GET['Allotment2']))
			user()->setState('Allotment2', $_GET['Allotment2']);
		if(user()->getState('Allotment2'))
			$history->attributes=user()->getState('Allotment2');
		$history->user_id = $id;
		if (!$history->return_status)
			$history->return_status = array_keys(DropDownItem::items('allotment.return_status'));

		if (req()->isAjaxRequest && !isset($_GET['ajax']))
		{
			$this->renderPartial('_view', array('model'=>$model));
		}
		else
		{
			$this->render('view',array('model'=>$model, 'actual'=>$actual, 'history'=>$history));
		}
	}

	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app', 'The requested page does not exist.'));
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionPrint($id)
	{
		$this->layout = '/layouts/blank';

		$model = $this->loadModel($id);

		$allotment=new Allotment('search');
		$allotment->unsetAttributes();
		if(user()->getState('Allotment'))
			$allotment->attributes=user()->getState('Allotment');
		if(!isset($_GET['history']))
			$allotment->return_date = '0000-00-00';
		$allotment->user_id = $id;
		$allotment->itemtype_name = ItemType::model()->findByPk($allotment->itemtype_id)->name;

		$this->render('print',array(
			'model'=>$model,
			'allotment'=>$allotment,
			'showHistory'=>isset($_GET['history']),
		));
	}
}
