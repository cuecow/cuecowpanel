<?php
include('../connection.php');

if (!empty($_POST['id']) && !empty($_POST['userid'])) 
{
	
	$return['error'] = false;
	
	if($_POST['id']==1)
	{
		$return['msg'] = '<select style="height:40px; padding:10px; outline:none; width:350px;" name="selected_wall" id="selected_wall"><option value="0">Select</option>';
		
		$GetSel = mysql_query('select * from fbpages where user_id="'.$_POST['userid'].'" and status="active"')or die(mysql_error());
		
		if(mysql_num_rows($GetSel))
		{
			while($ShowRes = mysql_fetch_assoc($GetSel))
			{
				$return['msg'] .='<option value="'.$ShowRes['id'].'">'.htmlentities($ShowRes['page_name']).'</option>';
			}
		}
		
		$return['msg'] .='</select>';
	}
	else if($_POST['id']=='2')
	{
		$return['msg'] = '<select style="height:40px; padding:10px; outline:none; width:350px;" name="selected_wall" id="selected_wall"><option value="0">Select</option>';
		
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