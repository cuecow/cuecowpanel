<div style="float:right;">
	<input id="btn2" type="button" value="See all reviews and competitors" class="btn btn-large" onclick="showtable1(this.value);" />
</div>
			
<table style="width:100%;"> 
<tbody> 
<?php
    
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
        
    foreach($g_data as $key=>$value)
    {
        if($nrows>30)	
            $like_dates_g [date('d M Y',$value['dated'])] =  $value['glikes'];
        else
            $like_dates_g [date('d M',$value['dated'])] =  $value['glikes'];
    }
        
    $avg_daily_new_glikes = $likes_diff_g / $nrows;
}
    
?>
<tr> 
	<td width="30%" valign="top">
		<table> 
		<tbody> 
		<tr> 
			<td>
				<?php echo getContent('user.onelocation.totallikes',Yii::app()->session['language']); ?>
                <h4><?=$glikes;?></h4>
							
				<?php if($LastLikes) { ?>
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image_google; ?>" /><?php echo number_format($growth_google,2); ?>%
				<?php } ?>
			</td>
		</tr>
		<tr> 
			<td style="border:none;">
				<?php echo getContent('user.onelocation.dailynewlikes',Yii::app()->session['language']); ?><h4><?=number_format(ceil($avg_daily_new_glikes))?></h4>
							
				<?php if($LastLikes) { ?>
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image_google_daily_like; ?>" /><?php echo number_format($growth_google_daily_like,2); ?>%
				<?php } ?>
			</td>
		</tr>
		</tbody>
		</table>				
	</td>
					
	<?php
    
    if(count($like_dates_g))
    {
        $dates_g='';
        $vallikes_g='';
        
        $months_g = array();
        $month_wise_report_g = array();
        
        foreach($like_dates_g as $keys=>$values)
        {
            $temp_exp = explode(' ',$keys);
            if(!in_array($temp_exp[1].' '.$temp_exp[2],$months_g))
            {
                array_push($months_g,$temp_exp[1].' '.$temp_exp[2]);
                $month_wise_report_g [$temp_exp[1].' '.$temp_exp[2]] = 0;
            }
            
            $month_wise_report_g [$temp_exp[1].' '.$temp_exp[2]] = $values;
            
            $dates_g .= "'".$keys."',";
            $vallikes_g .= $values.",";
        }
						
		if($nrows>30 && count($month_wise_report_g))
		{
			$dates_f = '';
			$vallikes_g = '';
			foreach($month_wise_report_g as $key_new=>$value_new)
			{
				$dates_f .= "'".$key_new."',";
				$vallikes_g .= $value_new.",";
			}
		}
	?>
					
	<script type="text/javascript">

    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'containerglikes',
                defaultSeriesType: 'areaspline'
            },
            title: {
                text: 'Daily Likes report'
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
                categories: [<?=substr($dates,0,strlen($dates_g)-1)?>],
                plotBands: [{ 
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
                                    return '<b>'+ this.series.name +'</b><br/>'+
                                    'By '+ this.x +',likes were '+ this.y;
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
                data: [<?=substr($vallikes_g,0,strlen($vallikes_g)-1)?>]
            }]
        });
        
        
    });
    
    </script>
    
    <?php } ?>
					
    <td align="left" width="70%" style="border:none;">
        <div id="containerglikes" style="width:800px; height: 300px; margin: 0 auto"></div>
    </td>
					
	<? 
	
	$html = file_get_html($gurl);
	$category = "";
	$hours = "";
	$photo = "";
	$reviewcount = "";
	
	foreach($html->find('span#pp-cats-closed') as $element) 
	{
		$category = $element->innertext;
	}
	
	$totalrev = $html->find('[class*=rsw-pp rsw-pp-link]');
	
	foreach($totalrev as $key=>$value) 
	{
		$reviewcount = strip_tags($totalrev[0]);
	}
	
	$a=explode(" ",$reviewcount);
	
	$result=$html->find('[class*=oh-highlight-day]');
	
	foreach( $result as $key=>$value)
	{
		$hours=strip_tags($result[0]);
	}
	
	$stationname=$html->find('[class*=pp-transit-station-name]');
	foreach( $stationname as $key=>$value)
	{
		$sname=strip_tags($stationname[0]);
	}
	
	$dist=$html->find('[class*=pp-transit-station-dist]');
	foreach( $dist as $key=>$value)
	{
		$distance=strip_tags($dist[0]);
	}
							
	$result1=$html->find('div#pp-photos');
	$uploadphotos=$html->find('[class*=lnk noprint]');
	foreach($uploadphotos as $key=>$value)
	{
		$uploadtext=$uploadphotos[0];
	}
	
	$reviewcont=$html->find('div#pp-reviews-container');
					
?>
</tr>
<!--<tr>
	<td colspan="2" valign="top">
        <table width="100%">
        <tr>
            <td style="border:none">
            <?php
            
            for($i=1;$i<=5;$i++)
            {
                if($i<=$rating_url)
                {
            ?>
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/1319878693_star.png" /> 
                            
            <?php
                }
                else
                {
            ?>
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/1319878846_star_empty.png" /> 
            <?php
                }	
            } 
        
            ?>
            
            </td>
        </tr>
        <tr>
            <td>
                <b><?php echo getContent('user.onelocation.category',Yii::app()->session['language']); ?>:</b> <?=$category;?><br />
                <b><?php echo getContent('user.onelocation.hours',Yii::app()->session['language']); ?>:</b> <?=$hours;?><br />
                <b><?php echo getContent('user.onelocation.transit',Yii::app()->session['language']); ?>:</b> <?=$sname;?> <span> <font color="#999999"><?=$distance;?></font></span>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                <tr>
                    <td colspan="6" align="center"><div id="map1" style="height:400px; width:900px"></div></td>
                </tr>
                <tr>
                    <td colspan="5">
                    <? 
                        foreach($result1 as $e)
                        {
                            echo $e->innertext;
                        } 
                    ?>
                    </td> 
                </tr>
                <tr>
                    <td colspan="3" align="left"></td>
                    <td colspan="3" align="right"></td>
                </tr>
                <tr>
                    <td colspan="3" align="left"></td>
                    <td olspan="3" align="right"><?=$uploadtext;?></td>
                </tr>
                </table>
            </td>
        </tr>
        </table>						
	</td>
</tr>-->
</tbody> 
</table>
				
<table id="table4"> 
<tbody> 
<tr> 
    <td width="5%">
    <? 
        foreach($reviewcont as $element) 
        {
            echo utf8_encode($element->innertext);
        }
    ?>
    </td>			 
</tr>
</tbody>
</table>
