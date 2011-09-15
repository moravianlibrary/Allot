<?
class Controller extends CController
{
	public $defaultAction = 'admin';
	public $layout = '//layouts/column2';
	public $menu = null;

	protected function beforeAction($action)
    {
		$this->menu = new Menu($this->route);
		if (parent::beforeAction($action))
		{
			$modelClass = ucfirst($this->getId());
			$route = $modelClass.':'.ucfirst($action->getId());
			if ($route == 'Site:Error' || $route == 'Site:Login' || $route == 'Site:Logout' || $route == 'Ajax:Setactivetab') 
			{
				return true;
			}
			else
			{
				$params = array();
				if (isset($_GET['id']) && is_numeric($_GET['id']))
				{
					$id = (int) $_GET['id'];
					$user_id = 0;
					$model = CActiveRecord::model($modelClass)->resetScope()->findByPk($id);
					if($model===null) throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
					if (isset($model->user_id))
					{
						$user_id = $model->user_id;
						if (user()->checkAccess('Administrator')) $user_id = user()->id;
					}
					$params['user_id'] = $user_id;
				}
				if (user()->checkAccess($route, $params))
				{
					return true;
				}
				else
				{
					throw new CHttpException(403, Yii::t('app', 'Access denied.'));
				}
			}
		}
    }
    
	public function ajaxEditForm(&$model, $returnData = array(), $continueController = false)
	{
		$saved = false;
		$status = 'OK'; $msg = ''; $retData = array();
		$modelClass = ucfirst($this->getId());
		if(isset($_POST[$modelClass]))
		{
			$model->attributes = $_POST[$modelClass];

			if($model->save())
			{
				$saved = true;
				if ($returnData != array())
				{
					$retData['id'] = $model->id;
					//foreach ($returnData as $attr) $retData[$attr] = $model->$attr;
					foreach ($returnData as $attr)
					{
						$attrs = explode('.', $attr);
						$m = $model;
						foreach ($attrs as $a)
							$m = $m->$a;
						$retData = $m;
						for ($i = sizeof($attrs) - 1; $i >= 0; $i--)
							$retData = array($attrs[$i] => $retData);
					}
				}
			}
			else
			{
				$model->viewAttributes();
				$status = 'ERR';
				if (Yii::app()->getUser()->hasFlash('error.updaterecord')) $msg = Yii::app()->getUser()->getFlash('error.updaterecord');
			}
		}
		
		$this->ajaxEditFormNoScript();
		
		$a = array('status'=>$status, 'val'=>$this->renderPartial('_form', array('model'=>$model), true, true), 'model'=>$retData, 'msg'=>$msg);
		
		if ($continueController) return array('saved'=>$saved, 'data'=>$a);
		else
		{
			echo CJSON::encode($a);
			Yii::app()->end();
		}
	}
	
	public function ajaxEditFormNoScript()
	{
		cs()->scriptMap['jquery.js'] = false;
		cs()->scriptMap['jquery.min.js'] = false;
		cs()->scriptMap['jquery-ui.js'] = false;
		cs()->scriptMap['jquery-ui.min.js'] = false;
		cs()->scriptMap['jquery-ui-i18n.js'] = false;
		cs()->scriptMap['jquery-ui-i18n.min.js'] = false;
	}
	
	public function insertDialog($params = array(), $enableSelfDialog = false)
	{
		$model = ucfirst($this->id);		
		$items = array_merge(array('User', 'StockActivity'), Menu::$mainMenuItems);	
		foreach ($items as $item)
		{
			if (!array_key_exists($item, $params)) $params[$item] = array();
			if ($item == $model && !$enableSelfDialog)
			{
				$params[$item]['registerScripts'] = false;
			}
			$this->widget('wsext.JuiDialogForm', array_merge(array('model'=>$item), $params[$item]));
		}
	}
	
	public function autoCompleteFind($modelClass, $field, $retField = null, $extraCrits = array())
	{
		$term = $_GET['term'];
		if ($retField === null) $retField = $field;
		if (isset($term))
		{
			$criteria = new CDbCriteria;
			$criteria->compare($field, $term, true);
			if (isset($extraCrits['condition'])) foreach ($extraCrits['condition'] as $extraCrit) $criteria->compare($extraCrit[0], $extraCrit[1], $extraCrit[2]);
			$criteria->order = $field;
			$criteria->limit = 20;
			if (isset($extraCrits['with'])) $criteria->with = $extraCrits['with'];
			$model = CActiveRecord::model($modelClass)->findAll($criteria);
			if (!empty($model)) 
			{
				$out = array();
				foreach ($model as $m)
				{
					$out[] = array(
					'label' => $m->$retField,  
					'value' => $m->$retField,
					'id' => $m->id, // return value from autocomplete
					);
				}
				echo CJSON::encode($out);
				Yii::app()->end();
			}
		}
	}
	
	public static function IpAddressToNumber($ip)
	{
		if ($ip == '') return 0;
		else
		{
			$aip = explode('.', $ip);
			if (sizeof($aip) != 4) return 0;
			else return ($aip[3] + $aip[2] * 256 + $aip[1] * 256 * 256 + $aip[0] * 256 * 256 * 256);
		}
	}	
	
	public static function IpAddressToText($ip)
	{
		if (!$ip) return '0.0.0.0';
		else 
		{
			for ($i = 3; $i >= 0; $i--)
			{
				$p = pow(256, $i);
				$n = floor($ip / $p);
				$ret .= $n.'.';
				$ip -= $n*$p;
			}
			return substr($ret, 0, -1);
		}
	}
	
	protected function pluralize($name)
	{
		$rules=array(
				'/(x|ch|ss|sh|us|as|is|os)$/i' => '\1es',
				'/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
				'/(m)an$/i' => '\1en',
				'/(child)$/i' => '\1ren',
				'/(r|t)y$/i' => '\1ies',
				'/s$/' => 's',
		);
		foreach($rules as $rule=>$replacement)
		{
				if(preg_match($rule,$name))
						return preg_replace($rule,$replacement,$name);
		}
		return $name.'s';
	}
	
	public function class2name($name,$ucwords=true)
	{
		$result=trim(strtolower(str_replace('_',' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $name))));
		return $ucwords ? ucwords($result) : $result;
	}

	public function class2id($name)
	{
		return trim(strtolower(str_replace('_','-',preg_replace('/(?<![A-Z])[A-Z]/', '-\0', $name))),'-');
	}
	
	public function class2var($name)
	{
			$name[0]=strtolower($name[0]);
			return $name;
	}
}
