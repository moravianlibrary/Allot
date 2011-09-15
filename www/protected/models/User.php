<?php

class User extends ActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{user}}';
	}

	public function rules()
	{
		return array(
			array('username, firstname, lastname, email', 'safe'),
		);
	}

	public function relations()
	{
		return array(
			'items' => array(self::MANY_MANY, 'Item', '{{allotment}}(user_id, item_id)'),
			'allotments' => array(self::HAS_MANY, 'Allotment', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' =>  Yii::t('app', 'ID'),
			'create_time' =>  Yii::t('app', 'Create Time'),
			'modify_time' =>  Yii::t('app', 'Modify Time'),
			'username' => Yii::t('app', 'Username'),
			'title_before_name' => Yii::t('app', 'Title before Name'),
			'firstname' => Yii::t('app', 'Firstname'),
			'lastname' => Yii::t('app', 'Lastname'),
			'title_after_name' => Yii::t('app', 'Title after Name'),
			'email' => Yii::t('app', 'E-mail'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('username',$this->username,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'username',
				),
			'pagination'=>array('pageSize'=>20,),
		));
	}
	
	public function getFull_name()
	{
		return ($this->title_before_name != '' ? $this->title_before_name.' ' : '').$this->firstname.' '.$this->lastname.($this->title_after_name != '' ? ', '.$this->title_after_name : '');
	}
}