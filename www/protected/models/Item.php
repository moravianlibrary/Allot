<?php

class Item extends ActiveRecord
{
	private $_itemcategory_id = null;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{item}}';
	}

	public function rules()
	{
		return array(
			array('number, name, itemtype_id, count', 'required'),
			array('number', 'length', 'max'=>32),
			array('name', 'length', 'max'=>64),
			array('itemtype_id, count', 'numerical', 'integerOnly'=>true),
			array('itemtype_id', 'exist', 'className'=>'ItemType', 'attributeName'=>'id'),
			array('description', 'safe'),
			array('itemtype_id, itemcategory_id, number, name', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'users' => array(self::MANY_MANY, 'User', '{{allotment}}(item_id, user_id)'),
			'allotments' => array(self::HAS_MANY, 'Allotment', 'item_id'),
			'itemType' => array(self::BELONGS_TO, 'ItemType', 'itemtype_id', 'with'=>'itemCategory'),
			'key' => array(self::HAS_ONE, 'Key', 'item_id'),
			'lock' => array(self::HAS_ONE, 'Lock', 'item_id'),
			'stat_allotted' => array(self::STAT, 'Allotment', 'item_id', 'select'=>'SUM(count)', 'condition'=>'return_status=\'\' OR return_status=\'Z\''),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' =>  Yii::t('app', 'ID'),
			'create_time' =>  Yii::t('app', 'Create Time'),
			'modify_time' =>  Yii::t('app', 'Modify Time'),
			'itemtype_id' => Yii::t('app', 'Type'),
			'number' => Yii::t('app', 'Number'),
			'name' => Yii::t('app', 'Name'),
			'count' => Yii::t('app', 'Count'),
			'allotted' => Yii::t('app', 'Allotted'),
			'description' => Yii::t('app', 'Description'),
			'remaining' => Yii::t('app', 'Zůstatek'),
			'itemtype_name' => Yii::t('app', 'Type'),
			'itemcategory_id' => Yii::t('app', 'Category'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('number',$this->number,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('itemtype_id',$this->itemtype_id);
		$criteria->compare('itemcategory_id',$this->itemcategory_id);
		$criteria->with = array('itemType');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.name',
				'attributes'=>array(
					'number','name',
					'itemtype_id'=>array(
						'asc'=>'itemType.name',
						'desc'=>'itemType.name desc',
						),
					'itemcategory_id'=>array(
						'asc'=>'itemCategory.name',
						'desc'=>'itemCategory.name desc',
						),
					'count','allotted',
					'remaining'=>array(
						'asc'=>'(count-allotted)',
						'desc'=>'(count-allotted) desc',
						),
					),
				),
			'pagination'=>array('pageSize'=>20,),
		));
	}
	
	public function afterSave()
	{
		if ($this->isNewRecord)
		{
			$extTable = $this->itemType->itemCategory->ext_table;
			$extTables = DropDownItem::items('itemCategory.ext_table');
			if (array_key_exists($extTable, $extTables))
			{
				$extTable = ucfirst($extTable);
				$ext = new $extTable;
				$ext->item_id = $this->id;
				$ext->save(false);
			}
		}
		parent::afterSave();
	}	

	public function getLongName()
	{
		return $this->number.' - '.$this->name;
	}
	
	public function getRemaining()
	{
		return $this->count - $this->allotted;
	}

	public function getItemType_name()
	{
		return $this->itemType->name;
	}
	
	public function getItemCategory_id()
	{
		if ($this->_itemcategory_id === null && $this->itemType !== null)
		{
			$this->_itemcategory_id = $this->itemType->itemcategory_id;
		}
		return $this->_itemcategory_id;
	}
	
	public function setItemCategory_id($value)
	{
		$this->_itemcategory_id = $value;
	}

	public function getItemCategory_name()
	{
		return $this->itemType->itemCategory->name;
	}
}