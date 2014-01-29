<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<!--<script src="http://code.highcharts.com/highcharts.js"></script>-->

<script type="text/javascript" src="<? echo Yii::app()->request->baseUrl; ?>/js/hcharts/js/highcharts.js"></script>

<div class="container">
	
<?php $user_info = User::model()->GetRecord(); ?>
    <?php $user_fb_pages = Fbpages::model()->GetPages(); ?>
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
                                                <div class="refreshpost-hover"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/settings-24-512.png" width="20" height="20" />
                                                    <div class="refresh-post-overlay">
                                                <div class="refresh-post-content">
                                                    <div class="refresh-post-row refresh-post-title">
                                                        <input type="checkbox" id="refresh" class="refresh-post-checkbox" />
                                                        <p class="fanpage-link-cnt"><b>Auto refresh all</b></p>
                                                        
                                                        
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div id="c_b">
                                                        <div class="refresh-post-overflow">
                                                    <?php
                                                    foreach($user_fb_pages as $key=>$value)
                                                    { ?>
                                                       
                                                    <div class="refresh-post-row">
                                                        <input type="checkbox" id="<?= $value['page_id'] ?>" name="<?= $value['page_name'] ?>" class="chkbx refresh-post-checkbox" value="<?= $value['page_id'] ?>" />
                                                        <p class="fanpage-link-cnt"><?php echo $value['page_name']; ?></p>
                                                        <?php $page_name = str_replace('"', "", $value['page_name']); ?>
                                                        <a href="#" class="refresh-page-link" id="refresh1" onclick="update(<?= $value['page_id'] ?>, '<?= $page_name ?>'); return false;">Refresh Now</a>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    
                                                    <?php } ?>
                                                    </div>
                                                     </div>
                                                    
                                                </div>
                                                </div>
                                            </div>
                                                <div class="clear"></div>
                                        </div>
					
					<div id="collapseThree" class="accordion-body collapse in">
					
						<div class="accordion-inner">
                                                    <div style="height:650px; overflow: auto">
			
							<?php $this->widget('application.components.dashboard.LatestFBPosts'); ?>
                                                    </div>
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
$('#refresh').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    }
    else
    {
        $(':checkbox').each(function() {
            this.checked = false;                        
        });
    }
});
</script>


<script>

$.post("<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/topbuzz", { } , function(data){ $('#topbuzz').html(data);	});

</script>