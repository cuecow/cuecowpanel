<?php

/**
 * This is the model class for table "subsription_type".
 *
 * The followings are the available columns in table 'subsription_type':
 * @property integer $subscription_id
 * @property string $name
 * @property string $description
 * @property double $price
 * @property string $status
 * @property integer $max_num_users
 * @property integer $max_num_venues
 * @property integer $max_num_campaigns
 * @property integer $max_num_apps
 * @property integer $max_num_walls
 */
class SubsriptionType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubsriptionType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subsription_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, price, max_num_users, max_num_venues, max_num_campaigns, max_num_apps, max_num_walls', 'required'),
			array('max_num_users, max_num_venues, max_num_campaigns, max_num_apps, max_num_walls', 'numerical', 'integerOnly'=>false),
			array('price', 'numerical'),
			array('name', 'length', 'max'=>200),
			array('description', 'length', 'max'=>500),
			array('status', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subscription_id, name, description, price, status, max_num_users, max_num_venues, max_num_campaigns, max_num_apps, max_num_walls', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subscription_id' => 'Subscription',
			'name' => 'Name',
			'description' => 'Description',
			'price' => 'Price',
			'status' => 'Status',
			'max_num_users' => 'Max Num Users',
			'max_num_venues' => 'Max Num Venues',
			'max_num_campaigns' => 'Max Num Campaigns',
			'max_num_apps' => 'Max Num Apps',
			'max_num_walls' => 'Max Num Walls',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('subscription_id',$this->subscription_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('max_num_users',$this->max_num_users);
		$criteria->compare('max_num_venues',$this->max_num_venues);
		$criteria->compare('max_num_campaigns',$this->max_num_campaigns);
		$criteria->compare('max_num_apps',$this->max_num_apps);
		$criteria->compare('max_num_walls',$this->max_num_walls);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function GetAllRec()
	{
		$connection = Yii::app()->db;
		
		$sql = "Select * from ".$this->tableName()." where status='active'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetSpecificRec($id)
	{
		$connection = Yii::app()->db;
		
		$sql = "Select * from ".$this->tableName()." where subscription_id=".$id;
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetSpecificRecbyName($name)
	{
		$connection = Yii::app()->db;
		
		$sql = "Select * from ".$this->tableName()." where name='".$name."'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
}