<?php

/**
 * This is the model class for table "buzz_search_terms".
 *
 * The followings are the available columns in table 'buzz_search_terms':
 * @property string $buzzterm_id
 * @property string $user_id
 * @property string $buzzterm_keywords
 * @property string $buzzterm_category
 */
class Buzz extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Buzz the static model class
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
		return 'buzz_search_terms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, buzzterm_keywords, buzzterm_category', 'required'),
			array('user_id, buzzterm_keywords, buzzterm_category', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buzzterm_id, user_id, buzzterm_keywords, buzzterm_category', 'safe', 'on'=>'search'),
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
			'buzzterm_id' => 'Buzzterm',
			'user_id' => 'User',
			'buzzterm_keywords' => 'Buzzterm Keywords',
			'buzzterm_category' => 'Buzzterm Category',
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

		$criteria->compare('buzzterm_id',$this->buzzterm_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('buzzterm_keywords',$this->buzzterm_keywords,true);
		$criteria->compare('buzzterm_category',$this->buzzterm_category,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function GetSources()
	{
		$connection=Yii::app()->db;
		
		$sql="Select * from sources";
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetBuzzCategories()
	{
		$connection=Yii::app()->db;
		
		$sql = "Select * from user_buzz_category WHERE userid=".Yii::app()->user->user_id;
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function BuzztermCategory($catid)
	{
		$connection=Yii::app()->db;
		
		$sql="Select * from buzz_search_terms WHERE user_id=".Yii::app()->user->user_id." AND buzzterm_category=".$catid;
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function SetDict($class)
	{
		$connection=Yii::app()->db;
		
		$sql="Select * from dictionary WHERE type = ".$class;
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	function addNewKeys($type, $id, $cat) 
	{
		$connection=Yii::app()->db;
		
		$list = explode(",", $type);
	
		$sql = "DELETE FROM buzz_search_terms WHERE user_id=".Yii::app()->user->user_id." AND buzzterm_category = '$cat'"; 
		$buzz_del = $connection->createCommand($sql)->execute();
		
		foreach($list as $item) 
		{
			$trimmed = trim($item);
			if(!empty($trimmed)) 
			{
				$new_item = preg_replace("[^A-Za-z0-9]", "", $trimmed );
				$query = "INSERT INTO buzz_search_terms (user_id, buzzterm_keywords, buzzterm_category) VALUES (".Yii::app()->user->user_id.", '".addslashes($new_item)."', '".$cat."')";
				
				$result=$connection->createCommand($query);
				$final_result=$result->execute();
			}
		}
		
		return true;
	}
	
	function InsertAlert($id,$key,$email,$howoften,$lang)
	{
		$connection=Yii::app()->db;
		
		$sql = sprintf("INSERT INTO alerts(id, keyword, feed, emails, created, howoften,lang) VALUES('%d','%s','%s','%s','%s','%s','%s')",$id,$key,'',$email,date('Y-m-d'),$howoften,$lang,date("Y-m-d H:i:s", time()));
		
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
		
		return $final_result;
		
	}
	
	function UpdateAlert($feed,$id,$key)
	{
		$connection=Yii::app()->db;
		
		$sql = "UPDATE alerts SET feed = '".$feed."' WHERE id = '".$id."' AND keyword = '".$key."'";
		
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
		
		return $final_result;
		
	}
}