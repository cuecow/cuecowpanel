<?php

	require_once('buzz/api.php');
	
	Yii::app()->session['language'] = 2;
	
	$userid = Yii::app()->user->user_id;

	$language = 'lang_en';
	
	$value = '';
	
	if((is_array($categories) && in_array('category=10',$categories))) 
		$key = checkPOSTall($userid);

	if((is_array($categories) && in_array('category1=1',$categories))) 
		$key1 = checkPOST(1,$userid);
			
	if((is_array($categories) && in_array('category2=2',$categories))) 
		$key2 = checkPOST(2,$userid);
			
	if((is_array($categories) && in_array('category3=3',$categories))) 
		$key3 = checkPOST(3,$userid);
			
	if((is_array($categories) && in_array('category4=4',$categories))) 
		$key4 = checkPOST(4,$userid);
			
	if((is_array($categories) && in_array('category5=5',$categories))) 
		$key5 = checkPOST(5,$userid);
			

	$value = $key.$key1.$key2.$key3.$key4.$key5;
	//echo $key.'<br>'.$key1.'<br>'.$key2.'<br>'.$key3.'<br>'.$key4.'<br>'.$key5.'<br>';
	//print $value;
	
	$google = new Google_Search($value);

	$googledata = $google->getData(new JSONStrategy);
	
	if(count($googledata) && !empty($value))
	{
	?>
		<table width="100%" class="table table-striped">
        <thead>
        <tr>
            <th width="30%"><?php echo getContent('user.buzz.source',Yii::app()->session['language']); ?></th>
            <th><?php echo getContent('user.buzz.content',Yii::app()->session['language']); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        
        $i = 0;

        foreach($googledata as $gd) 
        {
            $termstring = $gd[1].$gd[2];
            
        ?>
        
        <tr id="content_<?php echo $i; ?>">
            <td><a href="<?php echo $gd[1]; ?>"><img src="<?php echo $gd[3]; ?>" alt="<?php echo $gd[0]; ?>" style="width: 80px; height: 80px;" /></a></td>
            <td class="content"><a href="<?php echo $gd[1]; ?>" title="<?php echo $gd[0]; ?>"><strong><?php echo substr( $gd[1] , 7 ); ?></strong></a><br/><?php echo $gd[2]; ?></td>
        </tr>
        <?php
            
            $i++;
			
			if($i == 5)
				break;
            
        }
        ?>
    </tbody>
    </table>
	<?php
	}
	else
	{
	?>
    	<div class="alert alert-info">
            <center>
                <?php echo getContent('user.buzz.nobuzz',Yii::app()->session['language']); ?>
            </center>
        </div>
    <?php
	}
	?>
	