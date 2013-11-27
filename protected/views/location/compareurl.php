<div class="accordion-heading">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" title="Click to open/close">Benchmark against facebook URL</a>
</div>
                
<div id="collapseTwo" class="accordion-body collapse in">
	<div class="accordion-inner">
    	<table style="border:none; width:100%;"> 
        <tbody> 
        <tr> 
            <td width="30%" valign="top">
                <table cellpadding="0" cellspacing="0"> 
                <tbody> 
                <tr>
                    <td valign="top">
                        Total Likes<h3><?=$request['fb_likes'];?></h3>
                          
                        <span id="total_like_img">
                            <?php echo $request['total_like_img']; ?>
                        </span>                  
                    </td>
                </tr>
                <tr> 
                    <td valign="top">	   
                        Daily New Likes<h3><?=$request['fb_daily_new_likes']?></h3>
                        
                        <span id="daily_new_like_img">      
                            <?php echo $request['daily_new_like_img']; ?>
                        </span>
                        
                    </td>
                </tr>
                </tbody>
                </table>									
            </td>
              
            <script type="text/javascript">
			
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'containerfb',
						type: 'column'
					},
					 colors: [
						'#0ABCDA',
						'#B5E8FB'
					],
					title: {
						text: 'Total Likes Comparison'
					},
					xAxis: {
						categories: [
							'Likes'
						]
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Number of Likes'
						}
					},
					legend: {
						layout: 'vertical',
						backgroundColor: '#FFFFFF',
						align: 'left',
						verticalAlign: 'top',
						x: 100,
						y: 70,
						floating: true,
						shadow: true
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y;
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
						series: [{
						name: '<?php echo $request['mypage']; ?>',
						data: [<?php echo $request['fb_likes']; ?>]
			
					}, {
						name: '<?php echo $request['comp_page']; ?>',
						data: [<?php echo $request['newlikes']; ?>]
			
					}]
				});
			});
              
            </script>
            
            <td align="left" width="70%" valign="top">
            	<div id="containerfb" style="width:100%; height:300px; margin:0 auto"></div>										
            </td> 
		</tr>
        <tr>
        	<td>
            	<table cellpadding="0" cellspacing="0"> 
                <tbody> 
                <tr> 
                	<td valign="top">
                      
                          Total Checkins<h3><?=$request['fb_total_checkins'];?></h3>
                          
                          <span id="fb_total_checkins_img">
                            <?php echo $request['fb_total_checkins_img']; ?>
                          </span>
                    </td>
				</tr>
                <tr> 
                	<td valign="top">
                  
                          Daily New Checkins<h3><?=$request['fb_dailynew_checkins']?></h3>
                                  
                          <span id="fb_dailynew_checkins_img">
                            <?php echo $request['fb_dailynew_checkins_img']; ?>
                          </span>
                    </td>
				</tr>
                </tbody>
                </table>									
			</td>
              
            <script type="text/javascript">
			
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'facebook_checkin_detail',
						type: 'column'
					},
					 colors: [
						'#0ABCDA',
						'#B5E8FB'
					],
					title: {
						text: 'Total Checkin Comparison'
					},
					xAxis: {
						categories: [
							'Likes'
						]
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Number of Checkin'
						}
					},
					legend: {
						layout: 'vertical',
						backgroundColor: '#FFFFFF',
						align: 'left',
						verticalAlign: 'top',
						x: 100,
						y: 70,
						floating: true,
						shadow: true
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y;
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
						series: [{
						name: '<?php echo $request['mypage']; ?>',
						data: [<?php echo $request['fb_total_checkins']; ?>]
			
					}, {
						name: '<?php echo $request['comp_page']; ?>',
						data: [<?php echo $request['checkins']; ?>]
			
					}]
				});
			});
			
            </script>
              
            <td align="left" valign="top">
            	<div id="facebook_checkin_detail" style="width:100%; height:300px; margin:0 auto"></div>						
            </td>
		</tr>
        </tbody> 
        </table>
  	</div>
</div>
