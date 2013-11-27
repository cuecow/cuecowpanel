<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/picker/jquery-1.6.4.min.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/mediaplayer/jwplayer.js"></script>

<div class="container container-top">
	<div class="row-fluid" style="min-height:350px;">
    	

	<?php 
	
	$pname=$model->getpagename();
	$pagename=$pname[0]['page_name'];

	?>
    	<?php $form=$this->beginWidget('CActiveForm', array('id'=>'fbposts-form','enableClientValidation'=>true,'htmlOptions'=>array('enctype'=>'multipart/form-data','class'=>'styled'),'clientOptions'=>array('validateOnSubmit'=>true,),)); ?>
        
        <table class="table table-bordered table-condensed"> 
        <tbody> 
        <tr>
            <td width="15%"><b>Name</b></td>
			<td><? echo $model->name; ?></td>
		</tr>
        <tr>
            <td><b>Post content type</b></td>
			<td><? echo ucfirst($model->content_type); ?></td>
		</tr>
        <tr>
        	<td><b>Message</b></td>
            <td><?php echo $model->message; ?></td>
        </tr>
					
		<? if($model->content_type=='text') { ?>
		
        <tr id="text">									
            <?php if($model->title) { ?>
            
            <td><label><b>Title</b> :-</label></td>
            <td><?php echo $model->title; ?></td>
                
			<?php } if($model->description) { ?>
            	
            <td><b>Description</b> :-</label></td>
            <td><?php echo $model->description; ?></td>
                
			<?php } if($model->post_date) { ?>
            
            <td><b>Post Date</b> :-</label></td>
            <td><?php echo $model->post_date; ?> at <?php echo $model->post_time; ?></td>
            
			<?php } ?>
								
		</tr>
								
		<? } else if($model->content_type=='photo'){ if( file_exists(Yii::app()->request->baseUrl.'/images/fbposts/'.$model->photo) ) { ?>
								
		<tr id="photo">
        
        	<td><b>Photo</b> :-</label></td>
            <td><img src="<? echo Yii::app()->request->baseUrl ?>/phpthumb/phpThumb.php?src=<? echo Yii::app()->request->baseUrl ?>/images/fbposts/<?=$model->photo;?>&h=200&w=230"  /></td>
		
        </tr>
        									
		<? } } else if($model->content_type=='video'){ ?>
								
		<tr id="video">
        
        	<td><b>Video</b> :-</td>
            
            <?php 
                                        
			$show_main='<script type="text/javascript"> jwplayer("display_container").setup({ flashplayer: "/static/js/mediaplayer/player.swf", file: "/static/vid/a.flv", height: 200, width: 230 }); </script>';
				
			$show_main='<script type="text/javascript"> jwplayer("display_container").setup({ flashplayer: "'.Yii::app()->request->baseUrl.'/assets/js/mediaplayer/player.swf", file: "'.Yii::app()->request->baseUrl.'/images/fbposts/'.$model->video.'", height: 200, width: 230 }); </script>';
							
			?>
            <td><span id="display_container"><?php echo $show_main; ?></span></td>
												
		</tr>
		
		<? } ?>
            
		</tbody>							
        </table>
        
        <a class="btn btn-large" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/Manage">Go Back</a>
        
		<?php $this->endWidget(); ?>
				
	</div>
</div>

<script>
function confirmSubmit(url)
{
	var agree=confirm("Are you sure you wish to continue?");
	
	if (agree)
	{
		window.location.href=url;
		return true ;
	}
	else
		return false ;
}
</script>