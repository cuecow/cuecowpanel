<?php

/**
 * This is the model class for table "languages".
 *
 * The followings are the available columns in table 'languages':
 * @property integer $lang_id
 * @property string $lang_name
 */
class Languages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Languages the static model class
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
		return 'languages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lang_name', 'required'),
			array('lang_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lang_id, lang_name', 'safe', 'on'=>'search'),
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
			'lang_id' => 'Lang',
			'lang_name' => 'Lang Name',
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

		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('lang_name',$this->lang_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function GetLanguage($lang_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName(). " where lang_id = ".$lang_id;
		$result = $connection->createCommand($sql)->queryAll();
		
		return ucfirst($result[0]['lang_name']);
	}
	
	public function GetAllLanguage()
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName();
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
}