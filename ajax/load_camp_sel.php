<?php
include('../connection.php');

if (!empty($_POST['id']) && !empty($_POST['userid'])) 
{
	
	$return['error'] = false;
	
	if($_POST['id']==1)
	{
		$GetSel = mysql_query('select * from location where user_id="'.$_POST['userid'].'"')or die(mysql_error());
		
		$return['msg'] = '<select style="height:40px; padding:10px; outline:none; width:350px;" name="groups" id="groups"><option value="0">Select</option>';
		
		if(mysql_num_rows($GetSel))
		{
			while($ShowRes = mysql_fetch_assoc($GetSel))
			{
				$return['msg'] .='<option value="'.$ShowRes['loc_id'].'">'.stripslashes(htmlentities($ShowRes['name'])).'</option>';
			}
		}
		
		$return['msg'] .='</select>';
	}
	else if($_POST['id']=='2')
	{
		$return['msg'] = '<select style="height:40px; padding:10px; outline:none; width:350px;" name="groups" id="groups"><option value="0">Select</option>';
		
		$GetSel = mysql_query('select * from location_group where userid="'.$_POST['userid'].'"')or die(mysql_error());
		
		if(mysql_num_rows($GetSel))
		{
			while($ShowRes=mysql_fetch_assoc($GetSel))
			{
				$return['msg'] .='<option value="'.$ShowRes['group_id'].'">'.htmlentities($ShowRes['name']).'</option>';
			}
		}
		
		$return['msg'] .='</select>';
	}
	else if($_POST['id']=='3')
	{
		$return['msg'] = '';
	}
}
else 
{
	$return['error'] = true;
	$return['msg'] = '';
}

echo json_encode($return);



?>