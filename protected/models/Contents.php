<?php

/**
 * This is the model class for table "contents".
 *
 * The followings are the available columns in table 'contents':
 * @property string $content_id
 * @property integer $lang_id
 * @property string $content_text
 */
class Contents extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contents the static model class
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
		return 'contents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content_id, lang_id, content_text', 'required'),
			array('lang_id', 'numerical', 'integerOnly'=>true),
			array('content_id', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('content_id, lang_id, content_text', 'safe', 'on'=>'search'),
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
			'content_id' => 'Content',
			'lang_id' => 'Lang',
			'content_text' => 'Content Text',
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

		$criteria->compare('content_id',$this->content_id,true);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('content_text',$this->content_text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function GetRecord($content_id,$lang)
	{
		if($lang == '')
			$lang = 1;
		
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName(). " where content_id = '".$content_id."' and lang_id=".$lang;
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result[0];
	}
	
	public function GetSingleRecord($content_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName(). " where content_id = '".$content_id."'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetAllRecord()
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName();
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetPageRecord($page)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName()." where content_id like '".$page."%'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function SearchRecord($contentid='',$content_text='')
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName()." where 1";
		
		if(!empty($contentid) && empty($content_text))
			$sql .=" and content_id like '%".$contentid."%'";
		if(!empty($content_text) && empty($contentid))
			$sql .=" and content_text like '%".$content_text."%'";
		if(!empty($contentid) && !empty($content_text))
			$sql .=" and (content_id like '%".$contentid."%' OR content_text like '%".$content_text."%')";

		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function CheckLanuageRecord($content_id,$lang_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName()." where content_id='".$content_id."' and lang_id='".$lang_id."'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function UpdateContent($content_id,$text,$lang_id)
	{
		$connection = Yii::app()->db;
		
		$ExistRec = $this->CheckLanuageRecord($content_id,$lang_id);
		
		if(count($ExistRec))
		{
			$sql = 'UPDATE '.$this->tableName().' SET content_text="'.addslashes($text).'" where content_id="'.$content_id.'" and lang_id="'.$lang_id.'"';
			
			$update = $connection->createCommand($sql)->execute();
	
			$content = $this->GetSingleRecord($content_id);
	
			Yii::app()->cache->delete($content_id.$lang_id);
			Yii::app()->cache->set($content_id.$lang_id, $content['content_text']);
		}
		else
		{
			$sql = 'INSERT into '.$this->tableName().'(content_id,lang_id,content_text) values("'.$content_id.'","'.$lang_id.'","'.$text.'")';
			
			$add = $connection->createCommand($sql)->execute();
			Yii::app()->cache->set($content_id.$lang_id, $text);
		}
		
		return 1;	
	}
	
	public function EditAjaxContent($content_id,$text,$lang_id)
	{
		$connection = Yii::app()->db;
		
		$sql = 'UPDATE '.$this->tableName().' SET content_text="'.addslashes($text).'" where content_id="'.$content_id.'" and lang_id="'.$lang_id.'"';
			
		$update = $connection->createCommand($sql)->execute();
	
		$content = $this->GetSingleRecord($content_id);
	
		Yii::app()->cache->delete($content_id.$lang_id);
		Yii::app()->cache->set($content_id.$lang_id, $text);
		
	}
	
	public function DeleteContent($content_id)
	{
		$connection = Yii::app()->db;
		
		$sql = 'DELETE from '.$this->tableName().' where content_id="'.$content_id.'"';
		$del = $connection->createCommand($sql)->execute();
		
				
		return 1;	
	}
}