<table style="border:none; width:100%;"> 
<tbody> 
<tr> 
	<td width="30%" valign="top">
    
	<?php
                    
    // code which will pull the record of last selected days
                
	$last_date = strtotime(now) - ($nrows*24*60*60);
	$prev_last_date = strtotime(now) - (3*$nrows*24*60*60);
	
	$like_dates = array();
	$fb_chkin = array();
	$fs_chkin = array();
	
	
	
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
	}
                
	if(!empty($oneurl[0]['fsurl']))
	{
		$fs_data = $model->Record('fsurl_data','fsurl_id',$fsurl_data[0]['fsurl_id'],$last_date);
		$fs_prev_data = $model->PrevRecord('fsurl_data','fsurl_id',$fsurl_data[0]['fsurl_id'],$last_date,$prev_last_date);
		
		if(count($fs_data))
		{
			$checkinsCount = $fs_data[count($fs_data)-1]['checkinsCount'];
			$checkin_diff_fs = $fs_data[count($fs_data)-1]['checkinsCount']-$fs_data[0]['checkinsCount'];
		}
		
		// prev data
		if(count($fs_prev_data))
		{
			$fs_checkin_prev = $fs_prev_data[count($fs_prev_data)-1]['checkinsCount'];
			$likes_diff_fs_prev = $fs_prev_data[count($fs_prev_data)-1]['checkinsCount']-$fs_prev_data[0]['checkinsCount'];
			
			if($likes_diff_fs_prev == 0)
				$likes_diff_fs_prev = 1;
		}
                    
		foreach($fs_data as $key=>$value)
		{		
			if($nrows>30)	
				$fs_chkin [date('d M Y',$value['dated'])]= $value['checkinsCount'];
			else
				$fs_chkin [date('d M',$value['dated'])]= $value['checkinsCount'];
		}
	}
	
	if(!empty($oneurl[0]['googleurl']))
	{
		$g_data  = $model->Record('gurl_data','gurl_id',$gurl_data[0]['gurl_id'],$last_date);
		$g_prev_data = $model->PrevRecord('gurl_data','gurl_id',$gurl_data[0]['gurl_id'],$last_date,$prev_last_date);

		if(count($g_data))
		{
			$glikes = $g_data[count($g_data)-1]['glikes'];
			$likes_diff_g = $g_data[count($g_data)-1]['glikes']-$g_data[0]['glikes'];
		}
                    
		// prev data
		if(count($g_prev_data))
		{
			$g_likes_prev = $g_prev_data[count($g_prev_data)-1]['glikes'];
			$likes_diff_g_prev = $g_prev_data[count($g_prev_data)-1]['glikes']-$g_prev_data[0]['glikes'];
			
			if($likes_diff_g_prev == 0)
				$likes_diff_g_prev = 1;
		}
		
		$likes_gdates = '';
		
		foreach($g_data as $key=>$value)
		{
			$likes_gdates [date('d M',$value['dated'])]= $value['glikes'];
		}
	}	
                
	$avg_daily_new_likes = ($likes_diff_fb + $likes_diff_g) / $nrows;
	$avg_daily_new_checkins = ($checkin_diff_fb + $checkin_diff_fs) / $nrows;
	
	$avg_daily_new_checkins = ($avg_daily_new_checkins<0) ? 0:$avg_daily_new_checkins;
	$avg_daily_new_likes = ($avg_daily_new_likes<0) ? 0:$avg_daily_new_likes;
	
	$avg_daily_prev_new_likes = ($likes_diff_fb_prev + $likes_diff_g_prev) / $nrows;
	$avg_daily_prev_new_checkins = ($checkin_diff_fb_prev + $likes_diff_fs_prev) / $nrows;
                
	if(($g_likes_prev+$fb_likes_prev)>0)
	{
		$cur_stat = $fb_likes + $glikes;
		$prev_stat = $g_likes_prev + $fb_likes_prev;
		
		
		if($cur_stat>$prev_stat)
		{
			if($prev_stat>0)
			{
				$growth = (($cur_stat - $prev_stat)/$prev_stat)*100;
				$image = 'up.png';
			}
		}
		else if($prev_stat>$cur_stat)
		{
			if($cur_stat>0)
			{
				$growth = (($prev_stat - $cur_stat)/$cur_stat)*100;
				$image = 'down.png';
			}
		}
	}
                
	if(($checkinsCount+$fb_checkins)>0)
	{
		$cur_stat_checkin = $checkinsCount + $fb_checkins;
		$prev_stat_checkin = $fs_checkin_prev + $fb_checkins_prev;
		
		if($cur_stat_checkin>$prev_stat_checkin)
		{	
			if($prev_stat_checkin>0)
			{
				$growth_chkin = (($cur_stat_checkin - $prev_stat_checkin)/$prev_stat_checkin)*100;
				$image_chkin = 'up.png';
			}
		}
		else if($prev_stat_checkin>$cur_stat)
		{
			if($cur_stat_checkin>0)
			{
				$growth_chkin = (($prev_stat_checkin - $cur_stat_checkin)/$cur_stat_checkin)*100;
				$image_chkin = 'down.png';
			}
		}
	}
                
	if($avg_daily_new_checkins)
	{
		if($avg_daily_new_checkins>$avg_daily_prev_new_checkins)
		{
			if($avg_daily_prev_new_checkins>0)
			{
				$growth_daily_chkin = (($avg_daily_new_checkins - $avg_daily_prev_new_checkins)/$avg_daily_prev_new_checkins)*100;
				$image_daily_chkin = 'up.png';
			}
		}
		else if($avg_daily_prev_new_checkins>$avg_daily_new_checkins)
		{	
			if($avg_daily_new_checkins>0)
			{
				$growth_daily_chkin = (($avg_daily_prev_new_checkins - $avg_daily_new_checkins)/$avg_daily_new_checkins)*100;
				$image_daily_chkin = 'down.png';
			}
		}
	}
                
	if($avg_daily_new_likes>$avg_daily_prev_new_likes)
	{
		if($avg_daily_prev_new_likes>0)
		{
			$growth_daily_like = (($avg_daily_new_likes - $avg_daily_prev_new_likes)/$avg_daily_prev_new_likes)*100;
			$image_daily_like = 'up.png';
		}	
	}
	else if($avg_daily_prev_new_likes>$avg_daily_new_likes)
	{
		if($avg_daily_new_likes>0)
		{
			$growth_daily_like = (($avg_daily_prev_new_likes - $avg_daily_new_likes)/$avg_daily_new_likes)*100;
			$image_daily_like = 'down.png';
		}
	}
                
	?>
    
	<table> 
    <tbody> 
    <tr> 
        <td style="border:none;">
            <?php echo getContent('user.onelocation.totallikes',Yii::app()->session['language']); ?><h4><?=$fb_likes + $glikes;?></h4>
            
            <?php if($growth) { ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image; ?>" /><?php echo number_format($growth,2); ?>%
            <?php } ?>
        </td>
    </tr>
    <tr> 	
        <td style="border:none;">
            <?php echo getContent('user.onelocation.dailynewlikes',Yii::app()->session['language']); ?><h4><?=number_format(ceil($avg_daily_new_likes))?></h4>
            
            <?php if($growth_daily_like) { ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image_daily_like; ?>" /><?php echo number_format($growth_daily_like,2); ?>%
            <?php } ?>
        </td>
    </tr>
    </tbody>
    </table>
</td>
	<?php
    
    if(count($like_dates))
    {
        $dates = '';
        $vallikes = '';
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
            
            $month_wise_report [$temp_exp[1].' '.$temp_exp[2]] = $likes_gdates[$keys] + $values;
            
            $dates .= "'".$keys."',";
            $vallikes .= ($likes_gdates[$keys] + $values).",";
        }
        
        
        if($nrows>30 && count($month_wise_report))
        {
            $dates = '';
            $vallikes = '';
            foreach($month_wise_report as $key_new=>$value_new)
            {
                $dates .= "'".$key_new."',";
                $vallikes .= ($likes_gdates[$key_new] + $value_new).",";
            }
        }
    ?>
            
	<script type="text/javascript">
	var chart;
	
	$(document).ready(function() 
	{
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'container',
				defaultSeriesType: 'line'
			},
			 colors: [
                	'#0ABCDA',
					'#B5E8FB'
				],
			title: {
				text: 'Total Likes report'
			},
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
				formatter: function() {
				  return ''+
				  this.x +': '+ this.y +' likes';
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
				name: 'Likes',
				data: [<?=substr($vallikes,0,strlen($vallikes)-1)?>]
			}]
		});
	  });			
	  </script>
            
<?php

}

?>
	
	<td width="70%">
    	<div id="container" style="width: 100%; height: 300px; margin: 0 auto"></div>
	</td> 
</tr>
<tr>
	<td valign="top">
        <table> 
        <tbody> 
        <tr> 
            <td>
                <?php echo getContent('user.onelocation.totalcheckins',Yii::app()->session['language']); ?><h4><?=$checkinsCount + $fb_checkins?></h4>
                
                <?php if($growth_chkin) { ?>
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image_chkin; ?>" /><?php echo number_format($growth_chkin,2); ?>%
                <?php } ?>
            </td>
        </tr>
        <tr> 
            <td>
                <?php echo getContent('user.onelocation.dailynewcheckins',Yii::app()->session['language']); ?><h4><?=number_format(ceil($avg_daily_new_checkins))?></h4>
                
                <?php if($growth_daily_chkin) { ?>
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image_daily_chkin; ?>" /><?php echo number_format($growth_daily_chkin,2); ?>%
                <?php } ?>
                
            </td>
        </tr>
        </tbody>
        </table>
	</td>
            
	<?php
    
    if($fb_chkin)
    {
        $dates_chkn = '';
        $fb_chkns = '';
        $fs_chkns = '';
        $months_chkn = array();
        $month_wise_report_fb = array();
        $month_wise_report_fs = array();
        
        foreach($fb_chkin as $key_s=>$value_s)
        {
            $temp_exp = explode(' ',$key_s);
			
            if(!in_array($temp_exp[1].' '.$temp_exp[2],$months_chkn))
            {
                array_push($months_chkn,$temp_exp[1].' '.$temp_exp[2]);
                $month_wise_report_fb [$temp_exp[1].' '.$temp_exp[2]] = 0;
                $month_wise_report_fs [$temp_exp[1].' '.$temp_exp[2]] = 0;
            }
                                                
			$dates_chkn .= "'".$key_s."',";
			
			
			$fb_chkns .= $value_s.",";
			
			if($fs_chkin[$key_s])
				$fs_chkns .= $fs_chkin[$key_s].",";
			
			$month_wise_report_fb [$temp_exp[1].' '.$temp_exp[2]] = $value_s;
			$month_wise_report_fs [$temp_exp[1].' '.$temp_exp[2]] = $fs_chkin[$key_s];
		}
                
		if($nrows>30 && count($month_wise_report_fb) && count($month_wise_report_fs))
		{
			$fb_chkns = '';
			$fs_chkns = '';
			
			foreach($month_wise_report_fb as $key_fb_new=>$value_fb_new)
				$fb_chkns .= $value_fb_new.",";
			
			foreach($month_wise_report_fs as $key_fs_new=>$value_fs_new)
			{
				if($value_fs_new)
					$fs_chkns .= $value_fs_new.",";
			}
		}
		
		$explode_fb = explode(',',$fb_chkns);
		$explode_fs = explode(',',$fs_chkns);
		
		$total_checkins = '';
		
		if(count($explode_fb))
		{
			$g = 0;
			foreach($explode_fb as $ke=>$va)
			{
				if($va)
				{
					$total_checkins .= $va + $explode_fs[$g].',';		
					$g++;
				}
			}
		}
            
		?>
            
        <script type="text/javascript">
        
		var chart;
            
        $(document).ready(function() {
			 chart = new Highcharts.Chart({
				chart: {
				   renderTo: 'containercheckins',
				   defaultSeriesType: 'line',
				   marginRight: 10,
				   marginBottom: 30
				},
				title: {
				   text: 'Total Checkins Report',
				   x: -20 //center
				},
				 colors: [
                	'#0ABCDA',
					'#B5E8FB'
				],
				xAxis: {
				   categories: [<?=substr($dates,0,strlen($dates)-1)?>]
				},
				yAxis: {
                  
				startOnTick: true,
				min: 0,
				
				 title: {
					text: 'Checkins'
				 },
				 plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				 }]
			  },
			  tooltip: {
				 formatter: function() { return '<b>'+ this.series.name +'</b><br/>'+ 'By '+ this.x +',checkins were '+ this.y; }
			  },
			legend: {
				enabled: false,
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -10,
				y: 100,
				borderWidth: 0
			  },
			  series: [
			  <? if($total_checkins!='') { ?>
			  {
				 name: 'Checkins',
				 data: [<?php echo substr($total_checkins,0,strlen($total_checkins)-1); ?>]
			  }, 
			  <? } ?>
			  
			  /*<? if($oneurl[0]['fburl']!='') { ?>
			  {
				 name: 'Facebook',
				 data: [<?php echo substr($fb_chkns,0,strlen($fb_chkns)-1); ?>]
			  }, 
			  <? } if($oneurl[0]['fsurl']!='') { ?>
			  {
				 name: 'Foursquare',
				 data: [<?php echo substr($fs_chkns,0,strlen($fs_chkns)-1); ?>]
			  }
			  <? } ?>*/
			  ]
		   });
		});
        </script>
		
	<?php
            
    }
            
    ?>
	<td align="left" style="border:none;">
    	<div id="containercheckins" style="width: 100%; height: 300px; margin: 0 auto"></div> 	
	</td>
</tr>
</tbody> 
</table>