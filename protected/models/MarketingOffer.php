<?php

/**
 * This is the model class for table "campaign_offer".
 *
 * The followings are the available columns in table 'campaign_offer':
 * @property string $campaign_offer_id
 * @property string $campaign_offer_guid
 * @property string $account_name
 * @property integer $subscription_type_id
 * @property double $offered_price
 * @property string $Industry
 * @property string $user_email
 * @property string $user_fname
 * @property string $user_lname
 * @property string $vat_no
 */
class MarketingOffer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MarketingOffer the static model class
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
		return 'campaign_offer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_name, subscription_type_id, offered_price, Industry, user_email, user_fname, user_lname', 'required'),
			array('offered_price', 'numerical'),
			array('campaign_offer_guid, account_name, Industry, user_email, user_fname, user_lname', 'length', 'max'=>255),
			array('vat_no', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('campaign_offer_id, campaign_offer_guid, account_name, subscription_type_id, offered_price, Industry, user_email, user_fname, user_lname, vat_no', 'safe', 'on'=>'search'),
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
			'campaign_offer_id' => 'Campaign Offer',
			'campaign_offer_guid' => 'Campaign Offer Guid',
			'account_name' => 'Account Name',
			'subscription_type_id' => 'Subscription Type',
			'offered_price' => 'Offered Price',
			'Industry' => 'Industry',
			'user_email' => 'Email',
			'user_fname' => 'First name',
			'user_lname' => 'Last name',
			'vat_no' => 'Vat No',
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

		$criteria->compare('campaign_offer_id',$this->campaign_offer_id,true);
		$criteria->compare('campaign_offer_guid',$this->campaign_offer_guid,true);
		$criteria->compare('account_name',$this->account_name,true);
		$criteria->compare('subscription_type_id',$this->subscription_type_id);
		$criteria->compare('offered_price',$this->offered_price);
		$criteria->compare('Industry',$this->Industry,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_fname',$this->user_fname,true);
		$criteria->compare('user_lname',$this->user_lname,true);
		$criteria->compare('vat_no',$this->vat_no,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function GetAllRec()
	{
		$connection = Yii::app()->db;
		
		$sql = "Select * from ".$this->tableName()."";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetRecord($id)
	{
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM ".$this->tableName(). " where campaign_offer_id=".$id;
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetRecordWithGid($gid)
	{
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM ".$this->tableName(). " where campaign_offer_guid='".$gid."'";
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function UpdateRecord($array_record)
	{
		$connection = Yii::app()->db;
		
		$sql = "UPDATE ".$this->tableName()." SET account_name = '".$array_record['account_name']."', subscription_type_id = '".$array_record['subscription_type_id']."', offered_price = '".$array_record['offered_price']."', Industry = '".$array_record['Industry']."', user_email	= '".$array_record['user_email']."', user_fname 				= '".$array_record['user_fname']."', user_lname	= '".$array_record['user_lname']."', vat_no	= '".$array_record['vat_no']."', company = '".$array_record['company']."', address	= '".$array_record['address']."', city	 				= '".$array_record['city']."', postal_code = '".$array_record['postal_code']."', country = '".$array_record['country']."' WHERE campaign_offer_id=".$array_record['campaign_offer_id'];
		
		$result = $connection->createCommand($sql);
		
		$final_result = $result->execute();
		
		return $final_result;
	}
}