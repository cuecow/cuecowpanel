<?php

//Needs few files in the mix
require_once('api.php');

Yii::app()->session['language'] = 2;

if($_GET['id']) 
{
	$userid = $_GET['id'];//User Id
} else {
	$userid = 1;
}
?>

<div id="addkeywords">
	
    <?php if($run) { echo '<script>window.top.location.href="'.Yii::app()->request->baseUrl.'/index.php/user/buzz"</script>'; } ?>
    
    
  	<p><?php echo getContent('user.buzz.newkeywordmessage',Yii::app()->session['language']); ?>:</p>
  	
    <form name="keywords" action="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/keywords/id/<?php echo Yii::app()->user->user_id; ?>" method="POST">
  		<strong><?php echo getContent('user.buzz.brand',Yii::app()->session['language']); ?>:</strong><br />
  		<div class="clear"></div>
  		<textarea rows="3" cols="20" name="brand"><?php $result = $model->BuzztermCategory(1); foreach($result as $row) { echo $row['buzzterm_keywords'].', '; } ?></textarea><br/>
            
  		<strong><?php echo getContent('user.buzz.product',Yii::app()->session['language']); ?>:</strong><br />
  		<div class="clear"></div>
  		<textarea rows="3" cols="20" name="product"><?php $result = $model->BuzztermCategory(2); foreach($result as $row) { echo $row['buzzterm_keywords'].', ';} ?></textarea><br/>
        
  		<strong><?php echo getContent('user.buzz.person',Yii::app()->session['language']); ?>:</strong><br />
  		<div class="clear"></div>
  		<textarea rows="3" cols="20" name="person"><?php $result = $model->BuzztermCategory(3); foreach($result as $row) {echo $row['buzzterm_keywords'].', ';} ?></textarea><br/>
        
  		<strong><?php echo getContent('user.buzz.competitor',Yii::app()->session['language']); ?>:</strong><br />
  		<div class="clear"></div>
  		<textarea rows="3" cols="20" name="competitor"><?php $result = $model->BuzztermCategory(4); foreach($result as $row) {echo $row['buzzterm_keywords'].', ';}?></textarea><br/>
        
  		<strong><?php echo getContent('user.buzz.industryterm',Yii::app()->session['language']); ?>:</strong><br />
  		<div class="clear"></div>
  		<textarea rows="3" cols="20" name="industry"><?php $result = $model->BuzztermCategory(5); foreach($result as $row)  { echo $row['buzzterm_keywords'].', '; } ?></textarea><br/>
        
  		<input type="submit" value="Save" class="btn btn-large" style="margin-top: 10px;"/>
  		<input type="hidden" name="newkeys" value=""/>
  </form>
  
</div>