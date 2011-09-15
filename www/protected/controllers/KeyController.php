<?php

class KeyController extends Controller
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

		if(isset($_POST['Key']))
		{
			$locks = isset($_POST['Key']['locks']) ? $_POST['Key']['locks'] : array();
			$model->locks=$locks;
		}

		if (req()->isAjaxRequest)
		{
			$this->ajaxEditForm($model, array('name'));
		}
		else
		{
			if(isset($_POST['Key']))
			{
				$model->attributes=$_POST['Key'];
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
		$dataProvider=new CActiveDataProvider('Key');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionAdmin()
	{
		$model=new Key('search');
		$model->unsetAttributes();
		if(isset($_GET['Key']))
			$model->attributes=$_GET['Key'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Key::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app', 'The requested page does not exist.'));
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='key-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
