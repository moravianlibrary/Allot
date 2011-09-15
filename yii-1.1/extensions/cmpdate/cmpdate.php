<?php
class cmpdate extends CValidator
{
	public $compareAttribute;
	public $compareValue;
	public $allowEmpty=false;
	public $operator='=';

	protected function validateAttribute($object,$attribute)
	{
		$value=DT::toIso($object->$attribute);
		if($this->allowEmpty && $this->isEmpty($value))
			return;
		if($this->compareValue!==null)
		{
			$compareValue=$this->compareValue;
			$compareTo=DT::toLoc($this->compareValue);
		}
		else
		{
			$compareAttribute=$this->compareAttribute===null ? $attribute.'_repeat' : $this->compareAttribute;
			$compareValue=DT::toIso($object->$compareAttribute);
			$compareTo=$object->getAttributeLabel($compareAttribute);
		}

		switch($this->operator)
		{
			case '=':
			case '==':
				if($value!=$compareValue)
				{
					$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} must be repeated exactly.');
					$this->addError($object,$attribute,$message,array('{compareAttribute}'=>$compareTo));
				}
				break;
			case '!=':
				if($value==$compareValue)
				{
					$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} must not be equal to "{compareValue}".');
					$this->addError($object,$attribute,$message,array('{compareAttribute}'=>$compareTo,'{compareValue}'=>DT::toLoc($compareValue)));
				}
				break;
			case '>':
				if($value<=$compareValue)
				{
					$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} must be greater than "{compareValue}".');
					$this->addError($object,$attribute,$message,array('{compareAttribute}'=>$compareTo,'{compareValue}'=>DT::toLoc($compareValue)));
				}
				break;
			case '>=':
				if($value<$compareValue)
				{
					$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} must be greater than or equal to "{compareValue}".');
					$this->addError($object,$attribute,$message,array('{compareAttribute}'=>$compareTo,'{compareValue}'=>DT::toLoc($compareValue)));
				}
				break;
			case '<':
				if($value>=$compareValue)
				{
					$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} must be less than "{compareValue}".');
					$this->addError($object,$attribute,$message,array('{compareAttribute}'=>$compareTo,'{compareValue}'=>DT::toLoc($compareValue)));
				}
				break;
			case '<=':
				if($value>$compareValue)
				{
					$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} must be less than or equal to "{compareValue}".');
					$this->addError($object,$attribute,$message,array('{compareAttribute}'=>$compareTo,'{compareValue}'=>DT::toLoc($compareValue)));
				}
				break;
			default:
				throw new CException(Yii::t('yii','Invalid operator "{operator}".',array('{operator}'=>$this->operator)));
		}
	}

	public function clientValidateAttribute($object,$attribute)
	{
		$baseUrl = asm()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
		cs()->registerScriptFile($baseUrl.DIRECTORY_SEPARATOR.'cmpdate.js', CClientScript::POS_END);
	
		if($this->compareValue !== null)
		{
			$compareValue=CJSON::encode($this->compareValue);
			$compareTo=DT::toLoc($this->compareValue);
		}
		else
		{
			$compareAttribute=$this->compareAttribute === null ? $attribute . '_repeat' : $this->compareAttribute;
			$compareValue="CStoIsoDate(\$('#" . (CHtml::activeId($object, $compareAttribute)) . "').val())";
			$compareTo=$object->getAttributeLabel($compareAttribute);
		}

		$message=$this->message;
		switch($this->operator)
		{
			case '=':
			case '==':
				if($message===null)
					$message=Yii::t('yii','{attribute} must be repeated exactly.');
				$condition='CStoIsoDate(value)!='.$compareValue;
				break;
			case '!=':
				if($message===null)
					$message=Yii::t('yii','{attribute} must not be equal to "{compareValue}".');
				$condition='CStoIsoDate(value)=='.$compareValue;
				break;
			case '>':
				if($message===null)
					$message=Yii::t('yii','{attribute} must be greater than "{compareValue}".');
				$condition='CStoIsoDate(value)<='.$compareValue;
				break;
			case '>=':
				if($message===null)
					$message=Yii::t('yii','{attribute} must be greater than or equal to "{compareValue}".');
				$condition='CStoIsoDate(value)<'.$compareValue;
				break;
			case '<':
				if($message===null)
					$message=Yii::t('yii','{attribute} must be less than "{compareValue}".');
				$condition='CStoIsoDate(value)>='.$compareValue;
				break;
			case '<=':
				if($message===null)
					$message=Yii::t('yii','{attribute} must be less than or equal to "{compareValue}".');
				$condition='CStoIsoDate(value)>'.$compareValue;
				break;
			default:
				throw new CException(Yii::t('yii','Invalid operator "{operator}".',array('{operator}'=>$this->operator)));
		}

		$message=strtr($message,array(
			'{attribute}'=>$object->getAttributeLabel($attribute),
			'{compareValue}'=>$compareTo,
		));

		return "
if(".($this->allowEmpty ? "$.trim(value)!='' && " : '').$condition.") {
	messages.push(".CJSON::encode($message).");
}
";
	}
}
