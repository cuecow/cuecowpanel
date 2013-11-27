<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="<? echo Yii::app()->request->baseUrl; ?>/js/hcharts/js/highcharts.js"></script>
<?php 

$oneurl = $model->getonelocurl();

$nrows=7;

if($_REQUEST['val']=='7d') 
	$nrows=7;
else if($_REQUEST['val']=='14d') 
	$nrows=14;
else if($_REQUEST['val']=='1m') 
	$nrows=30;
else if($_REQUEST['val']=='3m') 
	$nrows=90;
else if($_REQUEST['val']=='6m') 
	$nrows=180;
else if($_REQUEST['val']=='1y') 
	$nrows=365;
else if($_REQUEST['val']=='3y') 
	$nrows=1095;
else if($_REQUEST['val']=='6y') 
	$nrows=2190;

require_once('location/LocationScripts.php');

if(!empty($oneurl[0]['fburl']))
	$fburl_data = $model->GetURLid('fburlinfo',$_REQUEST['id']);
if(!empty($oneurl[0]['fsurl']))
	$fsurl_data = $model->GetURLid('fsurlinfo',$_REQUEST['id']);
if(!empty($oneurl[0]['googleurl']))
	$gurl_data = $model->GetURLid('gurlinfo',$_REQUEST['id']);

?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/hcharts/js/themes/grid.js" type="text/javascript" language="javascript"></script>

<div class="container container-top">
	<div class="row-fluid">

		<?php require_once('location/LocationBox.php'); ?>
		
        
        <div class="accordion" id="accordion1">
            <div class="accordion-group">
                
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" title="Click to open/close"><?php echo getContent('user.onelocation.locationsnapshot',Yii::app()->session['language']); ?></a>
                </div>
                
                <div id="collapseOne" class="accordion-body collapse in">
                    <div class="accordion-inner">					
                        <?php require_once('location/LocationSnapshot.php'); ?>
                    </div>
                </div>
            
            </div>
        </div>
							
		<?php 
								
		require_once('location/DemographicSummary.php');
		
		?>
        
        <div class="accordion" id="accordion2">
            <div class="accordion-group" id="fbsummary">
                
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo" title="Click to open/close"><?php echo getContent('user.onelocation.fbsummary',Yii::app()->session['language']); ?></a>
                </div>
                
                <div id="collapseTwo" class="accordion-body collapse in">
                    <div class="accordion-inner">	
						<?		
                        if($oneurl[0]['fburl']!='') 
                            require_once('location/FacebookURL.php');
						?>
					</div>
                </div>
            
            </div>
        </div>
        
        <?php
        
		if(count($request))
		{
		?>
        <div class="accordion" id="accordion55">
            <div class="accordion-group" id="fbsummary">
                
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion55" href="#collapseFiftyFive" title="Click to open/close">Benchmark against facebook URL</a>
                </div>
                
                <div id="collapseFiftyFive" class="accordion-body collapse in">
                    <div class="accordion-inner">	
						<?php require_once('location/CompareUrl.php'); ?>
					</div>
                </div>
            
            </div>
        </div>
        <?php	
		}
		
		?>
        
		<?php
		$gurl='';

        if($oneurl[0]['googleurl']!='') { ?>
        
        <div class="accordion" id="accordion3">
            <div class="accordion-group">
                
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree" title="Click to open/close"><?php echo getContent('user.onelocation.googlesummary',Yii::app()->session['language']); ?></a>
                </div>
                
                <div id="collapseThree" class="accordion-body collapse in">
                    <div class="accordion-inner">
						<?php
                          
                            $gurl = $oneurl[0]['googleurl'];
                                                    
                            require_once('location/GoogleURL.php');
                        ?>
					</div>
				</div>
			
            </div>
		</div>
        
		<?php }  ?>
        
        <div class="accordion" id="accordion4">
            <div class="accordion-group">
                
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseFour" title="Click to open/close"><?php echo getContent('user.onelocation.fssummary',Yii::app()->session['language']); ?></a>
                </div>
                
                <div id="collapseFour" class="accordion-body collapse in">
                    <div class="accordion-inner">
						<?php
                        
                        if($oneurl[0]['fsurl']!='')
                            require_once('location/FourSquareURL.php');
                                                        
                        ?>
					</div>
				</div>
			
            </div>
		</div>
		
	</div>
</div>