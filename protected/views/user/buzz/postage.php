<?php

	require_once('api.php');
	
	Yii::app()->session['language'] = 2;
	
	$language = ''; //Default language
	
	if($_GET['id']) 
		$userid = $_GET['id'];//User Id
	else 
		$userid = Yii::app()->user->user_id;

	if($_POST['language'] == 'da') 
		$language = 'lang_da';
	else 
		$language = 'lang_en';
	
	$value = '';
	
	if( $_POST['category'] || $_POST['category1'] || $_POST['category2'] || $_POST['category3'] || $_POST['category4'] || $_POST['category5'] ) 
	{	
		if($_POST['category'])
			$key = checkPOSTall($userid);
			//print $key;

		if($_POST['category1']) 
			$key1 = checkPOST($_POST['category1'],$userid);
		
		if($_POST['category2']) 
			$key2 = checkPOST($_POST['category2'],$userid);
		
		if($_POST['category3']) 
			$key3 = checkPOST($_POST['category3'],$userid);
		
		if($_POST['category4']) 
			$key4 = checkPOST($_POST['category4'],$userid);
		
		if($_POST['category5']) 
			$key5 = checkPOST($_POST['category5'],$userid);
		
		if($_POST['source']) 
		{
			$value = '"'.$key.$key1.$key2.$key3.$key4.$key5.' site: '.$_POST['source'];
			//print $value;	
		} 
		else 
		{
			$value = '"'.$key.$key1.$key2.$key3.$key4.$key5;
			//print $value;
		}
	}
	else 
	{
		print_r($source);
		if($_POST['source']) 
		{
			$key = checkPOSTall($userid);
			$value = '"'.$key.'" site:'.$_POST['source'];
		
			//print $value;
		} 
		else 
		{
			$cats =array();
			
			if( count($categories) )
			{
				foreach( $categories as $keys=>$value)		
				{
					$temp_explode = explode('=',$value);
					
					if( count($temp_explode) )
					{
						$cats[$temp_explode[0]] = $temp_explode[1];
					}
				}
			}
			
			if( is_array($categories) && $cats['category'] != '' ) 
				$key = checkPOSTall($userid);

			if( is_array($categories) && $cats['category1'] != '' ) 
				$key1 = checkPOST($cats['category1'],$userid);
			
			if( is_array($categories) && $cats['category2'] != '' ) 
				$key2 = checkPOST($cats['category2'],$userid);
			
			if( is_array($categories) && $cats['category3'] != '' ) 
				$key3 = checkPOST($cats['category3'],$userid);
			
			if( is_array($categories) && $cats['category4'] != '' ) 
				$key4 = checkPOST($cats['category4'],$userid);
			
			if( is_array($categories) && $cats['category5'] != '' ) 
				$key5 = checkPOST($cats['category5'],$userid);
			

			//$value = '"'.$key.'"';
			$value = $key.$key1.$key2.$key3.$key4.$key5;
			//echo $key.'<br>'.$key1.'<br>'.$key2.'<br>'.$key3.'<br>'.$key4.'<br>'.$key5.'<br>';
			//print $value;
			
		}
	}
	
	$google = new Google_Search($value);

	$googledata = $google->getData(new JSONStrategy);
	
	if(count($googledata) && !empty($value))
	{
	?>
		<table cellspacing="1" cellpadding="0" width="100%" class="table table-striped" id="<?php if($_POST) {?>postresults<?php } else { ?>googleresults<?php } ?>">
        <thead>
            <th width="194"><?php echo getContent('user.buzz.source',Yii::app()->session['language']); ?></th>
            <th><?php echo getContent('user.buzz.matchtype',Yii::app()->session['language']); ?></th>
            <th width="292"><?php echo getContent('user.buzz.content',Yii::app()->session['language']); ?></th>
            <th width="238"><?php echo getContent('user.buzz.date',Yii::app()->session['language']); ?></th>
            <th width="156"><?php echo getContent('user.buzz.sentiment',Yii::app()->session['language']); ?></th>
            <th width="173"></th>
        <td width="6"></thead>
        <tbody>
        <?php
        
        $i = 0;

        foreach($googledata as $gd) 
        {
            $termstring = $gd[1].$gd[2];
            
        ?>
        
        <tr id="content_<?php echo $i; ?>">
            <td><a href="<?php echo $gd[1]; ?>"><img src="<?php echo $gd[3]; ?>" alt="<?php echo $gd[0]; ?>" style="width: 80px; height: 80px;" /></a></td>
            <td width="181"><?php checkBuzzterms($termstring); ?></td>
            <td class="content"><a href="<?php echo $gd[1]; ?>" title="<?php echo $gd[0]; ?>"><strong><?php echo substr( $gd[1] , 7 ); ?></strong></a><br/><?php echo $gd[2]; ?></td>
            <td align="center"><?php echo $gd[4]; ?></td>
            <td align="center"><?php echo $gd[5]; ?> alt="<?php echo $gd[0]; ?>" /></td>
            <td align="center">Email<br /><a href="#myModalMail" data-toggle="modal" rel="content_<?php echo $i; ?>" class="mailit"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/buzz/mail.png" /></a>
            <input type="hidden" name="url" class="url" value="<?php echo $gd[1]; ?>" />
            <input type="hidden" name="body" class="body" value="<?php echo $gd[2]; ?>" />
            </td>
        </tr>
        <?php
            
            $i++;
            
        }
        ?>
    </tbody>
    </table>
	<?php
	}
	else
	{
	?>
	<table cellspacing="1" cellpadding="0" class="table tablesorter">
    <thead>
    	<th>
        	<center>
            	<h4><?php echo getContent('user.buzz.nobuzz',Yii::app()->session['language']); ?></h4>
            </center>
		</th>
    </thead>
    </table>
    <?php
	}
	?>