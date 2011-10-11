<?php

class AllotmentController extends Controller
{
	public function actionView($id)
	{
		$model=Allotment::model()->my()->findByPk($id);
		
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
		$model=new Allotment;
		
		if (isset($_GET['item_id'])) $model->item_id = $_GET['item_id'];
		
		if (isset($_POST['Allotment']))
		{
			$model->userName = $_POST['Allotment']['userName'];
			$model->user_id = $this->refreshUser($model->userName);
			$model->user = User::model()->findByPk($model->user_id);
		}
		
		if (req()->isAjaxRequest)
		{
			$this->ajaxEditForm($model, array());
		}
		else
		{
			if(isset($_POST['Allotment']))
			{
				$model->attributes=$_POST['Allotment'];
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

		if (isset($_POST['Allotment']))
		{
			$model->userName = $_POST['Allotment']['userName'];
			$model->user_id = $this->refreshUser($model->userName);
			$model->user = User::model()->findByPk($model->user_id);
		}

		if (req()->isAjaxRequest)
		{
			$this->ajaxEditForm($model, array());
		}
		else
		{
			if(isset($_POST['Allotment']))
			{
				$model->attributes=$_POST['Allotment'];
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
		$dataProvider=new CActiveDataProvider(Allotment::model()->my());
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new Allotment('search');
		$model->unsetAttributes();
		if(isset($_GET['Allotment']))
			$model->attributes=$_GET['Allotment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Allotment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app', 'The requested page does not exist.'));
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='allotment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/*
	public function actionFindUser()
	{
		$this->autoCompleteFind('User', 'CONCAT(firstname, \' \', lastname)', 'full_name');
	}	
	*/
	public function actionFindUser()
	{
		$term = $_GET['term'];
		if (isset($term))
		{
			$ds = $this->ldapConnect();
			if ($ds)
			{
				$sr = ldap_search($ds, param('ldap_users_dn'), '(|(sn=*'.$term.'*)(givenname=*'.$term.'*))', array('uid', 'givenname', 'sn'));
				if ($sr)
				{
					$entries = ldap_get_entries($ds, $sr);
					$out = array();
					foreach ($entries as $entry)
					{
						$out[] = array(
						'label' => $entry['givenname'][0].' '.$entry['sn'][0],  
						'value' => $entry['givenname'][0].' '.$entry['sn'][0],
						'id' => $entry['uid'][0], // return value from autocomplete
						);
					}
					echo CJSON::encode($out);
					Yii::app()->end();
				}
				ldap_close($ds);
				$ds = null;
			}
		}
	}
	
	public function actionFindItem()
	{
		$this->autoCompleteFind('Item', 'CONCAT(number, \' \', name)', 'longname', array('condition'=>array(array('(count-allotted)', '>0', false))));
	}
	
	public function refreshUser($userName)
	{
		$user = User::model()->findByAttributes(array('username'=>$userName));
		if ($user === null)
			$user = new User;

		$ds = $this->ldapConnect();
		if ($ds)
		{
			$sr = ldap_search($ds, param('ldap_users_dn'), '(uid='.$userName.')', array('uid', 'givenname', 'sn', 'mail'));
			if ($sr)
			{
				$entries = ldap_get_entries($ds, $sr);
				if ($entries['count'] == 1)
				{
					$user->username = $entries[0]['uid'][0];
					$user->firstname = $entries[0]['givenname'][0];
					$user->lastname = $entries[0]['sn'][0];			
					$user->email = $entries[0]['mail'][0];
				}
			}
			ldap_close($ds);
			$ds = null;
		}
		
		if ($user !== null)
		{
			$user->save();
			return $user->id;
		}
		else
		{
			user()->setFlash('error.refresh_user', t('Error during user assignment.'));
			return 0;
		}
	}
	
	public function ldapConnect()
	{
		$ds = ldap_connect(param('ldap_server'));
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
		return $ds;
	}
}
