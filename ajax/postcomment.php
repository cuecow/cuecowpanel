<?php
if (empty($_POST['id']) && empty($_POST['msg'])) 
{
	$return['error'] = true;
	$return['msg'] = '';
}
else 
{
	$return['error'] = false;
	
	$comment_id = $_POST['id'];
	$access_token = $_POST['accesstoken'];
	$message = $_POST['msg'];
	$post_url = "https://graph.facebook.com/".$comment_id."/comments?access_token=".$access_token;
	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $post_url);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "message=".$message);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
	$result = curl_exec($ch); // run the whole process 
	
	if(strstr($result,'id'))
	{
		$contents = @file_get_contents('https://graph.facebook.com/'.$comment_id.'/comments?access_token='.$access_token);
		$values = json_decode($contents);
		
		$return['msg'] ='';
		
		if(count($values->data)) 
		{  
			$return['msg'] .='
			<tr>
				<td>';
				
			$return['msg'] .='<div style="padding:5px; width:450px; margin-left:20px;">
			<table>';
					
			foreach($values->data as $key1=>$value1)
			{
				$return['msg'] .='<tr>
				<td width="60">';
								
				if($value1->from->id)
					$return['msg'] .='<img src="https://graph.facebook.com/'.$value1->from->id.'/picture?type=square" width="40" height="40" />
								
				</td>
				<td>
					<table>
					<tr>
						<td>
							<span style="color:#036; font-weight:bold;">'.$value1->from->name.'</span>
						</td>
					</tr>
					<tr>
						<td>
							<span style="color:#000;">
								'.$value1->message.'
							</span>
						</td>
					</tr>
					<tr>
						<td>';
							if($value1->created_time) 
							{
								$temp_t_1 = explode('T',$value1->created_time);	
								$date_t_1 = $temp_t_1[0];
												
								if($temp_t_1[1])
									$temp_t_2 = explode('+',$temp_t_1[1]);
												
								$time_t_2 = $temp_t_2[0];
							}
										
							$return['msg'] .=$date_t_1.' at '.$time_t_2;
										
							$return['msg'] .='</td>
					</tr>
					</table>
				</td>
			</tr>';
			
			}
			
			$return['msg'] .='</table>
					
			</div>';
					
			$return['msg'] .='</td>
		</tr>';
		}
	}
	else
		$return['msg']='<tr><td>message could not be posted</td></tr>';
	
	curl_close($ch);
	
	
}

echo json_encode($return);
	

	
?>