<?
class ActiveRecord extends CActiveRecord
{
	protected $_hasTimestamp = false;
	protected $_hasIpAddress = false;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function afterConstruct()
	{
		parent::afterConstruct();
		$this->checkStamps();
	}
	
	protected function afterFind()
	{
		parent::afterFind();
		$this->checkStamps();
		$this->viewAttributes();
	}
	
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			$this->dbAttributes();
			return true;
		}
		else return false;
	}
	
	public function save($useTransaction = true, $runValidation = true,$attributes = null)
	{
		$error = '';
		$success = false;
		if ($useTransaction) $transaction = Yii::app()->db->beginTransaction();
		try 
		{
			if (!parent::save($runValidation, $attributes))
			{
				if ($useTransaction) $transaction->rollback();
				else $error = $this->getSaveErrorMsg();
			}
			else
			{
				if ($useTransaction) $transaction->commit();
				$success = true;
			}
		}
		catch (Exception $e)
		{
			if ($useTransaction) $transaction->rollback();
			$error = $this->getSaveErrorMsg($e->errorInfo[0], $e->errorInfo[1]);
		}
		if ($error != '') Yii::app()->getUser()->setFlash('error.updaterecord', Yii::t('app', $error));
		return $success;
	}
	
	protected function afterSave()
	{
		parent::afterSave();
		$this->viewAttributes();
	}
	
	public function delete($useTransaction = true)
	{
		$error = '';
		if ($useTransaction) $transaction = Yii::app()->db->beginTransaction();
		try 
		{
			if (!parent::delete())
			{
				if ($useTransaction) $transaction->rollback();
				$error = $this->getDeleteErrorMsg();
			}
			else
			{
				if ($useTransaction) $transaction->commit();
			}
		}
		catch (Exception $e)
		{
			if ($useTransaction) $transaction->rollback();
			$error = $this->getDeleteErrorMsg($e->errorInfo[0], $e->errorInfo[1]);
		}
		if ($error != '') Yii::app()->getUser()->setFlash('error.deleterecord', $error);
		return ($error == '');
	}
	
	public function dbAttributes()
	{
		if ($this->isNewRecord)
		{
			if ($this->_hasTimestamp)
			{
				$this->create_time = date('Y-m-d H:i:s');
				$this->modify_time = date('Y-m-d H:i:s');
			}
			if ($this->_hasIpAddress) $this->ip_address = Controller::IpAddressToNumber(Yii::app()->getRequest()->userHostAddress);
		}
		else
		{
			if ($this->_hasTimestamp)
			{
				$this->create_time = DT::toIsoDateTime($this->create_time);
				$this->modify_time = date('Y-m-d H:i:s');
			}
			if ($this->_hasIpAddress) $this->ip_address = Controller::IpAddressToNumber($this->ip_address);
		}

		foreach($this->metadata->tableSchema->columns as $columnName => $column)
		{
			if (strlen($this->$columnName))
			{
				if ($column->dbType == 'date')
				{
					$this->$columnName = DT::toIso($this->$columnName);
				}
				elseif ($column->dbType == 'datetime' && $columnName != 'create_time' && $columnName != 'modify_time')
					{
						$this->$columnName = DT::toIsoDateTime($this->$columnName);
					}
			}
		}
	}

	public function viewAttributes()
	{
		foreach($this->metadata->tableSchema->columns as $columnName => $column)
        {
			if (strlen($this->$columnName))
			{
				if ($column->dbType == 'date')
				{
					$this->$columnName = DT::toLoc($this->$columnName);
				}
				elseif ($column->dbType == 'datetime')
					{
						$this->$columnName = DT::toLocDateTime($this->$columnName);
					}
			}
		}
		
		if ($this->_hasIpAddress && strlen($this->ip_address)) $this->ip_address = Controller::IpAddressToText($this->ip_address);	
	}
	
	protected function checkStamps()
	{
		$this->_hasTimestamp = $this->_hasIpAddress = false;
		foreach($this->metadata->tableSchema->columns as $columnName => $column)
        {
			if ($columnName == 'create_time' || $columnName == 'modify_time') $this->_hasTimestamp = true;
			if ($columnName == 'ip_address') $this->_hasIpAddress = true;
		}
	}
	
	protected function getDeleteErrorMsg($sqlState = '', $errorCode = '')
	{
		switch ($sqlState)
		{
			case '23000':
				switch ($errorCode)
				{
					default: $errorMsg = 'Cannot delete a parent record: a foreign key constraint fails.';
					break;
				}
				break;
			default: 
				$errorMsg = 'Record cannot be deleted.';
				break;
		}
		return Yii::t('app', $errorMsg);
	}
	
	protected function getSaveErrorMsg($sqlState = '', $errorCode = '')
	{
		switch ($sqlState)
		{
			case '23000':
				switch ($errorCode)
				{
					case '1062':
						$errorMsg = 'Cannot save record: duplicate entry.';
						break;
					default:
						$errorMsg = 'Cannot save record: integrity constraint violation.';
						break;
				}
				break;
			default:
				$errorMsg = 'Record cannot be saved.';
				break;
		}
		return Yii::t('app', $errorMsg);
	}
}