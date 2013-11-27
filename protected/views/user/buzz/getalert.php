<?php
require_once('gaapi/GoogleAlertService.php');
  
$user = 'cuecow@gmail.com';
$pass = 'cuec0w123';
		
$service = new GoogleAlertService($user, $pass);
		
$alerts = $service->getAlerts();
        
$i = 1;

Yii::app()->session['language'] = 2;

?>

<div id="alerts">
	<a class="btn btn-info" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/alert"><?php echo getContent('user.buzz.customalerts',Yii::app()->session['language']); ?></a>
  	
    <h2><?php echo getContent('user.buzz.currentcustomalerts',Yii::app()->session['language']); ?></h2>
  	<p><?php echo getContent('user.buzz.timeperiod',Yii::app()->session['language']); ?></p>
  	<table border="0" cellspacing="0" style="text-align: center;">
    <thead>
    	<th style="font-weight: bold;">#</th>
        <th style="font-weight: bold;"><?php echo getContent('user.buzz.query',Yii::app()->session['language']); ?></th>
        <th style="font-weight: bold;"><?php echo getContent('user.buzz.feed',Yii::app()->session['language']); ?></th>
  	</thead>
    <?php foreach ($alerts as $alert) { ?>
	<tr>
    	<td style="padding: 10px 0;"><?php echo $i++; ?></td>
		<td style="width: 50%; padding: 10px 0;"><?php echo $alert->getQuery(); ?></td>
		<td style="padding: 10px 0;">
        	<?php echo '<a href=' . $alert->getGoogleReaderURL() . ' target=_new>Google Reader</a><br />';
				  echo '<a href=' . $alert->getFeedURL() . ' target=_new>Your RSS Feed</a>';
			?>
		</td>
        <td style="padding: 10px 0;">
        	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/deletealert/id/<?php echo $alert->getID(); ?>"><?php echo getContent('user.buzz.delete',Yii::app()->session['language']); ?></a>
		</td>
	</tr>
    <?php } ?>
	</table>
	<div style="clear: both;"></div>
    
</div>