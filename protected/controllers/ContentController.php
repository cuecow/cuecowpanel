<?php

class ContentController extends Controller
{
	public function actionIndex()
	{
		$model = new Contents;
		
		$all_languages = Languages::model()->GetAllLanguage();
		
		if(isset($_POST['Contents']))
		{
			if(!empty($_POST['Contents']['content_id']))
			{
				foreach($all_languages as $langs) 
				{ 
					if($_POST['content_text_'.$langs['lang_id']])
						$model->UpdateContent($_POST['Contents']['content_id'],$_POST['content_text_'.$langs['lang_id']],$langs['lang_id']);
				}
			}
			else
				$model->addError('content_id','Content id can not be blank.');
		}
		
		if($_REQUEST['content_id'])
		{
			$SingleRecord = $model->GetSingleRecord($_REQUEST['content_id']);	
		}
		
		// Get Page Title
		$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],'');
		
		//Collect all records
		
		if(!empty($_REQUEST['keyword']))
			$AllRec = $model->SearchRecord($_REQUEST['keyword'],$_REQUEST['keyword']); 
		else if(empty($_REQUEST['contentText']) && empty($_REQUEST['contentId']))
			$AllRec = $model->GetAllRecord(); 
		else
			$AllRec = $model->SearchRecord($_REQUEST['contentId'],$_REQUEST['contentText']); 
		

		$this->render('index',array('model'=>$model,'PageTitle'=>$PageTitle,'SingleRecord'=>$SingleRecord,'all_languages'=>$all_languages,'AllRec'=>$AllRec));
		
	}
	
	public function actionDeletecontent()
	{
		$model = new Contents;
		
		if(!empty($_REQUEST['content_id']))
			$DelContent = $model->DeleteContent($_REQUEST['content_id']);
		
		$this->redirect(array('content/index'));
		
	}
	
	public function actionClear()
	{
		$model = new Contents;
		
		Yii::app()->cache->flush();
		
		$this->redirect(array('content/index'));
		
	}
	
	public function actionEditcontent()
	{
		$model = new Contents;
		
		$record = $model->GetRecord($_POST['content_id'],$_POST['lang']);
		
		echo '<textarea class="small textbox" style="width:500px; height:50px;" id="content_text_'.$_POST['row'].'" onblur="SaveText(this.value,\''.$_POST['content_id'].'\','.$_POST['row'].','.$_POST['lang'].')">'.$record['content_text'].'</textarea>';
	}
	
	public function actionSavecontents()
	{
		$model = new Contents;
		
		$record_save = $model->EditAjaxContent($_REQUEST['content_id'],$_REQUEST['txt'],$_REQUEST['lang']);
		
		$record_s = $model->GetRecord($_REQUEST['content_id'],$_REQUEST['lang']);
		
		echo $record_s['content_text'];
	}
}