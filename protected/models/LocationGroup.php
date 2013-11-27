<?php

/**
 * This is the model class for table "location_group".
 *
 * The followings are the available columns in table 'location_group':
 * @property string $group_id
 * @property string $name
 */
class LocationGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LocationGroup the static model class
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
		return 'location_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			//array('name', 'unique'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('group_id, name', 'safe', 'on'=>'search'),
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
			'group_id' => 'Group',
			'name' => 'Name',
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

		$criteria->compare('group_id',$this->group_id,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function AllGroups()
	{
		$connection	=	Yii::app()->db;
		$sql		=	"SELECT * FROM ".$this->tableName(). " where userid=".Yii::app()->user->user_id;
		
		$result		=	$connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function EditGroups($groupid)
	{
		$connection	=	Yii::app()->db;
		$sql		=	"SELECT * FROM ".$this->tableName(). " where group_id=".$groupid." and userid=".Yii::app()->user->user_id;
		
		$result		=	$connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function DeleteGroups($groupid)
	{
		$connection		=	Yii::app()->db;
		$sql			=	"DELETE FROM ".$this->tableName(). " where group_id=".$groupid." and userid=".Yii::app()->user->user_id;
		
		$result			=	$connection->createCommand($sql);
		$final_result	=	$result->execute();
		
		return $final_result;
	}
	
	public function GetAllLocations()
	{
		$connection	=	Yii::app()->db;
		$sql		=	"SELECT * FROM location where user_id=".Yii::app()->user->user_id;
		$result		=	$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetFacebookPages()
	{
		$connection	=	Yii::app()->db;
		$sql		=	"SELECT * FROM fbpages where user_id=".Yii::app()->user->user_id;
		$result		=	$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetSpecLocation($loc_id)
	{
		$connection	=	Yii::app()->db;
		$sql		=	"SELECT * FROM location where loc_id=".$loc_id;
		$result		=	$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetSpecPage($page_id)
	{
		$connection	=	Yii::app()->db;
		$sql		=	"SELECT * FROM fbpages where id=".$page_id;
		$result		=	$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetGroupLoc($group_id)
	{
		$connection	=	Yii::app()->db;
		$sql		=	"SELECT * FROM location_group where group_id=".$group_id;
		$result		=	$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetUserGroup()
	{
		$connection	=	Yii::app()->db;
		$sql		=	"SELECT * FROM location_group where userid=".Yii::app()->user->user_id;
		$result		=	$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function UpdateLocationGroup($group_id,$new_locations)
	{
		
		$connection	=	Yii::app()->db;
		
		$sql		=	"UPDATE location_group set locations = '".$new_locations."' where group_id=".$group_id;
		$result		=	$connection->createCommand($sql);
		$final_result	=	$result->execute();
		
		return $final_result;
	}
	
	public function UpdatePagesGroup($group_id,$new_pages)
	{
		
		$connection	=	Yii::app()->db;
		
		$sql		=	"UPDATE location_group set fbpages = '".$new_pages."' where group_id=".$group_id;
		$result		=	$connection->createCommand($sql);
		$final_result	=	$result->execute();
		
		return $final_result;
	}
	
	public function AddLocationtoGroup($loc_id,$group_ids)
	{
		$connection	=	Yii::app()->db;
		
		$temp_groups = explode(',',$group_ids);
		
		if(count($temp_groups))
		{
			foreach ($temp_groups as $key=>$value)
			{
				$sql	= "SELECT * FROM location_group where group_id=".$value;
				$result	= $connection->createCommand($sql)->queryAll();
				
				if(!empty($result[0]['locations']))
					$new_location = $result[0]['locations'].','.$loc_id;
				else
					$new_location = $loc_id;
				
				$sql_2		=	"UPDATE location_group set locations = '".$new_location."' where group_id=".$value;
				$result_2	=	$connection->createCommand($sql_2);
				$final_result	=	$result_2->execute();
				
			}
		}
		
		return true;
	}
	
	public function AddFBPageGroup($page_id,$pages_ids)
	{
		$connection	=	Yii::app()->db;
		
		$temp_pages = explode(',',$pages_ids);
		
		if(count($temp_pages))
		{
			foreach ($temp_pages as $key=>$value)
			{
				$sql	= "SELECT * FROM location_group where group_id=".$value;
				$result	= $connection->createCommand($sql)->queryAll();
				
				$new_pages = $result[0]['fbpages'].','.$page_id;
				
				$sql_2		=	"UPDATE location_group set fbpages = '".$new_pages."' where group_id=".$value;
				$result_2	=	$connection->createCommand($sql_2);
				$final_result	=	$result_2->execute();
				
			}
		}
		
		return true;
	}
	
	public function EditLocationGroup($loc_id,$group_ids)
	{
		$temp_groups = explode(',',$group_ids);
		
		$connection	=	Yii::app()->db;
		
		$AllGroups = $this->AllGroups();
		
		if(count($AllGroups))
		{
			foreach($AllGroups as $key=>$value)	
			{
				$temp_locations = explode(',',$value['locations']);
				
				if(in_array($value['group_id'],$temp_groups) && !in_array($loc_id,$temp_locations))
				{
					$new_locations = $value['locations'].','.$loc_id;
					
					$this->UpdateLocationGroup($value['group_id'],$new_locations);
				}
				
				if(in_array($loc_id,$temp_locations) && !in_array($value['group_id'],$temp_groups))
				{	
					$get_index = array_search($loc_id, $temp_locations); // 
					unset($temp_locations[$get_index]);
					
					$new_location_2 = '';
					foreach($temp_locations as $keys=>$values)
					{
						$new_location_2 .= $values.',';
					}
					
					$new_location_2 = substr($new_location_2,0,-1);
					
					$this->UpdateLocationGroup($value['group_id'],$new_location_2);
				}
			}
		}
	}
	
	public function AddNewGroupRecords($group_id,$location_id,$pages_id)
	{
		$connection	=	Yii::app()->db;
		
		$temp_location = explode(',',$location_id);
		
		if(count($temp_location))
		{
			foreach($temp_location as $key=>$value)	
			{
				if($value)
				{
					$value = str_replace('loc_','',$value);
					$value = str_replace('fb_','',$value);

					$loc_rec = $this->GetSpecLocation($value);
					
					if(!empty($loc_rec[0]['group_ids']))
						$new_group = $loc_rec[0]['group_ids'].','.$group_id;
					else
						$new_group = $group_id;
						
					$sql_2		=	"UPDATE location set group_ids = '".$new_group."' where loc_id=".$value;
					$result_2	=	$connection->createCommand($sql_2);
					$final_result	=	$result_2->execute();
				}
			}
		}
		
		return true;
	}
	
}