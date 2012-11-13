<?php

class ItemType extends ActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{item_type}}';
	}

	public function rules()
	{
		return array(
			array('name, itemcategory_id', 'required'),
			array('name', 'length', 'max'=>64),
			array('itemcategory_id', 'numerical', 'integerOnly'=>true),
			array('itemcategory_id', 'exist', 'className'=>'ItemCategory', 'attributeName'=>'id'),
			array('name, ext_table', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'items' => array(self::HAS_MANY, 'Item', 'itemtype_id'),
			'itemCategory' => array(self::BELONGS_TO, 'ItemCategory', 'itemcategory_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' =>  Yii::t('app', 'ID'),
			'create_time' =>  Yii::t('app', 'Create Time'),
			'modify_time' =>  Yii::t('app', 'Modify Time'),
			'itemcategory_id' => Yii::t('app', 'Item Category'),
			'name' => Yii::t('app', 'Name'),
			'itemcategory_name' => Yii::t('app', 'Item Category'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->name,true);
		$criteria->compare('itemcategory_id',$this->itemcategory_id);
		$criteria->with = array('itemCategory');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.name',
				'attributes'=>array(
					'name',
					'itemcategory_id'=>array(
						'asc'=>'itemCategory.name',
						'desc'=>'itemCategory.name desc',
						),
					),
				),
			'pagination'=>array('pageSize'=>20,),
		));
	}

	public function getItemCategory_name()
	{
		return $this->itemCategory->name;
	}

	public function getLongName()
	{
		return $this->itemcategory_name.' ('.$this->name.')';
	}
}