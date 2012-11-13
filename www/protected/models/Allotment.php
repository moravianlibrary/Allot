<?php

class Allotment extends ActiveRecord
{
	private $_itemtype_id = null;
	private $_itemtype_name = null;
	protected $_user_fullname = null;
	protected $_item_name = null;
	protected $_oldItem_id = 0;
	protected $_oldCount = 0;
	protected $_oldReturnDate = '';
	public $userName = '';

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{allotment}}';
	}

	public function scopes()
	{
		$alias = $this->getTableAlias(false, false);
		return array(
			'my'=>array(
				'condition'=>((user()->checkAccess('AllotmentAdmin')) ? '' : $alias.'.user_id='.user()->id),
			),
		);
	}

	public function rules()
	{
		return array(
			array('item_id, count, allotment_date', 'required'),
			array('item_id', 'numerical', 'integerOnly'=>true),
			array('item_id', 'exist', 'className'=>'Item', 'attributeName'=>'id'),
			array('count', 'numerical', 'integerOnly'=>true, 'min'=>1),
			array('count', 'itemCount'),
			array('item_id, count', 'noUpdateAfterReturn'),
			array('allotment_date, return_date', 'date', 'format'=>Yii::app()->locale->dateFormat),
			array('return_date', 'returnDateRequired'),
			array('return_date', 'cmpdate', 'compareAttribute'=>'allotment_date', 'operator'=>'>=', 'allowEmpty'=>true),
			array('return_status', 'returnStatusRequired'),
			array('return_status', 'in', 'range'=>array_keys(DropDownItem::items('allotment.return_status')), 'allowEmpty'=>true),
			array('user_full_name, item_name, count, allotment_date, return_date, return_status, itemtype_id', 'safe', 'on'=>'search'),
		);
	}

	public function returnDateRequired($attribute, $params)
	{
		if ($this->$attribute == '' && $this->return_status != '') $this->addError($attribute, strtr(Yii::t('yii','{attribute} cannot be blank.'),array('{attribute}'=>$this->getAttributeLabel($attribute))));
	}

	public function returnStatusRequired($attribute, $params)
	{
		if ($this->$attribute == '' && $this->return_date != '') $this->addError($attribute, strtr(Yii::t('yii','{attribute} cannot be blank.'),array('{attribute}'=>$this->getAttributeLabel($attribute))));
	}

	public function itemCount($attribute, $params)
	{
		if (($this->count - $this->_oldCount) > $this->item->remaining) $this->addError($attribute, strtr(t('{attribute} must be must be less than or equal to ammount of remaining items.'),array('{attribute}'=>$this->getAttributeLabel($attribute))));
	}

	public function noUpdateAfterReturn($attribute, $params)
	{
		$oldAttribute = '_old'.ucfirst($attribute);
		if ($this->return_date != '' && ($this->$attribute != $this->$oldAttribute)) $this->addError($attribute, strtr(t('Updating {attribute} is not possible.'),array('{attribute}'=>$this->getAttributeLabel($attribute))));
	}

	public function relations()
	{
		return array(
			'item' => array(self::BELONGS_TO, 'Item', 'item_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'allotmentUser' => array(self::BELONGS_TO, 'User', 'allotment_user_id'),
			'returnUser' => array(self::BELONGS_TO, 'User', 'return_user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' =>  Yii::t('app', 'ID'),
			'create_time' =>  Yii::t('app', 'Create Time'),
			'modify_time' =>  Yii::t('app', 'Modify Time'),
			'user_id' =>  Yii::t('app', 'User'),
			'item_id' =>  Yii::t('app', 'Item'),
			'count' =>  Yii::t('app', 'Count'),
			'allotment_date' =>  Yii::t('app', 'Allotment Date'),
			'return_date' =>  Yii::t('app', 'Return Date'),
			'return_status' =>  Yii::t('app', 'Return Status'),
			'return_status_f' =>  Yii::t('app', 'Return Status'),
			'user_full_name' =>  Yii::t('app', 'User'),
			'item_name' =>  Yii::t('app', 'Item'),
			'itemtype_id' =>  Yii::t('app', 'Item Type'),
			'itemtype_name' =>  Yii::t('app', 'Item Type'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		if (isset($this->user_id))
			$criteria->compare('user_id',$this->user_id);
		else
			$criteria->compare('user.lastname',$this->user_full_name,true);
		$criteria->compare('CONCAT(item.number, \' \', item.name)',$this->item_name,true);
		$criteria->compare('t.count',$this->count);
		$criteria->compare('allotment_date',DT::toIso($this->allotment_date));
		$criteria->compare('return_date',DT::toIso($this->return_date));
		$criteria->compare('return_status',$this->return_status);
		$criteria->compare('item.itemtype_id',$this->itemtype_id);
		$criteria->with = array('user', 'item', 'item.itemType');

		return new CActiveDataProvider($this->my(), array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'allotment_date DESC',
				'attributes'=>array(
					'user_full_name'=>array(
						'asc'=>'user.lastname, user.firstname',
						'desc'=>'user.lastname desc, user.firstname desc',
						),
					'item_name'=>array(
						'asc'=>'item.name',
						'desc'=>'item.name desc',
						),
					'itemtype_id'=>array(
						'asc'=>'itemType.name',
						'desc'=>'itemType.name desc',
						),
					'count','allotment_date','return_date','return_status',
					),
				),
			'pagination'=>array('pageSize'=>20,),
		));
	}

	public function afterSave()
	{
		$item = Item::model()->findByPk($this->item_id);
		$item->allotted = $item->stat_allotted;
		$item->save(false);
		parent::afterSave();
	}

	public function afterDelete()
	{
		parent::afterDelete();
		if (!$this->returned || $this->destroyed)
		{
			$item = Item::model()->findByPk($this->item_id);
			$item->allottedd -= $this->count;
			$item->save(false);
		}
	}

	public function afterFind()
	{
		parent::afterFind();
		$this->_oldItem_id = $this->item_id;
		$this->_oldCount = $this->count;
		$this->_oldReturnDate = $this->return_date;
		$this->userName = $this->user->username;
	}

	public function getDestroyed()
	{
		return ($this->return_status == 'Z');
	}

	public function getReturned()
	{
		return ($this->return_date != '' && $this->return_status != '');
	}

	public function getUser_full_name()
	{
		if ($this->_user_fullname === null && $this->user !== null)
		{
			$this->_user_fullname = $this->user->full_name;
		}
		return $this->_user_fullname;
	}

	public function setUser_full_name($value)
	{
		$this->_user_fullname = $value;
	}

	public function getItem_name()
	{
		if ($this->_item_name === null && $this->item !== null)
		{
			$this->_item_name = $this->item->name;
		}
		return $this->_item_name;
	}

	public function setItem_name($value)
	{
		$this->_item_name = $value;
	}

	public function getItemtype_id()
	{
		if ($this->_itemtype_id === null && $this->item !== null)
		{
			$this->_itemtype_id = $this->item->itemtype_id;
		}
		return $this->_itemtype_id;
	}

	public function setItemtype_id($value)
	{
		$this->_itemtype_id = $value;
	}

	public function getItemtype_name()
	{
		if ($this->_itemtype_name === null && $this->item !== null && $this->item->itemType !== null)
		{
			$this->_itemtype_name = $this->item->itemType->name;
		}
		return $this->_itemtype_name;
	}

	public function setItemtype_name($value)
	{
		$this->_itemtype_name = $value;
	}

	public function getReturn_status_f()
	{
		return DropDownItem::item('allotment.return_status', $this->return_status);
	}

	/*
	public function getAllotmentChange()
	{
		if ($this->isNewRecord)
		{
			if ($this->destroyed)
			{
				return -$this->count;
			}
			elseif ($this->return_date == '')
				{
					return $this->count;
				}
				else
				{
					return 0;
				}
		}
		else
		{
			if ($this->destroyed)
			{
				return 0;
			}
			elseif ($this->_oldReturnDate == $this->return_date)
				{
					return $this->count - $this->_oldCount;
				}
				elseif ($this->_oldReturnDate == '')
					{
						return -$this->count;
					}
					elseif ($this->return_date == '')
						{
							return $this->count;
						}
		}
	}
	*/
}
