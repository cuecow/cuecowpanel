<?php

/**
 * This is the model class for table "twitter".
 *
 * The followings are the available columns in table 'twitter':
 * @property string $id
 * @property integer $user_id
 * @property string $message
 * @property string $post_id
 * @property string $dated
 */
class Twitter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Twitter the static model class
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
		return 'twitter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, message, post_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('post_id, dated', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, message, post_id, dated', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('post_id',$this->post_id,true);
		$criteria->compare('dated',$this->dated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function SaveTweet($request)
	{
		$connection = Yii::app()->db;	
		
		$sql = "insert into twitter set ";
		
		if( count($request) )
		{
			foreach( $request as $key => $value )	
				$sql .= "`".$key."` = '".addslashes($value)."', ";
		}
		
		$sql = substr($sql, 0, -2);
				
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
	}
}