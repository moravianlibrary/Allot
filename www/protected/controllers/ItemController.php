<?php

class ItemController extends Controller
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

	public function actionCreate()
	{
		$model=new Item;

		if (req()->isAjaxRequest)
		{
			$this->ajaxEditForm($model, array('name'));
		}
		else
		{
			if(isset($_POST['Item']))
			{
				$model->attributes=$_POST['Item'];
				if($model->save())
					$this->redirect(array('admin'));
				else
					$model->viewAttributes();
			}

			$this->render('create',array(
				'model'=>$model,
			));
		}
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if (req()->isAjaxRequest)
		{
			$this->ajaxEditForm($model, array('name'));
		}
		else
		{
			if(isset($_POST['Item']))
			{
				$model->attributes=$_POST['Item'];
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

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			else
			{
				echo CJSON::encode(array('success'=>(Yii::app()->getUser()->hasFlash('success.deleterecord')?Yii::app()->getUser()->getFlash('success.deleterecord'):''), 'error'=>(Yii::app()->getUser()->hasFlash('error.deleterecord')?Yii::app()->getUser()->getFlash('error.deleterecord'):''), 'notice'=>(Yii::app()->getUser()->hasFlash('notice.deleterecord')?Yii::app()->getUser()->getFlash('notice.deleterecord'):'')));
				Yii::app()->end();
			}
		}
		else
			throw new CHttpException(400,Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Item');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new Item('search');
		$model->unsetAttributes();
		if(isset($_GET['Item']))
			$model->attributes=$_GET['Item'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Item::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app', 'The requested page does not exist.'));
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
