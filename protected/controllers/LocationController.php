<?php

class LocationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','compareurl'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','searchurl','location','onelocation','editlocation','deletelocation'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Location;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		echo $_POST['ajax']."asdfasdf";
		print_r($_POST['ajax']);
		
		
		if(isset($_POST['Location']))
		{
			$model->attributes=$_POST['Location'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->loc_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Location']))
		{
			$model->attributes=$_POST['Location'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->loc_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Location');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Location('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Location']))
			$model->attributes=$_GET['Location'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function get_http_response_code($url) 
	{
    	$headers = @get_headers($url);
	    return substr($headers[0], 9, 3);
	}
	
	public function actionCompareurl()
	{
		$model=new Location;
		
		$request = array();
		
		$strfburl = $_REQUEST['url'];
		$sfb = explode("/",$strfburl);
					
		$id = $sfb[count($sfb)-1];
		
		$fburl = 'http://graph.facebook.com/'.$id;
		$fbcontent = @file_get_contents($fburl);
		$fbvalues = json_decode($fbcontent);
		$request['newlikes'] = $fbvalues->likes;
		$request['checkins'] = $fbvalues->checkins;

		$request['url'] 					= $_REQUEST['url'];
		$request['fb_likes'] 				= $_REQUEST['fblikes'];
		$request['fb_daily_new_likes'] 		= $_REQUEST['fb_daily_new_likes'];
		$request['total_like_img'] 			= $_REQUEST['total_like_img'];
		$request['daily_new_like_img'] 		= $_REQUEST['daily_new_like_img'];
		$request['fb_total_checkins'] 		= $_REQUEST['fb_total_checkins'];
		$request['fb_dailynew_checkins'] 	= $_REQUEST['fb_dailynew_checkins'];
		$request['fb_total_checkins_img'] 	= $_REQUEST['fb_total_checkins_img'];
		$request['fb_dailynew_checkins_img']= $_REQUEST['fb_dailynew_checkins_img'];
		$request['categories1'] 			= $_REQUEST['categories1'];
		$request['data1'] 					= $_REQUEST['data1'];
		$request['categories2'] 			= $_REQUEST['categories2'];
		$request['data2'] 					= $_REQUEST['data2'];
		$request['mypage']					= $_REQUEST['mypage'];
		$request['comp_page']				= $id;
		
		
		$this->renderPartial('compareurl',array(
			'model'=>$model,
			'request'=>$request,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Location::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='location-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionLocation()
	{
		include('google/simple_html_dom.php');
		
		$model = new Location;
		
		$validate=0;
		
		if(isset($_POST['Location']))
		{	
			if(empty($_POST['Location']['name']))
			{
				$model->addError('name','Location name can not be blank.');
				$validate++;
			}
			
			if(empty($_POST['Location']['fburl']) and empty($_POST['Location']['fsurl']) and empty($_POST['Location']['googleurl']))
			{
				$model->addError('fburl','Fill at least one location');
				$validate++;		
			}
			
			$GetLimitUsers = User::model()->ValidateLimits();
			
			$CountUserLocation = $model->CountUserLocation();
			
			if($GetLimitUsers[0]['max_num_venues'] <= $CountUserLocation && Yii::app()->user->user_id!=1)
			{
				$model->addError('user_id','You have reached the maximum number of venues for your account. Please upgrade to create more venues.');
				$validate++;
			}
			
			if($validate==0)
			{
				if(count($_POST['group_ids']))
				{	
					$group_ids='';
					
					foreach($_POST['group_ids'] as $key=>$value)
					{
						if(!empty($value))
						{
							$group_ids .=$value.',';
						}
					}
				}
				
                                $today_date = date('m/d/Y');
				$model->user_id		=	Yii::app()->user->user_id;
				$model->group_ids	=	substr($group_ids,0,strlen($group_ids)-1);
				$model->name		=	$_POST['Location']['name'];
				$model->fburl		=	$_POST['Location']['fburl'];
				$model->fsurl		=	$_POST['Location']['fsurl'];
				$model->googleurl	=	$_POST['Location']['googleurl'];
				$model->dated		=	strtotime($today_date);
				
				if(!empty($_POST['Location']['fburl']))
				{
					$countfb=$model->checkexist('fburl');
					
					if($countfb!=0)
					{
						$model->addError('fburl','This Facebook url already exists');
						$exist++;
					}
					
					$strfburl=$_POST['Location']['fburl'];
					$sfb=explode("/",$strfburl);
					
					$id=$sfb[count($sfb)-1];
					
					if($this->get_http_response_code('https://graph.facebook.com/'.$id) == '404')
					{
						$model->addError('fburl','This is not a valid Facebook Url');
						$exist++;
					}
				}
				
				if(!empty($_POST['Location']['fsurl']))
				{
					$countfs = $model->checkexist('fsurl');
					
					if($countfs!=0)
					{
						$model->addError('fsurl','This Foursquare url already exists');
						$exist++;
					}
					
					$strfsurl=$_POST['Location']['fsurl'];
					$sfs=explode("/",$strfsurl);
					
					$sfs_id=$sfs[count($sfs)-1];
					
					if($sfs_id!='')
						$contentsfs = json_decode(@file_get_contents('https://api.foursquare.com/v2/venues/'.$sfs_id.'?oauth_token=WB1EEUGJ1QJXP0MNPUPGX5GRWJK0BYISN5YZONI0TOVZ31ID&v='.date('Ymd')));
					else
						$contentsfs='';
					
					if($contentsfs=='')
					{
						$model->addError('fsurl','This is not a valid Foursquare Url');
						$exist++;
					}
				}
					
				if(!empty($_POST['Location']['googleurl']))
				{
					$countgoogle = $model->checkexist('googleurl');
					
					if($countgoogle != 0)
					{
						$model->addError('googleurl','This Google url already exists');
						$exist++;
					}
					
					if(!strstr($_POST['Location']['googleurl'],'https://plus.google.com'))
					{
						$model->addError('googleurl','Google URL should be like https://plus.google.com/xxxxxxxxxxxxxx');
						$exist++;
					}
				}
				
				if($exist == 0)
				{
					if(count($_POST['group_ids']))
					{	
						$group_ids_group = '';
						
						foreach($_POST['group_ids'] as $key=>$value)
						{
							if(!empty($value))
							{
								$group_ids_group .=$value.',';
							}
						}
					}
					
					if($model->save())
					{
						if(!empty($group_ids_group))
						{
							$group_ids_group = substr($group_ids_group,0,strlen($group_ids_group)-1);

							LocationGroup::model()->AddLocationtoGroup($model->loc_id,$group_ids_group);
						}
						
						$model->insertfbdata($model->loc_id);
					}
					
					$this->redirect(array('location'));
				}
			}
		}
		
		if(isset($_REQUEST['group_id']))
			$group_id	=	$_REQUEST['group_id'];
		else if(isset($_POST['LocationGroup']['group_id']))
			$group_id	=	$_POST['LocationGroup']['group_id'];
		
		if(empty($group_id))
			$model_group	=	new LocationGroup;
		else
		{
			$model_group	=	LocationGroup::model()->findByPk($group_id);
			$GetGroupLoc	=	LocationGroup::model()->GetGroupLoc($group_id);
			
			$loc_array = array();
			$pages_array = array();
			
			if(count($GetGroupLoc))
			{	
				if(!empty($GetGroupLoc[0]['locations']))
				{
					$temp_loc_ex = explode(',',$GetGroupLoc[0]['locations']);	
					
					foreach($temp_loc_ex as $key1=>$value1)
					{
						if(!in_array($value1,$loc_array))	
							array_push($loc_array,$value1);
					}
				}
				
				if(!empty($GetGroupLoc[0]['fbpages']))
				{
					$temp_pages_ex = explode(',',$GetGroupLoc[0]['fbpages']);	
					
					foreach($temp_pages_ex as $key2=>$value2)
					{
						if(!in_array($value2,$pages_array))	
							array_push($pages_array,$value2);
					}
				}
			}
		}
		
		
		$all_venues 	= 	LocationGroup::model()->GetAllLocations();
		$facebook_pages	= 	LocationGroup::model()->GetFacebookPages();
			
		$insrtd_group=0;
				
		if($_POST['LocationGroup'])
		{	
			$group_location = '';
			$group_pages = '';
			$error_group = 0;

			if(empty($_POST['LocationGroup']['name']))
			{
				$this->redirect(array('location/location/view/AddGroups/err/1'));
			}

			if(count($_POST['itemsToAdd']))
			{
				foreach($_POST['itemsToAdd'] as $key=>$value)
				{
					if(!empty($value))
					{
						if(strstr($value,'loc_'))
							$group_location .= str_replace('loc_','',$value).',';
						
						if(strstr($value,'fb_'))
							$group_pages .= str_replace('fb_','',$value).',';
					}
				}
			}
			
			if(!isset($_POST['LocationGroup']['group_id']))
			{
				$model_group->name			=	$_POST['LocationGroup']['name'];
				$model_group->locations		=	substr($group_location,0,-1);
				$model_group->fbpages		=	substr($group_pages,0,-1);
				
				$model_group->userid		=	Yii::app()->user->user_id;
			}
			else
			{
				//$model_group->attributes =	$_POST['LocationGroup'];
				
				$model_group->group_id		=	$_POST['LocationGroup']['group_id'];
				$model_group->name			=	$_POST['LocationGroup']['name'];
				$model_group->locations		=	substr($group_location,0,-1);
				$model_group->fbpages		=	substr($group_pages,0,-1);
			}
		
		
		
			if($model_group->validate())
			{
				$model_group->save();
						
				if(isset($_POST['LocationGroup']['group_id']))
					$new_group_id = $_POST['LocationGroup']['group_id'];
				else
					$new_group_id = $model_group->group_id;

				LocationGroup::model()->AddNewGroupRecords($new_group_id,substr($group_location,0,-1),substr($group_pages,0,-1));
				
				$insrtd_group=1;
			}		
		}

		if($_REQUEST['act']=='del')
		{
			$delete_group=$model_group->DeleteGroups($_REQUEST['group_id']);
			$this->redirect(array('location/location/view/Groups'));
		}
		
		$this->render('location',array(
			'model'=>$model,'model_group'=>$model_group,'insrtd_group'=>$insrtd_group,'all_venues'=>$all_venues,'facebook_pages'=>$facebook_pages,'GetGroupLoc'=>$GetGroupLoc,'loc_array'=>$loc_array,'pages_array'=>$pages_array,'PageTitle'=>$PageTitle
		));
	}
	
	public function actionEditlocation($id)
	{
		include('google/simple_html_dom.php');
		
		$model=$this->loadModel($id);
		
		$validate=0;
		

		if(isset($_POST['Location']))
		{	
			
			if(empty($_POST['Location']['name']))
			{
				$model->addError('name','Fill at least one location');
				$validate++;
			}
			
			if(empty($_POST['Location']['fburl']) and empty($_POST['Location']['fsurl']) and empty($_POST['Location']['googleurl']))
			{
				$model->addError('fburl','Fill at least one location');
				$validate++;
			}
			
			if($validate==0)
			{
				if(count($_POST['group_ids']))
				{	
					$group_ids='';
					
					foreach($_POST['group_ids'] as $key=>$value)
					{
						if(!empty($value))
						{
							$group_ids .=$value.',';
						}
					}
				}
			
				LocationGroup::model()->EditLocationGroup($id,substr($group_ids,0,-1));
				
				$model->user_id		=	Yii::app()->user->user_id;
				$model->group_ids 	=	$group_ids;
				$model->name		=	$_POST['Location']['name'];
				$model->fburl		=	$_POST['Location']['fburl'];
				$model->fsurl		=	$_POST['Location']['fsurl'];
				$model->googleurl	=	$_POST['Location']['googleurl'];
				
				if(!empty($_POST['Location']['fburl']))
				{
					/*$countfb=$model->checkfbexist1();
					if($countfb!=0)
					{
					    $model->addError('fburl','This Facebook url already exists');
						$exist++;
					}*/
				}
				if(!empty($_POST['Location']['fsurl']))
				{
					/*$countfs=$model->checkfsexist1();
					if($countfs!=0)
					{
					    $model->addError('fsurl','This Foursquare url already exists');
						$exist++;
					}*/
				}
				if(!empty($_POST['Location']['googleurl']))
				{
					/*$countgoogle=$model->checkgoogleexist1();
					if($countgoogle!=0)
					{
					    $model->addError('googleurl','This Google url already exists');
						$exist++;
					}*/
				}
				if($exist==0)
				{
					if($model->save())
					{
						// Update locations in group
						/*$UserGroups = LocationGroup::model()->AllGroups();
						
						if(count($UserGroups))
						{
							foreach($UserGroups as $key=>$value)	
							{
								$temp_locations = explode(',',$value['locations']);
								
								if(count($temp_locations))
								{
									$new_locations = '';
									
									foreach($temp_locations as $loc_key=>$loc_value)
									{
										$CheckLocation = LocationGroup::model()->GetSpecLocation($loc_value);
										
										if(count($CheckLocation))
										{
											$new_locations .= $loc_value.',';
										}
									}
									
									$UpdateNewLocation = LocationGroup::model()->UpdateLocationGroup($value['group_id'],substr($new_locations,0,-1));
								}
							}
						}*/
						
						$model->updatesocialrecord($model->loc_id);
					}
					
					$this->redirect(array('location'));
				}
			}
		}
		
		// Get Page Title
		$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);
		
		$this->render('editlocation',array('model'=>$model,'PageTitle'=>$PageTitle));
	}
	
	public function actionDeletelocation($id)
	{
		// delete from multiple tables 
		
		$GetLocation = Location::model()->GetSpecificUrl($id);
		
		if($GetLocation[0]['fburl'])
		{
			$DelFB =Location::model()->DelData($id,'fburlinfo','fburl_data','fburl_id');
			$DelDemo =Location::model()->DelDemo($id);
		}
		
		if($GetLocation[0]['fsurl'])
			$DelFS =Location::model()->DelData($id,'fsurlinfo','fsurl_data','fsurl_id');
		
		if($GetLocation[0]['googleurl'])
			$DelG =Location::model()->DelData($id,'gurlinfo','gurl_data','gurl_id');
		
		//$model=Location::model()->findByPk($id)->delete();
		
		if(Location::model()->deletefromlocation($id))
		{
			// Update locations in group
			$UserGroups = LocationGroup::model()->AllGroups();
			
			if(count($UserGroups))
			{
				foreach($UserGroups as $key=>$value)	
				{
					$temp_locations = explode(',',$value['locations']);
					
					if(count($temp_locations))
					{
						$new_locations = '';
						
						foreach($temp_locations as $loc_key=>$loc_value)
						{
							if($loc_value!='')
							{
								$CheckLocation = LocationGroup::model()->GetSpecLocation($loc_value);
								
								if(count($CheckLocation))
								{
									$new_locations .= $loc_value.',';
								}
							}
						}
						
						$UpdateNewLocation = LocationGroup::model()->UpdateLocationGroup($value['group_id'],substr($new_locations,0,-1));
					}
				}
			}
		
			$this->redirect(array('location'));
		}
	}
	
	public function actionOnelocation()
	{
		
		include('google/simple_html_dom.php');
		
		$model = new Location;
		
		$request = array();
		
		$UserLocation = $model->GetSpecificUrl($_REQUEST['id']);
		
		if(count($UserLocation)==0)
			$this->redirect(array('location/location'));
		
		if( isset($_POST['another_fburl']))
		{	
			$strfburl = $_POST['another_fburl'];
			$sfb = explode("/",$strfburl);
						
			$id = $sfb[count($sfb)-1];
			
			$fburl = 'http://graph.facebook.com/'.$id;
			$fbcontent = @file_get_contents($fburl);
			$fbvalues = json_decode($fbcontent);
			
			
			$request['newlikes'] = $fbvalues->likes;
			$request['checkins'] = $fbvalues->checkins;
			$request['name'] = $fbvalues->name;
			
			$strfburl2 = $_POST['cur_url'];
			$sfb2 = explode("/",$strfburl2);
						
			$id2 = $sfb2[count($sfb2)-1];
			$fburl2 = 'http://graph.facebook.com/'.$id2;
			$fbcontent2 = @file_get_contents($fburl2);
			$fbvalues2 = json_decode($fbcontent2);
			
			
			$request['newlikes2'] = $fbvalues2->likes;
			$request['checkins2'] = $fbvalues2->checkins;
			$request['name2'] = $fbvalues2->name;
			
		}
		
		$this->render('onelocation',array('model'=>$model,'request'=>$request));
	}
	
	public function actionSearchurl()
	{
		$model = new Location;
		$url = $_POST['url'];
		$from = $_POST['from'];
		$id = $_POST['id'];
		
		if($url != '')
		{
			//if(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url))
			//{
				$GetRec = $model->SearchURL($url,$from,$id);
				
				if(count($GetRec))
				{
					echo '<table border="0" width="100%"><tr><td width="40%"><b>Venue Name<b></td><td width="60%"><b>Venue URL</b></td></tr>';
					
					foreach($GetRec as $key=>$value)
					{
						echo '<tr><td>'.$value['name'].'</td><td><a href="'.$value['fburl'].'">'.$value['fburl'].'<a/></td></tr>';	
					}
					
					echo '</table>';
				}
				else
					echo '<span style="color:#FF0000;">No Matching URL.</span>';	
			//}
			//else
			//{
				//echo '<span style="color:#FF0000;">Please Enter Valid URL.</span>';	
			//}
		}
		//else
		//{
			//echo '<span style="color:#FF0000;">Please Enter URL First.</span>';	
		//}
	}
}
