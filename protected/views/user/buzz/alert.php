<?php

//Needs few files in the mix

require_once('api.php');
$userid = $_GET['id'];

$value = '';
if($_GET['category'] || $_GET['category1'] || $_GET['category2'] || $_GET['category3'] || $_GET['category4'] || $_GET['category5']) 
{	
	if($_GET['category']) 
	{
		$key = checkPOSTall($userid);
		//print $key;
	}

	if($_GET['category1']) 
		$key1 = checkPOST($_GET['category1'],$userid);
		
	if($_GET['category2']) 
		$key2 = checkPOST($_GET['category2'],$userid);
		
	if($_GET['category3']) 
		$key3 = checkPOST($_GET['category3'],$userid);
		
	if($_GET['category4']) 
		$key4 = checkPOST($_GET['category4'],$userid);
		
	if($_GET['category5']) 
		$key5 = checkPOST($_GET['category5'],$userid);
		
	//print $key.$key1.$key2.$key3.$key4.$key5;
		
	$val = $key.$key1.$key2.$key3.$key4.$key5;
	$value = $val;
		//print $value;
}
else 
{
	$key = checkPOSTall($userid);
	$val = $key;
	$value = $val;
	//print $value;
}

Yii::app()->session['language'] = 2;

?>

<!--<a class="btn btn-info" style="float:right;" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/getalert/id/<?php echo Yii::app()->user->user_id; ?>"><?php echo getContent('user.buzz.managecurrentalert',Yii::app()->session['language']); ?></a>
<br /><br />
-->
<p><?php echo getContent('user.buzz.timeperiod',Yii::app()->session['language']); ?> </p>
  	
<p><?php echo str_replace('[Click Here]','<a href="#myModalKeywords" data-toggle="modal">Click here</a>',getContent('user.buzz.edit',Yii::app()->session['language'])); ?></p>
	
<form name="alert" action="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/addalert/id/<?php echo Yii::app()->user->user_id; ?>" method="POST">

<strong><?php echo getContent('user.buzz.keymonitor',Yii::app()->session['language']); ?>:</strong><br />

<textarea rows="3" cols="20" name="Query" class="alertkeys"><?php echo $value; ?></textarea><br />
<div class="clearfix"></div><br />

<div class="alert-source">
	<span class="label">
		<?php echo getContent('user.buzz.selectsource',Yii::app()->session['language']); ?>:
	</span>
    <select id="source" name="source" class="select">
        <?php
        $result = $model->GetSources();
        foreach($result as $row) {
        ?>
        <option value="<?php echo $row['source_value'];?>" <?php if($_GET['source']==$row['source_value']){ echo 'selected="selected"';}?>><?php echo $row['source_title'];?></option>
        <?php
        }
        ?>
    </select>
</div>
<div class="alert-language">
    <span class="label"><?php echo getContent('user.buzz.selectlang',Yii::app()->session['language']); ?>:</span>
    <select id="lang" name="language" class="select">
        <option value="">All Languages</option>
        <option value="en" <?php if($_GET['language']=='en'){ echo 'selected="selected"';}?>>English</option>
        <option value="da" <?php if($_GET['language']=='da'){ echo 'selected="selected"';}?>>Danish</option>
    </select>
</div>
<div class="clear" style="height: 10px;"></div>
<div class="email">
    <span class="label"><?php echo getContent('user.buzz.towhatemails',Yii::app()->session['language']); ?><i><?php echo getContent('user.buzz.multiplemails',Yii::app()->session['language']); ?></i></span>
    <div class="clear"></div>
    <input type="text" class="input" name="Delivery" value="Enter email(s)" onfocus="if (this.value == 'Enter email(s)') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Enter email(s)';}"/>
</div>
<div class="often">
    <span class="label"><?php echo getContent('user.buzz.howoften',Yii::app()->session['language']); ?></span>
    <select name="Frequency" id="cronjob" class="select">
        <option value="1">As-it-happens</option>
        <option value="2">Once a day</option>
        <option value="3">Once a week</option>
    </select>
</div>
<div class="clear"></div>
<input type="hidden" name="Volume" value="Only the best results"/>
<input type="hidden" name="Type" value="Everything"/>
<input type="submit" value="Save" name="submit" class="btn btn-large" style="margin-top: 10px;"/>
</form>