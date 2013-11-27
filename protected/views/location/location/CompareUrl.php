<table style="border:none; width:100%;"> 
<tbody> 
<tr> 
    <td width="30%" valign="top">
        <table cellpadding="0" cellspacing="0"> 
        <tbody> 
        <tr>
            <td valign="top">
                <h4><?php echo $request['name'] ?> - <?=$request['newlikes'];?></h4>
            </td>
        </tr>
        <tr> 
            <td valign="top">	   
                <h4><?php echo $request['name2'] ?> - <?=$request['newlikes2'];?></h4>
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
                renderTo: 'containerfb2',
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
                name: '<?php echo $request['name'] ?>',
                data: [<?php echo $request['newlikes']; ?>]
    
            }, {
                name: '<?php echo $request['name2'] ?>',
                data: [<?php echo $request['newlikes2']; ?>]
    
            }]
        });
    });
      
    </script>
    
    <td align="left" width="70%" valign="top">
        <div id="containerfb2" style="width:100%; height:300px; margin:0 auto"></div>										
    </td> 
</tr>
<tr>
    <td>
        <table cellpadding="0" cellspacing="0"> 
        <tbody> 
        <tr> 
            <td valign="top">
              
                  <h4><?php echo $request['name'] ?> - <?=$request['checkins'];?></h4>
            </td>
        </tr>
        <tr> 
            <td valign="top">
          
                 <h4><?php echo $request['name2'] ?> - <?=$request['checkins2'];?></h4>.
                 
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
                renderTo: 'facebook_checkin_detail2',
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
                name: '<?php echo $request['name']; ?>',
                data: [<?php echo $request['checkins']; ?>]
    
            }, {
                name: '<?php echo $request['name2']; ?>',
                data: [<?php echo $request['checkins2']; ?>]
    
            }]
        });
    });
    
    </script>
      
    <td align="left" valign="top">
        <div id="facebook_checkin_detail2" style="width:100%; height:300px; margin:0 auto"></div>						
    </td>
</tr>
</tbody> 
</table>