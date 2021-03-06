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
			array('number, name', 'required'),
			array('number', 'length', 'max'=>32),
			array('name', 'length', 'max'=>64),
			array('description', 'safe'),
			array('number, name', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'locks' => array(self::MANY_MANY, 'Lock', '{{door_lock}}(door_id, lock_id)'),
			'rooms' => array(self::MANY_MANY, 'Room', '{{room_door}}(door_id, room_id)'),
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
			'description' => Yii::t('app', 'Description'),
			'locks' => Yii::t('app', 'Locks in door'),
			'rooms' => Yii::t('app', 'Rooms, that are connected by door'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('number',$this->number,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'number',				
				'attributes'=>array(
					'number','name',
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
}