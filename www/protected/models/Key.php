<?php

class Key extends ActiveRecord
{
	protected $_number = null;
	protected $_name = null;
	protected $_count = null;
	protected $_allotted = null;
	protected $_description = null;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{item_ext_key}}';
	}

	public function rules()
	{
		return array(
			array('number, name', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'item' => array(self::BELONGS_TO, 'Item', 'item_id'),
			'locks' => array(self::MANY_MANY, 'Lock', '{{key_lock}}(key_id, lock_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' =>  Yii::t('app', 'ID'),
			'create_time' =>  Yii::t('app', 'Create Time'),
			'modify_time' =>  Yii::t('app', 'Modify Time'),
			'item_id' => Yii::t('app', 'Item'),
			'number' => Yii::t('app', 'Number'),
			'name' => Yii::t('app', 'Name'),
			'count' => Yii::t('app', 'Count'),
			'allotted' => Yii::t('app', 'Allotted'),
			'description' => Yii::t('app', 'Description'),
			'locks' => Yii::t('app', 'Locks, that can be opened by the key'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('number',$this->number,true);
		$criteria->compare('name',$this->name,true);
		$criteria->with = array('item');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'item.name',
				'attributes'=>array(
					'number'=>array(
						'asc'=>'item.number',
						'desc'=>'item.number desc',
						),
					'name'=>array(
						'asc'=>'item.name',
						'desc'=>'item.name desc',
						),
					'count'=>array(
						'asc'=>'item.count',
						'desc'=>'item.count desc',
						),
					'allotted'=>array(
						'asc'=>'item.allotted',
						'desc'=>'item.allotted desc',
						),
					),
				),
			'pagination'=>array('pageSize'=>20,),
		));
	}
	
	public function behaviors()
	{
		return array(
			'CAdvancedArBehavior'=>array(
				'class'=>'wsext.CAdvancedArBehavior',
			),
		);
	}
	
	public function getNumber()
	{
		if ($this->_number === null && $this->item !== null)
		{
			$this->_number = $this->item->number;
		}
		return $this->_number;
	}
	
	public function setNumber($value)
	{
		$this->_number = $value;
	}

	public function getName()
	{
		if ($this->_name === null && $this->item !== null)
		{
			$this->_name = $this->item->name;
		}
		return $this->_name;
	}
	
	public function setName($value)
	{
		$this->_name = $value;
	}

	public function getCount()
	{
		if ($this->_count === null && $this->item !== null)
		{
			$this->_count = $this->item->count;
		}
		return $this->_count;
	}
	
	public function setCount($value)
	{
		$this->_count = $value;
	}

	public function getAllotted()
	{
		if ($this->_allotted === null && $this->item !== null)
		{
			$this->_allotted = $this->item->allotted;
		}
		return $this->_allotted;
	}
	
	public function setAllotted($value)
	{
		$this->_allotted = $value;
	}

	public function getDescription()
	{
		if ($this->_description === null && $this->item !== null)
		{
			$this->_description = $this->item->description;
		}
		return $this->_description;
	}
	
	public function setDescription($value)
	{
		$this->_description = $value;
	}
	
	public function getLongName()
	{
		return $this->number.' - '.$this->name.' ('.$this->count.' ks)';
	}
}