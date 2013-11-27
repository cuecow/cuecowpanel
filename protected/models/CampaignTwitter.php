<?php

/**
 * This is the model class for table "campaign_twitter".
 *
 * The followings are the available columns in table 'campaign_twitter':
 * @property string $id
 * @property integer $campaign_id
 * @property string $message
 * @property string $post_id
 * @property string $dated
 */ 
class CampaignTwitter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CampaignTwitter the static model class
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
		return 'campaign_twitter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('campaign_id, message, post_id, dated', 'required'),
			array('campaign_id', 'numerical', 'integerOnly'=>true),
			array('post_id, dated', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, campaign_id, message, post_id, dated', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'campaign_id' => 'Campaign',
			'message' => 'Message',
			'post_id' => 'Post',
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

		$criteria = new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('campaign_id',$this->campaign_id);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('post_id',$this->post_id,true);
		$criteria->compare('dated',$this->dated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function SaveMessage($campaign_id, $message)
	{
		$connection = Yii::app()->db;
		
		$sql = 'INSERT INTO campaign_twitter(campaign_id,message,dated) VALUES("'.$campaign_id.'","'.$message.'","'.strtotime(now).'")';
			
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();	
	}
	
	public function GetSpecificPost($campaign_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName()." where campaign_id= ".$campaign_id ;
		$url = $connection->createCommand($sql)->queryAll();
		return $url;
	}
	
	public function DeletePost($campaign_id)
	{
		$connection = Yii::app()->db;
		$sql = 'DELETE from '.$this->tableName().' where campaign_id='.$campaign_id;
		$del = $connection->createCommand($sql)->execute();
	}	
	
	public function UpdateTweet($campaign_id, $postid)
	{
		$connection = Yii::app()->db;	
		
		$sql = "update campaign_twitter set post_id = '".$postid."' where campaign_id = '".$campaign_id."'";
		
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
	}
}