<?php

/**
 * This is the model class for table "fs_special".
 *
 * The followings are the available columns in table 'fs_special':
 * @property string $fs_special_id
 * @property string $campaign_id
 * @property string $sp_type
 * @property string $count1
 * @property string $count2
 * @property string $count3
 * @property string $unlockedText
 * @property string $offer
 * @property string $finePrint
 * @property string $cost
 * @property string $dated
 */
class FsSpecial extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FsSpecial the static model class
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
		return 'fs_special';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('userid, campaign_name, sp_type, count1, count2, count3, unlockedText, offer, finePrint, cost, dated', 'required'),
			array('userid', 'length', 'max'=>255),
			array('campaign_name, sp_type, count1, count2, count3, unlockedText, offer, finePrint, cost', 'length', 'max'=>500),
			array('dated', 'length', 'max'=>20),*/
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('fs_special_id, userid, campaign_name, sp_type, count1, count2, count3, unlockedText, offer, finePrint, cost, dated', 'safe', 'on'=>'search'),
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
			'fs_special_id' => 'Fs Special',
			'campaign_id'	=> 'Campaign id',
			'userid' => 'Userid',
			'campaign_name' => 'Campaign Name',
			'sp_type' => 'Sp Type',
			'count1' => 'Count1',
			'count2' => 'Count2',
			'count3' => 'Count3',
			'unlockedText' => 'Unlocked Text',
			'offer' => 'Offer',
			'finePrint' => 'Fine Print',
			'cost' => 'Cost',
			'dated' => 'Dated',
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

		$criteria->compare('fs_special_id',$this->fs_special_id,true);
		$criteria->compare('sp_type',$this->sp_type,true);
		$criteria->compare('count1',$this->count1,true);
		$criteria->compare('count2',$this->count2,true);
		$criteria->compare('count3',$this->count3,true);
		$criteria->compare('unlockedText',$this->unlockedText,true);
		$criteria->compare('offer',$this->offer,true);
		$criteria->compare('finePrint',$this->finePrint,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('dated',$this->dated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function InsertToken($token)
	{
		$connection=Yii::app()->db;
		
		$sql1='INSERT INTO fs_token(userid,token) VALUES("'.Yii::app()->user->user_id.'","'.$token.'")';
		
		$result1=$connection->createCommand($sql1);
		$final_result1=$result1->execute();
			
			
		return 1;
	}
	
	public function UpdateSpecial($fs_special_id)
	{
		$connection=Yii::app()->db;
		
		$sql='UPDATE fs_special set status="posted" where fs_special_id="'.$fs_special_id.'"';
		
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
			
		return 1;
	}
	
	public function ExistToken()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM fs_token where userid= ".Yii::app()->user->user_id;
		$token_res=$connection->createCommand($sql)->queryAll();
		
		return $token_res;
	}
	
	public function DeleteToken()
	{
		$connection=Yii::app()->db;
		
		$sql="DELETE FROM fs_token where userid= ".Yii::app()->user->user_id;
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
		
		return $token_del;
	}
	
	public function GetTimeZone($zoneid)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM zone where zone_id= ".$zoneid;
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function PickRecord($lastid)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM fs_special where campaign_id=".$lastid;
		$special_res=$connection->createCommand($sql)->queryAll();
		
		return $special_res;
	}
}