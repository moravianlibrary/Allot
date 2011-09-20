<?php

class Building extends ActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{building}}';
	}

	public function rules()
	{
		return array(
			array('name, postal_code, city', 'required'),
			array('land_registry_number, postal_code', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('street, city', 'length', 'max'=>64),
			array('house_number', 'length', 'max'=>5),
			array('postal_code', 'length', 'max'=>5),
			array('description', 'safe'),
			array('name, street, land_registry_number, house_number, postal_code, city', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' =>  Yii::t('app', 'ID'),
			'create_time' =>  Yii::t('app', 'Create Time'),
			'modify_time' =>  Yii::t('app', 'Modify Time'),
			'name' =>  Yii::t('app', 'Name'),
			'street' =>  Yii::t('app', 'Street'),
			'land_registry_number' =>  Yii::t('app', 'Land Registry Number'),
			'house_number' =>  Yii::t('app', 'House Number'),
			'postal_code' =>  Yii::t('app', 'Postal Code'),
			'city' =>  Yii::t('app', 'City'),
			'description' =>  Yii::t('app', 'Description'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->name,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('land_registry_number',$this->land_registry_number);
		$criteria->compare('house_number',$this->house_number);
		$criteria->compare('postal_code',$this->postal_code);
		$criteria->compare('city',$this->city,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'name',				
				),
			'pagination'=>array('pageSize'=>20,),
		));
	}

}
