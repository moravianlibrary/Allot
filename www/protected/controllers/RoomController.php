<?php

class RoomController extends Controller
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
		$model=new Room;

		if(isset($_POST['Room']))
		{
			$doors = isset($_POST['Room']['doors']) ? $_POST['Room']['doors'] : array();
			$model->doors=$doors;
		}
			
		if (req()->isAjaxRequest)
		{
			$this->ajaxEditForm($model, array('name'));
		}
		else
		{
			if(isset($_POST['Room']))
			{
				$model->attributes=$_POST['Room'];
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

		if(isset($_POST['Room']))
		{
			$doors = isset($_POST['Room']['doors']) ? $_POST['Room']['doors'] : array();
			$model->doors=$doors;
		}
			
		if (req()->isAjaxRequest)
		{
			$this->ajaxEditForm($model, array('name'));
		}
		else
		{
			if(isset($_POST['Room']))
			{
				$model->attributes=$_POST['Room'];
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
		$dataProvider=new CActiveDataProvider('Room');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new Room('search');
		$model->unsetAttributes();
		if(isset($_GET['Room']))
			$model->attributes=$_GET['Room'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Room::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app', 'The requested page does not exist.'));
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='room-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
