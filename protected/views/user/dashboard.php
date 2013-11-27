<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="<? echo Yii::app()->request->baseUrl; ?>/js/hcharts/js/highcharts.js"></script>

<div class="container">
	
<?php $user_info = User::model()->GetRecord(); ?>
<br /><br />
<table class="table table-striped table-bordered">
<tr>
	<td>
		<?php echo str_replace('[USERNAME]',strtoupper($user_info[0]['fname']).' '.strtoupper($user_info[0]['lname']),getContent('user.dashboard.welcome',Yii::app()->session['language'])); ?>
	</td>
</tr>
</table> 

<div class="clear"></div>

<div class="clearfix"></div>

<div class="container container-top">
	<div class="row-fluid">
    
    	<div class="span6">
            <div class="accordion" id="accordion1">
                <div class="accordion-group">
                    
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" title="Click to open/close"><?php echo getContent('user.dashboard.buzz',Yii::app()->session['language']); ?></a>
                    </div>
                    
                    <div id="collapseOne" class="accordion-body collapse in">
                    
                        <div class="accordion-inner" id="topbuzz">
    						<center><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" /></center>
                        </div>
					</div>
				</div>
			</div>
		</div>
        
        
		<?php $this->widget('application.components.dashboard.TopVenues'); ?>
	</div>
</div>

<div class="clear"></div>

<div class="clearfix"></div>

<div class="container container-top">

	<div class="row-fluid">
	
		<div class="span6">
			<div class="accordion" id="accordion3">
				<div class="accordion-group">
					
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree" title="Click to open/close"><?php echo getContent('user.dashboard.latestfbpost',Yii::app()->session['language']); ?></a>
					</div>
					
					<div id="collapseThree" class="accordion-body collapse in">
					
						<div class="accordion-inner">
			
							<?php $this->widget('application.components.dashboard.LatestFBPosts'); ?>
							
						</div>
					</div>
					
				</div>
			</div>
		</div>    
			
		<div class="span6">
			<div class="accordion" id="accordion4">
				<div class="accordion-group">
					
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseFour" title="Click to open/close"><?php echo getContent('user.dashboard.latestcampaign',Yii::app()->session['language']); ?></a>
					</div>
					
					<div id="collapseFour" class="accordion-body collapse in">
					
						<div class="accordion-inner">
			
							<?php $this->widget('application.components.dashboard.ActiveCampaign'); ?>
							
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
	</div>

</div>


<script>

$.post("<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/topbuzz", { } , function(data){ $('#topbuzz').html(data);	});

</script>