<?php 

$user_curr = Yii::app()->user->user_id;
//var_dump(Yii::app()->user->user_id); die();
$top_location = Location::model()->GetTopLocation(); 
//$reach = $model_fb->GetPagesToken();

//var_dump(count($top_location)); die();
if(count($top_location))
{
	$location_sorted = array();
							
	foreach($top_location as $key=>$value)
	{	 
		
		if(!empty($value['fburl']))
			$fbdata	= $model->GetFbLikes($value['loc_id']);
		
		if(!empty($value['fsurl']))
			$fsdata = $model->GetFSData($value['loc_id']);
		else
			$fsdata = 0;
								
		if(!empty($value['googleurl']))
			$gdata  = $model->GetGoogData($value['loc_id']);
		else
			$gdata = 0;
							
		$tot_checkin = $fbdata[0]['checkins'] + $fsdata[0]['checkinsCount'];
		$fblikes = ($fbdata[0]['likes']) ? $fbdata[0]['likes'] : 'N/A' ;
		$glikes = ($gdata[0]['glikes']) ? $gdata[0]['glikes'] : 'N/A' ;
		$location_sorted[$value['loc_id']]['tot_checkin'] 	= ($tot_checkin) ? $tot_checkin:0 ;
		$location_sorted[$value['loc_id']]['fblikes'] 		= ($fblikes) ? $fblikes:0 ;
		$location_sorted[$value['loc_id']]['glikes'] 		= ($glikes) ? $glikes:0 ;										
		$location_sorted[$value['loc_id']]['loc_id'] 		= $value['loc_id'];
		$location_sorted[$value['loc_id']]['name']			= $value['name'];	
	}
		
	array_multisort($location_sorted, SORT_DESC, $location_sorted);
}

$fblikes_total = 0;
$checkin_total = 0;
//var_dump(count($location_sorted)); die();
//var_dump($location_sorted); die();

if($location_sorted != null){
foreach($location_sorted as $key=>$value)
{
    //var_dump($value['fblikes']);
    $fblikes_total = $fblikes_total + $value['fblikes'];
    $checkin_total = $checkin_total + $value['tot_checkin'];
}
}

//$fblikes_total = ($location_sorted[0]['fblikes']+$location_sorted[1]['fblikes']+$location_sorted[2]['fblikes']+$location_sorted[3]['fblikes']+$location_sorted[4]['fblikes']);
//$checkin_total = ($location_sorted[0]['tot_checkin']+$location_sorted[1]['tot_checkin']+$location_sorted[2]['tot_checkin']+$location_sorted[3]['tot_checkin']+$location_sorted[4]['tot_checkin']);


$fblikes_total = number_format($fblikes_total);
$checkin_total = number_format($checkin_total);

?>   

<script>
    $(document).ready(function(){    
        get_reach();
    });
    
    function get_reach() {
        //var posts = '<?= $page ?>';
        var curr_user = '<?= $user_curr ?>';
        //alert(posts);
        //alert(curr_user);
        $.ajax({
            type : 'POST',
            url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/getReach.php',
            dataType : 'json',

            data: 'user='+ curr_user,
            //data: 'user='+ curr_user,
            success : function(response){
                //alert('result');
                //console.log(response);

                var resultdata = response['result'];
                console.log(resultdata);
                var pagem = resultdata;
                $('#wait_social').hide();
                $('#social_reach').append(pagem);
                
                //save_posts = resultdata;
                //console.log(save_posts);
                //var ids = response['pages_id'];
                //console.log(resultdata[0].acc);

                //render_posts(resultdata);			
            },
            error : function(response) {
                //alert('error');
                console.log(response);             
            }
        });
    }
    
</script>

<!--<div class="span6">
    <div class="accordion" id="accordion1">
        <div class="accordion-group">
            
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" title="Click to open/close"><?php echo getContent('user.dashboard.topvenue',Yii::app()->session['language']); ?></a>
            </div>
            
            <div id="collapseOne" class="accordion-body collapse in">
            
                <div class="accordion-inner">
                	<?php if(count($top_location)) { ?>
                    <table class="table table-striped"> 
                    <thead> 
                    <tr> 
                        <th class="checkbox-row">
                            <strong>
                                <?php 
								echo getContent('user.dashboard.topvenue.column1',Yii::app()->session['language']); 
								?>
                            </strong>
                        </th> 
                        <th>
                            <strong>
                                <?php 
								echo getContent('user.dashboard.topvenue.column2',Yii::app()->session['language']); 
								?>
                            </strong>
                        </th> 
                        <th>
                            <strong>
                                <?php 
								echo getContent('user.dashboard.topvenue.column3',Yii::app()->session['language']); 
								?>
                            </strong>
                        </th> 
                        <th>
                            <strong>
                                <?php 
								echo getContent('user.dashboard.topvenue.column4',Yii::app()->session['language']); 
								?>
                            </strong>
                        </th> 
                        <th>
                            <strong>
                                <?php 
								echo getContent('user.dashboard.topvenue.column5',Yii::app()->session['language']); 
								?>
                            </strong>
                        </th> 
                    </tr> 
                    </thead>                        
                    <tbody> 
					<?php 
                                                        
                    $g=1;
                                
                    foreach($location_sorted as $key=>$value)
                    { 
                        if($g==1)
                            $firstone = $value;
                    
                    ?>
                    
                    <tr>
                        <td><?php echo $g; ?></td>
                        <td><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/onelocation/id/<?=$value['loc_id'];?>/val/1m"><?php echo $value['name']; ?></a></td>
                        <td align="center"><?php echo $value['tot_checkin'];?></td>
                        <td align="center"><?php echo $value['fblikes'];?></td>
                        <td align="center"><?php echo $value['glikes']; ?></td>
                    </tr>
                    
                    <?php 
                                                        
                        $g++;
                    } 
                    ?>
                    <tr><td colspan="5" height="31">&nbsp;</td></tr>
                    </tbody> 
                    </table>
                    <?php } else { ?>
                    <div class="alert alert-info">
                        <center>
							<?php echo getContent('user.dashboard.nolocation',Yii::app()->session['language']); ?>
                        </center>
                    </div>
					<?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>-->

<div class="span6">
    <div class="accordion-group">
    
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" title="Click to open/close"><?php echo getContent('user.dashboard.topvenuegraph',Yii::app()->session['language']); ?></a>
        </div>
        
        <div id="collapseTwo" class="accordion-body collapse in">
            <div class="accordion-inner">
                <ul class="arrow-content-list">
                    <li>
                        <div class="box-cnt-main">
                            <label class="label-text">Total likes</label>
                            <i class="ico-thumbs-up list-arrow"></i>
                            <p class="arrow-count"><?php echo $fblikes_total ?></p>
                        </div>
                </li>
                <li>
                    <div class="box-cnt-main">
                        <label class="label-text">Total checkins</label>
                        <i class="ico-check list-arrow"></i>
                        <p class="arrow-count"><?php echo $checkin_total ?></p>
                    </div>
                </li>
                <li>
                    <div class="box-cnt-main">
                    <label class="label-text">Audience</label>
                    <i class="ico-parents list-arrow"></i>
                    <center id="wait_social" class="buttonwait-social"> <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajaxd-loader.gif" /></center>
                    <p class="arrow-count" id="social_reach"></p>
                    </div>
                </li>
                </ul>
                <div class="clearfix"></div>
               <?php if(count($top_location)) { ?>
			   <script>
                
				var chart;
                $(document).ready(function() {
               	chart = new Highcharts.Chart({
                chart: {
                	renderTo: 'location_graph',
                    defaultSeriesType: 'column'
				},
                colors: [
                	'#0ABCDA',
					'#B5E8FB'
				],
                title: {
                	text: 'Top 5 Locations'
                },
                subtitle: {
                	text: ''
                },
                xAxis: {
                	categories: [
                    	'<?php echo $location_sorted[0]['name'] ?>', 
                        '<?php echo $location_sorted[1]['name'] ?>', 
                        '<?php echo $location_sorted[2]['name'] ?>', 
                        '<?php echo $location_sorted[3]['name'] ?>', 
                        '<?php echo $location_sorted[4]['name'] ?>'
					]
				},
                yAxis: {
				   	min: 0,
				   	title: {
						text: ''
				   	}
				},
//				legend: {
//				   	layout: 'vertical',
//				   	align: 'left',
//				   	verticalAlign: 'top',
//				   	//x: 110,
//				   	//y: -10
//				   	//floating: true,
//				   	//shadow: true
//				},
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'top',
                                    x: -8,
                                    y: -10,
                                    floating: true,
                                    borderWidth: 0
                                },
				tooltip: {
				   	formatter: function() {
					return ''+
						 this.x +': '+ this.y +'';
				   	}
				},
				plotOptions: {
				   	column: {
						pointPadding: 0.2,
					  	borderWidth: 0
				   	}
				},
				series: [{
                	name: 'Checkin',
                    data: [<?php echo $location_sorted[0]['tot_checkin'] ?>, <?php echo $location_sorted[1]['tot_checkin'] ?>, <?php echo $location_sorted[2]['tot_checkin'] ?>,<?php echo $location_sorted[3]['tot_checkin'] ?>, <?php echo $location_sorted[4]['tot_checkin'] ?>]
                }, {
                	name: 'FBlikes',
                    data: [<?php echo $location_sorted[0]['fblikes'] ?>, <?php echo $location_sorted[1]['fblikes'] ?>, <?php echo $location_sorted[2]['fblikes'] ?>,<?php echo $location_sorted[3]['fblikes'] ?>, <?php echo $location_sorted[4]['fblikes'] ?>]
						}]
					});					   
				});
                </script>
                
<!--                <script>
                    var chart;
				$(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                	renderTo: 'location_graph'
                    //defaultSeriesType: 'column'
				},
            title: {
                text: 'Top 5 Locations',
                x: -20 //center
            },
            xAxis: {
                categories: [
                    	'<?php echo $location_sorted[0]['name'] ?>', 
                        '<?php echo $location_sorted[1]['name'] ?>', 
                        '<?php echo $location_sorted[2]['name'] ?>', 
                        '<?php echo $location_sorted[3]['name'] ?>', 
                        '<?php echo $location_sorted[4]['name'] ?>'
					]
            },
            yAxis: {
				   	min: -1,
				   	title: {
						text: ''
				   	}
				},
            tooltip: {
				   	formatter: function() {
					return ''+
						 this.x +': '+ this.y +'';
				   	}
				},
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                	name: 'Checkin',
                    data: [<?php echo $location_sorted[0]['tot_checkin'] ?>, <?php echo $location_sorted[1]['tot_checkin'] ?>, <?php echo $location_sorted[2]['tot_checkin'] ?>,<?php echo $location_sorted[3]['tot_checkin'] ?>, <?php echo $location_sorted[4]['tot_checkin'] ?>]
                }, {
                	name: 'FBlikes',
                    data: [<?php echo $location_sorted[0]['fblikes'] ?>, <?php echo $location_sorted[1]['fblikes'] ?>, <?php echo $location_sorted[2]['fblikes'] ?>,<?php echo $location_sorted[3]['fblikes'] ?>, <?php echo $location_sorted[4]['fblikes'] ?>]
                    
						}]
//            series: [{
//                	name: 'Checkin',
//                    data: [5, 10, 15,20,25]
//                }, {
//                	name: 'FBlikes',
//                    data: [15, 20, 40,50]
//                    }]
        });
    });
    
                </script>-->
                
                <div class="field-content-44">
                	<div id="location_graph"></div>
                </div>
                
				<?php } else { ?>
				
                <div class="alert alert-info">
                    <center>
                        <?php echo getContent('user.dashboard.nolocation',Yii::app()->session['language']); ?>
                    </center>
                </div>
			
			<?php } ?>
            </div>
        </div>
    </div>
</div>
