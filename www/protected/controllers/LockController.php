<?php

class LockController extends Controller
{
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		
		if (req()->isAjaxRequest)
		{
			$this->renderPartial('_view', array('model'=>$model));
		}
		else
		{
			$this->render('view',array('model'=>$model));
		}
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Lock']))
		{		
			$keys = isset($_POST['Lock']['keys']) ? $_POST['Lock']['keys'] : array();
			$model->keys=$keys;
			$doors = isset($_POST['Lock']['doors']) ? $_POST['Lock']['doors'] : array();
			$model->doors=$doors;
		}
		
		if (req()->isAjaxRequest)
		{
			$this->ajaxEditForm($model, array('name'));
		}
		else
		{
			if(isset($_POST['Lock']))
			{
				$model->attributes=$_POST['Lock'];
				if($model->save())
					$this->redirect(array('admin'));
				else
					$model->viewAttributes();
			}

			$this->render('update',array(
				'model'=>$model,
			));
		}
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Lock');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new Lock('search');
		$model->unsetAttributes();
		if(isset($_GET['Lock']))
			$model->attributes=$_GET['Lock'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Lock::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app', 'The requested page does not exist.'));
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lock-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
