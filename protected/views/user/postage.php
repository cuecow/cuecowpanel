<?php
	require_once('connect.php');
	require_once('api.php');
	$userid = 1;

	$value = '';
	if($_POST['category'] || $_POST['category1'] || $_POST['category2'] || $_POST['category3'] || $_POST['category4'] || $_POST['category5']) {
		
		if($_POST['category']) {
		$key = checkPOSTall();
		//print $key;
		}

		if($_POST['category1']) 
		$key1 = checkPOST($_POST['category1']);
		
		if($_POST['category2']) 
		$key2 = checkPOST($_POST['category2']);
		
		if($_POST['category3']) 
		$key3 = checkPOST($_POST['category3']);
		
		if($_POST['category4']) 
		$key4 = checkPOST($_POST['category4']);
		
		if($_POST['category5']) 
		$key5 = checkPOST($_POST['category5']);
		
		//print $key.$key1.$key2.$key3.$key4.$key5;
		
		if($_POST['source']) {
		$value = '"'.$key.$key1.$key2.$key3.$key4.$key5.' site: '.$_POST['source'];
		//print $value;
		
		} else {
		$value = '"'.$key.$key1.$key2.$key3.$key4.$key5;
		//print $value;
		}
	}
	else {
		if($_POST['source']) {
		
		$key = checkPOSTall();
		$value = '"'.$key.'" site:'.$_POST['source'];
		
		//print $value;
		
		} else {
		$key = checkPOSTall();
		$value = '"'.$key.'"';
		//print $value;
		}
	}
	$google = new Google_Search($value);

	$googledata = $google->getData(new JSONStrategy);
	$i = 0;
	
	if(count($googledata))
	{
		foreach($googledata as $gd) 
		{
			$termstring = $gd[1].$gd[2];
?>
		<tr id="content_<?php echo $i; ?>">
			<td><a href="<?php echo $gd[1]; ?>"><img src="<?php echo $gd[3]; ?>" alt="<?php echo $gd[0]; ?>" style="width: 80px; height: 80px;" /></a></td>
            <td width="80"><?php checkBuzzterms($termstring); ?></td>
            <td class="content"><a href="<?php echo $gd[1]; ?>" title="<?php echo $gd[0]; ?>"><strong><?php echo substr( $gd[1] , 7 ); ?></strong></a><br/><?php echo $gd[2]; ?></td>
            <td align="center"><?php echo $gd[4]; ?></td>
            <td align="center"><?php echo $gd[5]; ?> alt="<?php echo $gd[0]; ?>" /></td>
            <td align="center">Email<br /><a href="#maildiv_<?php echo $i; ?>" class="mailit"><img src="images/mail.png" /></a></td>
			<div style="display: none;">
            	<div id="maildiv_<?php echo $i; ?>">
                	<h2>Email Link</h2>
                	<form name="emailform" action="email.php" method="post">
                        <div class="datainsert">
                        <a href="<?php echo $gd[1]; ?>" title="<?php echo $gd[0]; ?>"><strong><?php echo substr( $gd[1] , 7 ); ?></strong></a><br/><?php echo $gd[2]; ?>
                        </div>
                        <strong>To what email?</strong><br />
                        <i>(seperate multiple emails with comma)</i>
                        <div class="clear"></div>
                        <input type="text" class="input" name="email" value="Enter email(s)" />
                        <div class="clear"></div>
                        <input type="hidden" name="url" value="<?php echo $gd[1]; ?>" />
                        <input type="hidden" name="body" value="<?php echo $gd[2]; ?>" />
                        <input type="submit" value="submit" class="button small green" style="margin-top: 10px;"/>
                 	</form>
              	</div>
		  	</div>
		</tr>
<?php
			$i++;
		}
	}
?>