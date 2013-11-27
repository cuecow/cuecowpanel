<?php

/**
 * This is the model class for table "fbposts".
 *
 * The followings are the available columns in table 'fbposts':
 * @property string $post_id
 * @property string $name
 * @property string $page_id
 * @property string $content
 * @property string $url_link
 * @property string $message
 * @property string $photo
 * @property string $title
 * @property string $description
 * @property string $video
 * @property string $schedule_post
 * @property string $post_date
 * @property string $post_time
 * @property string $status
 * @property string $email_notify
 */
class Fbposts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Fbposts the static model class
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
		return 'fbpost';
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
			array('photo', 'file', 'types'=>'png,jpg,gif','allowEmpty'=>true),
			array('video', 'file', 'types'=>'3g2,3gp,3gpp,asf,avi,dat,divx,dv,f4v,flv,m2ts,m4v,mkv,mod,mov,mp4,mpe,mpeg,mpeg4,mpg,mts,nsv,ogm,ogv,qt,tod,ts,vob,wmv','allowEmpty'=>true,'maxSize'=>1024 * 1024 * 1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('post_id, name, page_id, content, url_link, message, photo, title, description, video, schedule_post, post_date, post_time, status, email_notify', 'safe', 'on'=>'search'),
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
			'post_id' => 'Post',
			'name' => 'Name',
			'page_id' => 'Page',
			'content' => 'Content',
			'url_link' => 'Url Link',
			'message' => 'Message',
			'photo' => 'Photo',
			'title' => 'Title',
			'description' => 'Description',
			'video' => 'Video',
			'schedule_post' => 'Schedule Post',
			'post_date' => 'Post Date',
			'post_time' => 'Post Time',
			'status' => 'Status',
			'email_notify' => 'Email Notify',
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

		$criteria->compare('post_id',$this->post_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('url_link',$this->url_link,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('video',$this->video,true);
		$criteria->compare('schedule_post',$this->schedule_post,true);
		$criteria->compare('post_date',$this->post_date,true);
		$criteria->compare('post_time',$this->post_time,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('email_notify',$this->email_notify,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function allpost()
	{
		$connection=Yii::app()->db;
		$sql="SELECT * FROM fbpost where user_id=".Yii::app()->user->user_id;
		$posts=$connection->createCommand($sql)->queryAll();
		return $posts;
	}
	
	public function CountSpecificPosts($pageid,$user_id = 0)
	{
		$connection=Yii::app()->db;
		
		if($user_id > 0)
			$sql="SELECT * FROM fbpost where user_id=".$user_id." and page_id=".$pageid." and status='posted'";
		else
			$sql="SELECT * FROM fbpost where user_id=".Yii::app()->user->user_id." and page_id=".$pageid." and status='posted'";
			
		$posts=$connection->createCommand($sql)->queryAll();
		
		return count($posts);
	}
	
	public function GetPageTokensFrom($pageid)
	{
		$connection=Yii::app()->db;
		$sql="SELECT token FROM user_pages_token where page_id=".$pageid." and user_id=".Yii::app()->user->user_id;
		$posts=$connection->createCommand($sql)->queryAll();
		
		return $posts;
	}
	
	public function latest_five_posts()
	{
		$connection=Yii::app()->db;
		$sql="SELECT * FROM fbpost where user_id=".Yii::app()->user->user_id." and status='posted' order by post_id desc limit 0,5";
		$posts=$connection->createCommand($sql)->queryAll();
		return $posts;
	}
	
	public function pagename()
	{
		$connection=Yii::app()->db;
		$sql="SELECT page_name FROM fbpages where page_id=".$_REQUEST['id'];
		$posts=$connection->createCommand($sql)->queryAll();
		return $posts;
	}
	
	public function GetFBPageName($id)
	{
		$connection=Yii::app()->db;
		$sql="SELECT page_name FROM fbpages where page_id=".$id;
		$posts=$connection->createCommand($sql)->queryAll();
		return $posts;
	}
	
	public function GetPage($id)
	{
		$connection=Yii::app()->db;
		$sql="SELECT page_name,page_id FROM fbpages where id=".$id;
		$posts=$connection->createCommand($sql)->queryAll();
		return $posts;
	}
	
	public function GetLoc($group_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT fburl,loc_id FROM location where group_ids like ('%".$group_id."%') and user_id=".Yii::app()->user->user_id;
		$url=$connection->createCommand($sql)->queryAll();
		
		return $url;
	}
	
	public function GetPageToekn($page_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT token FROM user_pages_token where page_id=".$page_id." and user_id=".Yii::app()->user->user_id;
		$url=$connection->createCommand($sql)->queryAll();
		
		return $url;
	}
	
	public function UpdateCampaignPost($posted_id,$campaign_id)
	{
		$sql="update campaign_fbpost set posted_id=".$posted_id." where campaign_id=".$campaign_id; 
		
		$result=$connection->createCommand($sql);
		
		$final_result=$result->execute();
	}
	
	public function GetUserEmail()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM user where user_id=".Yii::app()->user->user_id;
		$rec=$connection->createCommand($sql)->queryAll();
		
		return $rec;
	}
	
	public function GetFbID($loc_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT id FROM fburlinfo where loc_id=".$loc_id;
		$url=$connection->createCommand($sql)->queryAll();
		
		return $url;
	}
	
	public function GetFbInfo($loc_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT name FROM fburlinfo where loc_id =".$loc_id;
		$url=$connection->createCommand($sql)->queryAll();
		
		return $url;
	}
	
	public function getpagename()
	{
		$connection=Yii::app()->db;
		$sql="SELECT page_name FROM fbpages where page_id=(select page_id from fbpost where post_id='".$_REQUEST['id']."')";
		$posts=$connection->createCommand($sql)->queryAll();
		return $posts;
	}
	
	public function GetPostInfo($postid)
	{
		$connection=Yii::app()->db;
		$sql="SELECT * FROM fbpost where post_id=".$postid;
		$posts=$connection->createCommand($sql)->queryAll();
		return $posts;
	}
	
	public function PostImmediatelyInfo($pageid)
	{
		$connection=Yii::app()->db;
		$sql="SELECT * FROM fbposts where page_id=".$pageid." and status='pending' and post_date='' and post_time=''";
		$posts=$connection->createCommand($sql)->queryAll();
		return $posts;
	}
	
	public function StoreAccessToken($pageid,$access_token)
	{
		$connection=Yii::app()->db;
		
		$sql_chk="SELECT * FROM access_token where pageid=".$pageid." and accesstoken='".$access_token."'";
		$posts=$connection->createCommand($sql_chk)->queryAll();
		
		if(count($posts)==0)
		{
			$sql="insert into access_token(id,pageid,accesstoken) values('','".$pageid."','".$access_token."')";
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
		}
				
		return $final_result;
	}
	
	public function PickUserGroup()
	{
		$connection=Yii::app()->db;
		
		$sql_chk="SELECT * FROM location where user_id=".Yii::app()->user->user_id;
		$posts=$connection->createCommand($sql_chk)->queryAll();

		if(count($posts))
		{
			$groups = array();
			foreach($posts as $key=>$value)
			{	
				$temp_explode=explode(',',$value['group_ids']);	
				
				foreach($temp_explode as $keys=>$values)
				{
					if(!in_array($values,$groups))
						array_push($groups,$values);
				}
			}
		}
				
		return $groups;
	}
	
	public function PickUserNewGroup()
	{
		$connection=Yii::app()->db;
		
		$sql_chk="SELECT * FROM location_group where userid=".Yii::app()->user->user_id." and locations!=''";
		$posts=$connection->createCommand($sql_chk)->queryAll();
				
		return $posts;
	}
	
	public function UserPages()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM fbpages where user_id=".Yii::app()->user->user_id." and status='active'" ;
		$pages=$connection->createCommand($sql)->queryAll();
		
		return $pages;
	}
	
	public function GetGroup($groupid)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM location_group where group_id=".$groupid;
		$groups=$connection->createCommand($sql)->queryAll();
		
		return $groups;
	}
	
	public function EditFBPost($id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM fbpost where post_id=".$id;
		$fb_post = $connection->createCommand($sql)->queryAll();
		
		return $fb_post;
	}
	
	public function StoreInsightsAccessToken($pageid,$access_token)
	{
		$connection=Yii::app()->db;
		
		$sql_chk="SELECT * FROM access_token where pageid=".$pageid." and demo_access='".$access_token."'";
		$posts=$connection->createCommand($sql_chk)->queryAll();
		
		if(count($posts)==0)
		{
			$sql="insert into access_token(id,pageid,demo_access) values('','".$pageid."','".$access_token."')";
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
		}
				
		return $final_result;
	}
	
	public function DeleteFBPost($post_id)
	{
		$connection=Yii::app()->db;
		
		$sql="delete from fbpost where post_id=".$post_id; 
		
		$result=$connection->createCommand($sql);
		
		$final_result=$result->execute();
	}
	
	public function ChangeStatus($post_id)
	{
		$connection=Yii::app()->db;
		
		$sql="update fbposts set status='posted' where post_id=".$post_id; 
		
		$result=$connection->createCommand($sql);
		
		$final_result=$result->execute();
		
		if($final_result)
			return 1;
		else
			return 0;
	}
}