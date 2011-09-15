<?php

class Door extends ActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{door}}';
	}

	public function rules()
	{
		return array(
			array('number, name, floor, building_id', 'required'),
			array('number', 'length', 'max'=>32),
			array('name', 'length', 'max'=>64),
			array('floor, building_id', 'numerical', 'integerOnly'=>true),
			array('building_id', 'exist', 'className'=>'Building', 'attributeName'=>'id'),
			array('description', 'safe'),
			array('number, name, floor', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'building' => array(self::BELONGS_TO, 'Building', 'building_id'),
			'locks' => array(self::MANY_MANY, 'Lock', '{{door_lock}}(door_id, lock_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' =>  Yii::t('app', 'ID'),
			'create_time' =>  Yii::t('app', 'Create Time'),
			'modify_time' =>  Yii::t('app', 'Modify Time'),
			'number' => Yii::t('app', 'Number'),
			'name' => Yii::t('app', 'Name'),
			'floor' => Yii::t('app', 'Floor'),
			'building_id' => Yii::t('app', 'Building'),
			'description' => Yii::t('app', 'Description'),
			'locks' => Yii::t('app', 'Locks in door'),
			'building_name' => Yii::t('app', 'Building'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('number',$this->number,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('building_id',$this->building_id);
		$criteria->compare('floor',$this->floor);
		$criteria->with = array('building');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'number',				
				'attributes'=>array(
					'number','name','floor',
					'building_id'=>array(
						'asc'=>'building.name',
						'desc'=>'building.name desc',
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
	
	public function getLongName()
	{
		return $this->number.' - '.$this->name;
	}
	
	public function getBuilding_name()
	{
		return $this->building->name;
	}
}