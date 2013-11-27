<?php
//require_once('connect.php');

function getSearchResult ( $url )
{

	$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER         => false,
		CURLOPT_FOLLOWLOCATION => false,
		CURLOPT_ENCODING       => '',
		CURLOPT_AUTOREFERER    => true,
		CURLOPT_MAXREDIRS      => 2,
		CURLOPT_SSL_VERIFYPEER => false // if making https req and do not care of ssl/https certificate then set it off
	);

	$ch  = curl_init( $url );

	curl_setopt_array( $ch, $options );

	$content	= curl_exec( $ch );
	$err		= curl_errno( $ch );
	$errmsg		= curl_error( $ch );
	$info		= curl_getinfo( $ch );

	curl_close( $ch );

	$output['errno']   = $err;
	$output['errmsg']  = $errmsg;
	$output['content'] = $content;

	return $output;

}

function checkBuzzterms($string) {
		$new_string = strip_tags($string);
		$bad = array("_", "/", ":", "(", ")", ",", ".");
		$new_string = str_replace($bad, " ", $new_string);
		//print $new_string;
		
		//creating an array
		$seen = array();
		
		$buzz_search = User::model()->BuzzSearchTerms();
		foreach($buzz_search as $key=>$row)
		{
			//print $row['buzzterm_keywords'];
			$key = $row['buzzterm_keywords'];
			$category = $row['buzzterm_category'];
			$return = '';
			
			if($category == 1)
			$category = 'Brand, ';
			if($category == 2)
			$category = 'Product, ';
			if($category == 3)
			$category = 'Person, ';
			if($category == 4)
			$category = 'Competitor, ';
			if($category == 5)
			$category = 'Industry Term, ';
			
			if(in_array($category, $seen))
				continue;


			if(!stristr($new_string, $key) === FALSE) {
				$seen[] = $category;
				echo $category;
			} 
		}	
	}

	function checkPOST($id) 
	{
		$post_id = User::model()->GetCatSources($id);

		if(count($post_id))
		{
			foreach($post_id as $keys=>$row)
			{
				if( $row != '' )
				{
					if(strstr($row['buzzterm_keywords'],'"'))
						$arr[] = $row['buzzterm_keywords'];
					else
						$arr[] = '"'.$row['buzzterm_keywords'].'"';
				}
			}
		
			if(count($arr))
			{
				$keyword = @implode('" OR "',$arr);
				//$keywords = $keyword.'" OR "';
				$keywords = $keyword.' OR ';
			}
		}
		else
			$keywords = "";
		
		return $keywords;	
	}

function checkPOSTall() {

		$buzz_search = User::model()->BuzzSearchTerms(1);
		
		if(count($buzz_search))
		{
			foreach($buzz_search as $key=>$row)
			{
				$arr[] = $row['buzzterm_keywords'];
			}

			if(count($arr))
				$keywords = implode('" OR "',$arr);	
		}
		else
			$keywords = "";
			
		//print $keywords;
		return $keywords;
}

function StripExtraSpace($s)
{
	for($i = 0; $i < strlen($s); $i++)
	{
		$newstr = $newstr . substr($s, $i, 1);
		if(substr($s, $i, 1) == ' ')
		while(substr($s, $i + 1, 1) == ' ')
		$i++;
	}
	return $newstr;
} 
?>
