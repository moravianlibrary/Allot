<?php

class ItemCategory extends ActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{item_category}}';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>64),
			array('ext_table', 'in', 'range'=>array_keys(DropDownItem::items('itemCategory.ext_table')), 'allowEmpty'=>true),
			array('name, ext_table', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'itemTypes' => array(self::HAS_MANY, 'ItemType', 'itemcategory_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' =>  Yii::t('app', 'ID'),
			'create_time' =>  Yii::t('app', 'Create Time'),
			'modify_time' =>  Yii::t('app', 'Modify Time'),
			'name' =>  Yii::t('app', 'Name'),
			'ext_table' =>  Yii::t('app', 'Ext Table'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->name,true);
		$criteria->compare('ext_table',$this->ext_table);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'name',
				),
			'pagination'=>array('pageSize'=>20,),
		));
	}
	
	public function afterSave()
	{
		if ($this->isNewRecord)
		{
			$itemType = new ItemType;
			$itemType->name = $this->name;
			$itemType->itemcategory_id = $this->id;
			$itemType->save(false);
		}
		parent::afterSave();
	}
}