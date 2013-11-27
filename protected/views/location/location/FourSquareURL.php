<table style="width:100%;"> 
<tbody> 
<?php

$ActiveCampaign = $model->GetFSCampaigns($oneurl[0]['group_ids']);

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
    
    $avg_daily_new_fslikes = $checkin_diff_fs / $nrows;
    
    $avg_daily_new_fslikes = ($avg_daily_new_fslikes<0) ? 0:$avg_daily_new_fslikes;
}
    
?>
<tr> 
    <td width="30%">
        <table> 
        <tbody> 
        <tr> 
            <td valign="top">
                <?php echo getContent('user.onelocation.totalcheckins',Yii::app()->session['language']); ?><h4><?=floor($checkinsCount);?></h4>
                
                <?php if(count($LastLikes3)) { ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image_fs; ?>" /><?php echo number_format($growth_fs,2); ?>%
                <?php } ?>
            </td>
        </tr>
        <tr> 
            <td valign="top">
                <?php echo getContent('user.onelocation.dailynewcheckins',Yii::app()->session['language']); ?><h3><?=number_format(ceil($avg_daily_new_fslikes))?></h3>
                
                <?php if(count($LastLikes3)) { ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image_fs_daily_like; ?>" /><?php echo number_format($growth_fs_daily_like,2); ?>%
                <?php } ?>
                
            </td>
        </tr>
        </tbody>
        </table>						
    </td>
    <?php
    
    if(count($fs_chkin))
    {
        $dates_f='';
        $vallikes_f='';
        
        $months_f = array();
        $month_wise_report_f = array();
        
        foreach($fs_chkin as $keys=>$values)
        {
            $temp_exp = explode(' ',$keys);
            if(!in_array($temp_exp[1].' '.$temp_exp[2],$months_f))
            {
                array_push($months_f,$temp_exp[1].' '.$temp_exp[2]);
                $month_wise_report_f [$temp_exp[1].' '.$temp_exp[2]] = 0;
            }
            
            $month_wise_report_f [$temp_exp[1].' '.$temp_exp[2]] = $values;
            
            $dates_f .= "'".$keys."',";
            $vallikes_f .= $values.",";
        }
        
        if($nrows>30 && count($month_wise_report_f))
        {
            $dates_f = '';
            $vallikes_f = '';
            foreach($month_wise_report_f as $key_new=>$value_new)
            {
                $dates_f .= "'".$key_new."',";
                $vallikes_f .= $value_new.",";
            }
        }
    ?>
    
    <script type="text/javascript">
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'containerfscheckin',
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
                categories: [<?=substr($dates_f,0,strlen($dates_f)-1)?>],
                plotBands: [{ // visualize the weekend
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
                formatter: function() {
                                    return '<b>'+ this.series.name +'</b><br/>'+
                                    'By '+ this.x +',checkins were '+ this.y;
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
                name: 'Daily Checkins',
                data: [<?=substr($vallikes_f,0,strlen($vallikes_f)-1)?>]
            }]
        });
    });
    </script>
    <?php
    }
    ?>
    <td width="70%">
        <div id="containerfscheckin" style="width: 100%; height: 300px; margin: 0 auto"></div>							
    </td> 
</tr>

<?php if(count($ActiveCampaign)) { ?>

<tr>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foursquare.css" type="text/css" />
    <td align="center" width="15%" style="border:none;">
        <div class="specials">
        <div id="createSpecial" class="specials">
            <div id="right">
                <div class="unlocked" id="preview">
                      
                    <div id="previewScreen">
                        <?php
                        
                        if($ActiveCampaign[0]['sp_type'] == 'swarm')
                            $sptype	= 'swarm_unlocked';
                        
                        if($ActiveCampaign[0]['sp_type'] == 'friend')
                            $sptype = 'friends_unlocked';
                        
                        if($ActiveCampaign[0]['sp_type'] == 'flash')
                            $sptype = 'flash_unlocked';
                        
                        if($ActiveCampaign[0]['sp_type'] == 'newbie')
                            $sptype = 'newbie_unlocked';
                        
                        if($ActiveCampaign[0]['sp_type'] == 'checkin')
                            $sptype = 'check-in_unlocked';
                        
                        if($ActiveCampaign[0]['sp_type'] == 'loyalty')
                            $sptype = 'frequency_unlocked';
                        
                        if($ActiveCampaign[0]['sp_type'] == 'mayor')
                            $sptype = 'mayor_unlocked';
                        
                        ?>
                        <div id="flag">
                            <div id="previewIcon">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/<?php echo $sptype; ?>.png" />
                            </div>
                            <span><?php echo ucfirst($ActiveCampaign[0]['sp_type']); ?> Special</span>
                        </div>
                        
                        <div id="specialContainer">
                            <div class="specialContent" style="min-height:50px;">
                                <p id="welcome">
                                    <?php echo getContent('user.onelocation.welcomevenue',Yii::app()->session['language']); ?>
                                    <span id="address"><?php echo $ActiveCampaign[0]['offer']; ?></span>
                                </p>
                            </div>
                            <div id="explanation" align="left">
                              <?php echo getContent('user.onelocation.unlocked',Yii::app()->session['language']); ?>:
                              <span class="unlocked"><?php echo $ActiveCampaign[0]['unlockedText']; ?></span>
                            </div>
                        </div>
                        
                        <div id="fineprint" align="left">
                            <?php echo $ActiveCampaign[0]['finePrint']; ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    </td>
    <td valign="top">
        <table style="width:100%;">
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
        	<td style="width:10%;">&nbsp;</td>
            <td><b><?php echo getContent('user.onelocation.kpis',Yii::app()->session['language']); ?></b> : <?php echo $ActiveCampaign[0]['kpi']; ?></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td><b><?php echo getContent('user.onelocation.special',Yii::app()->session['language']); ?></b> : <?php echo ucfirst($ActiveCampaign[0]['sp_type']); ?> Special</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td><b><?php echo getContent('user.onelocation.campaignstart',Yii::app()->session['language']); ?></b> : <?php echo date('m/d/Y',$ActiveCampaign[0]['start_date']); ?></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td><b><?php echo getContent('user.onelocation.campaignend',Yii::app()->session['language']); ?></b> : <?php echo date('m/d/Y',$ActiveCampaign[0]['end_date']); ?></td>
        </tr>
        </table>
    </td>
</tr>

<?php } ?>

</tbody> 
</table>
