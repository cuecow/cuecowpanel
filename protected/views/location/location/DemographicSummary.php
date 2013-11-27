<?php
$DemoInfo = $model->GetDemoGraphic($_REQUEST['id'],$last_date);

if(count($DemoInfo))
{
	$male=array();
	$female=array();
	$unknown=array();
	$dates='';
	$sum_on_dates='';
	$male_sum_on_dates='';
	$female_sum_on_dates='';
	$unknown_sum_on_dates='';
	
	$dates_arr = array();
	$male_sum_on_dates_arr = array();
	$female_sum_on_dates_arr = array();
	$unknown_sum_on_dates_arr = array();
	
	foreach($DemoInfo as $key=>$value)
	{
		if($nrows>30)	
			$dates .='\''.date('d M Y',$value['dated']).'\',';
		else
			$dates .='\''.date('d M',$value['dated']).'\',';
		
		if(!in_array(date('M',$value['dated']).' '.date('Y',$value['dated']),$dates_arr))
		{
			array_push($dates_arr,date('M',$value['dated']).' '.date('Y',$value['dated']));
		}
		
		$dates_sum=0;
		$temp_male_row=0;
		$temp_female_row=0;
		$temp_unknown_row=0;
			
		foreach($DemoInfo[$key] as $keys=>$values)
		{	
			if($keys!='age_id' && $keys!='loc_id' && $keys!='dated')
				$dates_sum = $dates_sum + $values;
				
			if(strstr($keys,'F'))
			{
				$temp_female_row = $temp_female_row + $values;
				$female[str_replace('F.','',$keys)]=$values;
			}
				
			if(strstr($keys,'M'))
			{
				$temp_male_row = $temp_male_row + $values;
				$male[str_replace('M.','',$keys)]=$values;
			}
					
			if(strstr($keys,'U'))
			{
				$temp_unknown_row = $temp_unknown_row + $values;
				$unknown[str_replace('U.','',$keys)]=$values;
			}
		}
			
		$sum_on_dates .= $dates_sum.',';
		$male_sum_on_dates .= $temp_male_row.',';
		$female_sum_on_dates .= $temp_female_row.',';
		$unknown_sum_on_dates .= $temp_unknown_row.',';
		
		$male_sum_on_dates_arr [date('M',$value['dated']).' '.date('Y',$value['dated'])] = $temp_male_row;
		$female_sum_on_dates_arr [date('M',$value['dated']).' '.date('Y',$value['dated'])] = $temp_female_row;
		$unknown_sum_on_dates_arr [date('M',$value['dated']).' '.date('Y',$value['dated'])] =  $temp_unknown_row;
	}
	
	
	if($nrows>30 && count($male_sum_on_dates_arr) && count($dates_arr))
	{
		$dates = '';
		$male_sum_on_dates = '';
		$female_sum_on_dates = '';
		$unknown_sum_on_dates = '';
		
		foreach($male_sum_on_dates_arr as $keyys=>$valvs)
		{
			$dates .= "'".$keyys."',";
			$male_sum_on_dates .= $male_sum_on_dates_arr[$keyys].',';
			$female_sum_on_dates .= $female_sum_on_dates_arr[$keyys].',';
			$unknown_sum_on_dates .= $unknown_sum_on_dates_arr[$keyys].',';
		}
	}
	
	$dates = substr($dates,0,strlen($dates)-1);
	
	$sum_on_dates = substr($sum_on_dates,0,strlen($sum_on_dates)-1);
	$male_sum_on_dates=substr($male_sum_on_dates,0,strlen($male_sum_on_dates)-1);
	$female_sum_on_dates=substr($female_sum_on_dates,0,strlen($female_sum_on_dates)-1);
	$unknown_sum_on_dates=substr($unknown_sum_on_dates,0,strlen($unknown_sum_on_dates)-1);
	
		
	$sum_male=0;
		
	if(count($male))
	{
		foreach($male as $key_1=>$value_1)
			$sum_male = $sum_male + $value_1;
	}
		
	$sum_female=0;
	
	if(count($female))
	{
		foreach($female as $key_2=>$value_2)		
			$sum_female = $sum_female + $value_2;
	}
		
	$sum_unknown=0;
		
	if(count($unknown))
	{
		foreach($unknown as $key_3=>$value_3)		
			$sum_unknown = $sum_unknown + $value_3;
	}
		
	$total_visits = $sum_male + $sum_female + $sum_unknown;
		
	$perc_male = number_format(($sum_male*100) / $total_visits,1);
	$perc_female = number_format(($sum_female*100) / $total_visits,1);
	$perc_unknown = number_format(($sum_unknown*100) / $total_visits,1);
		
	$visits = '';
	
?>

<!--<script type="text/javascript">

var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'demo_graph_1',
			defaultSeriesType: 'areaspline'
		},
		title: {
			text: 'Total Visitor report'
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
			categories: [<?=$dates?>],
			plotBands: [{ // visualize the weekend
				from: 4.5,
				to: 6.5,
				color: 'rgba(68, 170, 213, .2)'
			}]
		},
		yAxis: {
			title: {
				text: 'Total Vistors'
			}
		},
		tooltip: {
			formatter: function() {
					return ''+
					this.x +': '+ this.y +' visitors';
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
			name: 'Visits',
			data: [<?=$sum_on_dates?>]
		}]
	});
});
				
</script>
-->
<script type="text/javascript">

var chart;

$(document).ready(function() {
   chart = new Highcharts.Chart({
      chart: {
         renderTo: 'scattrd_demo',
         defaultSeriesType: 'line',
         marginRight: 0,
         marginBottom: 25
      },
      title: {
         text: 'Gender Visiting Report',
         x: -20 //center
      },
	   colors: [
		  '#0ABCDA',
		  '#B5E8FB'
	  ],
      xAxis: {
         categories: [<?=$dates?>]
      },
      yAxis: {
	  
	  	startOnTick: true,
		min: 0,
		
         title: {
            text: 'Visiting'
         },
         plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
         }]
      },
      tooltip: {
         formatter: function() { return '<b>'+ this.series.name +'</b><br/>'+ 'By '+ this.x +',visits were '+ this.y; }
      },
      legend: {
         layout: 'vertical',
         align: 'right',
         verticalAlign: 'top',
         x: -10,
         y: 100,
         borderWidth: 0
      },
      series: [
	  
	  {
         name: 'Male',
         data: [<?=$male_sum_on_dates?>]
      }, 
	 
	  {
         name: 'Female',
         data: [<?=$female_sum_on_dates?>]
      }, 
	  
	  {
         name: 'Unknown',
         data: [<?=$unknown_sum_on_dates?>]
      }
	 
	  ]
   });
});

$(document).ready(function() 
{
	chart = new Highcharts.Chart({
		chart: {
        renderTo: 'pie_container',
        marginRight: 130,
        marginBottom: 25,
		plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false
	},
	
	title: 
	{
		text: '<?php echo getContent('user.onelocation.genderhead',Yii::app()->session['language']); ?>'
	},
	
	
	tooltip: 
	{
		pointFormat: '{series.name}: <b>{point.percentage}%</b>',
		percentageDecimals: 1
	},
	
	plotOptions: 
	{
		pie: {
			allowPointSelect: true,
			cursor: 'pointer',
			dataLabels: {
				enabled: true,
				color: '#000000',
				connectorColor: '#000000',
				formatter: function() {
					return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage).toFixed(1) +' %';
				}
			},
			showInLegend: true
		}
	},
	
	series: [{
		type: 'pie',
		name: 'Vistor Details',
		data: [
			['<?php echo getContent('user.onelocation.female',Yii::app()->session['language']); ?>',<?php echo $perc_female; ?>],
			['<?php echo getContent('user.onelocation.male',Yii::app()->session['language']); ?>',<?php echo $perc_male; ?>],
			['<?php echo getContent('user.onelocation.unknown',Yii::app()->session['language']); ?>',<?php echo $perc_unknown; ?>]
		]
	}]
	
	});
});
</script>

<div class="accordion" id="accordion10">
    <div class="accordion-group">
        
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseTen" title="Click to open/close"><?php echo getContent('user.onelocation.detaileddemosum',Yii::app()->session['language']); ?></a>
        </div>
        
        <div id="collapseTen" class="accordion-body collapse in">
            <div class="accordion-inner">					
                <table cellpadding="0" cellspacing="0" style="width:100%;">
                <tr>
                    <td colspan="4" align="right" style="border:none;">
                        <div style="padding:0px 28px 0px 28px;">
                            <input id="btn1" type="button" class="btn btn-info btn-large" value="View Demographics in detail" onclick="showtable(this.value);" />
                        </div>
                    </td>
                </tr> 
                </table>
				
                <div class="clearfix"></div>
                <table id="table1" cellpadding="0" cellspacing="0" style="border:none;" width="100%"> 
                <tbody>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr> 
                    <td width="60%" style="border:none;" valign="top" align="center">
                    	<div id="pie_container" style="width:100%; height:400px; margin:0px auto;"></div>
                    </td>
                    <td align="left" width="40%" style="border:none;" valign="top">
                        <table class="table table-striped" cellpadding="0" cellspacing="1" style="border:none;"> 
                        <thead> 
                        <tr> 
                            <th width="25%" style="border:none;"><strong><?php echo getContent('user.onelocation.age',Yii::app()->session['language']); ?></strong></th>  
                            <th width="25%" style="border:none;"><strong><?php echo getContent('user.onelocation.male',Yii::app()->session['language']); ?></strong></th> 
                            <th width="25%" style="border:none;"><strong><?php echo getContent('user.onelocation.female',Yii::app()->session['language']); ?></strong></th> 
                            <th width="25%" style="border:none;"><strong><?php echo getContent('user.onelocation.unknown',Yii::app()->session['language']); ?></strong></th> 
                        </tr> 
                        </thead> 
                        <tbody> 
                        <?php foreach($male as $key_4=>$value_4){ ?>
                        <tr> 
                            <td align="center" style="border:none;"><strong><?php echo $key_4;  ?></strong></td> 
                            <td align="center" style="border:none;"><?php echo $IndiInfo_male=$model->GetDemoIndi($_REQUEST['id'],$last_date,'M.'.$key_4); ?></td> 
                            <td align="center" style="border:none;"><?php echo $IndiInfo_female=$model->GetDemoIndi($_REQUEST['id'],$last_date,'F.'.$key_4); ?></td> 
                            <td align="center" style="border:none;"><?php echo $IndiInfo_unknown=$model->GetDemoIndi($_REQUEST['id'],$last_date,'U.'.$key_4); ?></td> 
                        </tr>
                        <?php } ?>
                        </tbody> 
                        </table>
                    </td>
                     
                </tr>
                <!--<tr>
                    <td align="left" colspan="2" style="border:none;">
                        <b>Time breakdown-</b> When do visitors check in?
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2" style="border:none;">
                        <div id="demo_graph_1" style="width:800px; height:300px;"></div>
                    </td> 
                </tr>-->
                </tbody> 
                </table>
				
                <div class="clearfix"></div>
                
                <table id="table2" style="display:none;" cellpadding="0" cellspacing="0" width="100%">  
                <tbody>
                <tr>
                    <td colspan="4" style="border:none;">
                        <?php echo getContent('user.onelocation.genderhead',Yii::app()->session['language']); ?>
                    </td>
                </tr>
                <tr> 
                    <td width="35%" style="border:none;">
                        <table class="table" cellpadding="0" cellspacing="0" style="border:none;"> 
                        <tbody> 
                        <tr> 
                            <td style="border:none;">
                                <table style="border:none;">
                                <tr>
                                    <td style="border:none;">
                                    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/male.jpg" />
                                    </td>
                                    <td style="border:none;">
										<?php echo getContent('user.onelocation.male',Yii::app()->session['language']); ?> <h2><?php echo round($perc_male); ?>%</h2>
                                    </td>
                                </tr>
                                </table>
                             </td>
                        </tr>	
                        <tr> 
                            <td style="border:none;">
                                <table style="border:none;">
                                <tr>
                                    <td style="border:none;">
                                    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/female.jpg" />
                                    </td>
                                    <td style="border:none;">
										<?php echo getContent('user.onelocation.female',Yii::app()->session['language']); ?> <h2><?php echo round($perc_female); ?>%</h2>
                                    </td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                        <tr> 
                            <td style="border:none;">
                                <table style="border:none;">
                                <tr>
                                    <td style="border:none;">
                                    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/1320140840_FAQ.png" />
                                    </td>
                                    <td style="border:none;">
										<?php echo getContent('user.onelocation.unknown',Yii::app()->session['language']); ?> <h2><?php echo round($perc_unknown); ?>%</h2>
                                    </td>
                                </tr>
                                </table>
                             </td>
                        </tr>
                        </tbody>
                        </table>
                    </td>
                    <td width="65%" colspan="2" align="left">
                        <div id="scattrd_demo" style="width:800px; height:300px;"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-striped" cellpadding="0" cellspacing="1" width="100%"> 
                        <thead> 
                        <tr> 
                            <th width="25%">
                            <strong>
								<?php echo getContent('user.onelocation.age',Yii::app()->session['language']); ?>
                            </strong>
                            </th> 
                            <th width="25%">
                            <strong>
								<?php echo getContent('user.onelocation.male',Yii::app()->session['language']); ?>
                            </strong>
                            </th> 
                            <th width="25%">
                            <strong>
								<?php echo getContent('user.onelocation.female',Yii::app()->session['language']); ?>
                            </strong>
                            </th> 
                            <th width="25%">
                            <strong>
								<?php echo getContent('user.onelocation.unknown',Yii::app()->session['language']); ?>
                            </strong>
                            </th> 
                        </tr> 
                        </thead> 
                        <tbody> 
                        <?php foreach($male as $key_5=>$value_5){ ?>
                        <tr> 		
                            <td align="center"><strong><?php echo $key_5;  ?></strong></td> 
                            <td align="center">
								<?php echo round(($IndiInfo_male_m=$model->GetDemoIndi($_REQUEST['id'],$last_date,'M.'.$key_5)*100)/$total_visits); ?> %
                            </td> 					
                            <td align="center">
								<?php echo round(($IndiInfo_female_f=$model->GetDemoIndi($_REQUEST['id'],$last_date,'F.'.$key_5)*100)/$total_visits); ?> %
                            </td> 	
                            <td align="center">
								<?php echo round(($IndiInfo_unknown_u=$model->GetDemoIndi($_REQUEST['id'],$last_date,'U.'.$key_5)*100)/$total_visits); ?> %
                            </td> 	
                        </tr>
                        <?php } ?>
                        </tbody> 
                        </table>
                    </td>
                </tr>
                </tbody>
                </table>
                
            </div>
        </div>
    
    </div>
</div>
		
<?php
}	
?>