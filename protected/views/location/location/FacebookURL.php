<table style="border:none; width:100%;"> 
<tbody> 
<tr> 
	<td width="30%" valign="top">
	
        <table> 
        <tbody> 
        <tr>  
        
		<?php 
            
        $last_date = strtotime(now)-($nrows*24*60*60);
        $prev_last_date = strtotime(now)-(3*$nrows*24*60*60);
        
        if(!empty($oneurl[0]['fburl']))
        {
        	$fb_data = $model->Record('fburl_data','fburl_id',$fburl_data[0]['fburl_id'],$last_date);
            $fb_prev_data = $model->PrevRecord('fburl_data','fburl_id',$fburl_data[0]['fburl_id'],$last_date,$prev_last_date);
    
            // current data
			if(count($fb_data))
			{
				$fb_likes = $fb_data[count($fb_data)-1]['likes'];
				$fb_checkins = $fb_data[count($fb_data)-1]['checkins'];
				
				$likes_diff_fb = $fb_data[count($fb_data)-1]['likes']-$fb_data[0]['likes'];
				$checkin_diff_fb = $fb_data[count($fb_data)-1]['checkins']-$fb_data[0]['checkins'];
			}
				  
			// prev data
			if(count($fb_prev_data))
			{
				$fb_likes_prev = $fb_prev_data[count($fb_prev_data)-1]['likes'];
				$fb_checkins_prev = $fb_prev_data[count($fb_prev_data)-1]['checkins'];
				
				$likes_diff_fb_prev = $fb_prev_data[count($fb_prev_data)-1]['likes']-$fb_prev_data[0]['likes'];
				$checkin_diff_fb_prev = $fb_prev_data[count($fb_prev_data)-1]['checkins']-$fb_prev_data[0]['checkins'];
			}

			foreach($fb_data as $key=>$value)
			{
				if($nrows>30)	
					$like_dates [date('d M Y',$value['dated'])]= $value['likes'];
				else
					$like_dates [date('d M',$value['dated'])]= $value['likes'];
				
				if($nrows>30)	
					$fb_chkin [date('d M Y',$value['dated'])]= $value['checkins'];
				else
					$fb_chkin [date('d M',$value['dated'])]= $value['checkins'];
			}
			
			$avg_daily_new_likes = $likes_diff_fb / $nrows;
			$avg_daily_new_checkins = $checkin_diff_fb / $nrows;
		}
                              
	?>
            
      <td>
          <?php echo getContent('user.onelocation.totallikes',Yii::app()->session['language']); ?>
          <h4><?=$fb_likes;?></h4>
         
          <input type="hidden" name="fb_likes_val" id="fb_likes_val" value="<?=$fb_likes;?>" />
          
          <span id="total_like_img">
          <?php if($LastLikes) { ?>
              <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image_fblikes; ?>" /><?php echo number_format($growth_fblikes,2); ?>%
          <?php } ?>
          </span>
                
		</td>
	</tr>
    <tr> 
        <td style="border:none;">	
                
            <?php echo getContent('user.onelocation.dailynewlikes',Yii::app()->session['language']); ?><h4><?=number_format(ceil($avg_daily_new_likes))?></h4>
            <input type="hidden" name="fb_daily_new_likes" id="fb_daily_new_likes" value="<?=number_format(ceil($avg_daily_new_likes))?>" />
                 
            <span id="daily_new_like_img">
            <?php if($LastLikes) { ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $fb_image_daily_like ?>" /><?php echo number_format($fb_growth_daily_like,2); ?>%
            <?php } ?>
            </span>
            
        </td>
    </tr>
	</tbody>
	</table>
    
	</td>

<?php

if(count($like_dates))
{
	$dates='';
	$vallikes='';
	
	$months = array();
	$month_wise_report = array();
	
	foreach($like_dates as $keys=>$values)
	{
		$temp_exp = explode(' ',$keys);
		if(!in_array($temp_exp[1].' '.$temp_exp[2],$months))
		{
			array_push($months,$temp_exp[1].' '.$temp_exp[2]);
			$month_wise_report [$temp_exp[1].' '.$temp_exp[2]] = 0;
		}
		
		$month_wise_report [$temp_exp[1].' '.$temp_exp[2]] = $values;
		
		$dates .= "'".$keys."',";
		$vallikes .= $values.",";
	}
              
	if($nrows>30 && count($month_wise_report))
	{
		$dates = '';
		$vallikes = '';
		foreach($month_wise_report as $key_new=>$value_new)
		{
			$dates .= "'".$key_new."',";
			$vallikes .= $value_new.",";
		}
	}
?>
          
	<script type="text/javascript">
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'containerfb',
                //defaultSeriesType: 'areaspline'
				defaultSeriesType: 'line'
            },
            title: {
                text: 'Daily Likes report'
            },
			 colors: [
                	'#0ABCDA',
					'#B5E8FB'
				],
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 150,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF'
            },
            xAxis: {
                categories: [<?=substr($dates,0,strlen($dates)-1)?>],
                plotBands: [{ // visualize the weekend
                    from: 4.5,
                    to: 6.5,
                    color: 'rgba(68, 170, 213, .2)'
                }]
            },
            yAxis: {
                title: {
                    text: 'Total Likes'
                }
            },
            tooltip: {
                formatter: function() 
                {
                    return '<b>'+ this.series.name +'</b><br/>'+'By '+ this.x +',likes were '+ this.y; 
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.5
                }
            },
            series: [{
                name: 'Daily Likes',
                data: [<?=substr($vallikes,0,strlen($vallikes)-1)?>]
            }]
        });
        
        
    });
    
    </script>
    <input type="hidden" name="categories1" id="categories1" value="<?=substr($dates,0,strlen($dates)-1)?>" />
    <input type="hidden" name="data1" id="data1" value="<?=substr($vallikes,0,strlen($vallikes)-1)?>" />

<?php } ?>
	<td align="left" width="70%" style="border:none;">
    	<div id="containerfb" style="width:100%; height:300px; margin:0 auto"></div>										
    </td> 
</tr>
<tr>
    <td style="border:none;" valign="top">
        <table id="tablesorter-sample" class="styled" cellpadding="0" cellspacing="0" style="border:none;"> 
        <tbody> 
        <tr> 
            <td style="border:none;">
        
                <?php echo getContent('user.onelocation.totalcheckins',Yii::app()->session['language']); ?><h4><?=$fb_checkins;?></h4>
                <input type="hidden" name="fb_total_checkins" id="fb_total_checkins" value="<?=$fb_checkins?>" />
                
                <span id="fb_total_checkins_img">
                <?php if($LastLikes) { ?>
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $fb_image_chkin; ?>" /><?php echo number_format($fb_growth_chkin,2); ?>%
                <?php } ?>
                </span>
            </td>
        </tr>
        <tr> 
            <td style="border:none;">
        
                <?php echo getContent('user.onelocation.dailynewcheckins',Yii::app()->session['language']); ?><h4><?=number_format(ceil($avg_daily_new_checkins))?></h4>
                <input type="hidden" name="fb_dailynew_checkins" id="fb_dailynew_checkins" value="<?=number_format(ceil($avg_daily_new_checkins))?>" />
                
                <span id="fb_dailynew_checkins_img">
                <?php if($LastLikes) { ?>
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $fb_image_daily_chkin; ?>" /><?php echo number_format($fb_growth_daily_chkin,2); ?>%
                <?php } ?>
                </span>
                
            </td>
        </tr>
        </tbody>
        </table>									
    </td>
	<?php

    if(count($fb_chkin))
    {
        $dates2='';
        $fbchks2='';
        
        $months2 = array();
        $month_wise_report2 = array();
        
        foreach($fb_chkin as $keys=>$values)
        {
            $temp_exp = explode(' ',$keys);
            if(!in_array($temp_exp[1].' '.$temp_exp[2],$months2))
            {
                array_push($months2,$temp_exp[1].' '.$temp_exp[2]);
                $month_wise_report2 [$temp_exp[1].' '.$temp_exp[2]] = 0;
            }
            
            $month_wise_report2 [$temp_exp[1].' '.$temp_exp[2]] = $values;
            
            $dates2 .= "'".$keys."',";
            $fbchks2 .= $values.",";
        }
        
        if($nrows>30 && count($month_wise_report2))
        {
            $dates = '';
            $fbchks2 = '';
            foreach($month_wise_report2 as $key_new=>$value_new)
            {
                $dates .= "'".$key_new."',";
                $fbchks2 .= $value_new.",";
            }
        }
    ?>
          
	<script type="text/javascript">
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'facebook_checkin_detail',
                defaultSeriesType: 'line'
            },
            title: {
                text: 'Daily Checkin report'
            },
			 colors: [
                	'#0ABCDA',
					'#B5E8FB'
				],
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 150,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF'
            },
            xAxis: {
                categories: [<?=substr($dates2,0,strlen($dates2)-1)?>],
                plotBands: [{ 
                    from: 4.5,
                    to: 6.5,
                    color: 'rgba(68, 170, 213, .2)'
                }]
            },
            yAxis: {
                title: {
                    text: 'Total Checkin'
                }
            },
            tooltip: {
                formatter: function() { return '<b>'+ this.series.name +'</b><br/>'+ 'By '+ this.x +',checkins were '+ this.y; }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.5
                }
            },
            series: [{
                name: 'Daily Checkins',
                data: [<?=substr($fbchks2,0,strlen($fbchks2)-1)?>]
            }]
        });
    });
    </script>
    <input type="hidden" name="categories2" id="categories2" value="<?=substr($dates2,0,strlen($dates2)-1)?>" />
    <input type="hidden" name="data2" id="data2" value="<?=substr($fbchks2,0,strlen($fbchks2)-1)?>" />
    
    <?php
    }
    ?>
    
    <td align="left" style="border:none;">
        <div id="facebook_checkin_detail" style="width:100%; height:300px; margin:0 auto"></div>						
    </td>
</tr>
</tbody> 
</table>