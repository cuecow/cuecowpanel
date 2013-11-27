<?php
include('../connection.php');

if(!empty($_REQUEST['userid']))
{
	$categories = '';
	
	if(!empty($_REQUEST['category']))
		$categories .= 'category='.$_REQUEST['category'].'&';
	if(!empty($_REQUEST['category1']))
		$categories .= 'category1='.$_REQUEST['category1'].'&';
	if(!empty($_REQUEST['category2']))
		$categories .= 'category2='.$_REQUEST['category2'].'&';
	if(!empty($_REQUEST['category3']))
		$categories .= 'category3='.$_REQUEST['category3'].'&';
	if(!empty($_REQUEST['category4']))
		$categories .= 'category4='.$_REQUEST['category4'].'&';
	if(!empty($_REQUEST['category5']))
		$categories .= 'category5='.$_REQUEST['category5'].'&';
	
	$GetExists = mysql_query('select * from user_buzz_category where userid="'.$_REQUEST['userid'].'"')or die(mysql_error());	
	
	if(mysql_num_rows($GetExists)==0)
		$insert = mysql_query('insert into user_buzz_category(userid,categories) values("'.$_REQUEST['userid'].'","'.$categories.'")')or die(mysql_error());
	else
		$update = mysql_query('update user_buzz_category set categories="'.$categories.'" where userid="'.$_REQUEST['userid'].'"')or die(mysql_error());
}

?>