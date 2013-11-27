<script type="text/javascript">

function showtable(val)
{
	if(val=='View Demographics in detail')
	{
		document.getElementById("table1").style.display="none";
		document.getElementById("table2").style.display="";
		document.getElementById("btn1").value="Close detailed view";
	}
	
	if(val=='Close detailed view')
	{
		document.getElementById("table1").style.display="";
		document.getElementById("table2").style.display="none";
		document.getElementById("btn1").value="View Demographics in detail";
	}
}

function showtable1(val)
{
	if(val=='See all reviews and competitors')
	{
		document.getElementById("table3").style.display="none";
		document.getElementById("table4").style.display="";
		document.getElementById("btn2").value="Close reviews";
	}
	
	if(val=='Close reviews')
	{
		document.getElementById("table3").style.display="";
		document.getElementById("table4").style.display="none";
		document.getElementById("btn2").value="See all reviews and competitors";
	}
}

function gotourl(url)
{  
	window.location= "<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/onelocation/id/<?=$_REQUEST['id']?>/val/"+url;  
}  


function CompareURL()
{
	var value = $('#another_fburl').val();
	var website_url = $('#website_url').val();
	var fb_likes = $('#fb_likes_val').val();
	var fb_daily_new_likes = $('#fb_daily_new_likes').val();
	var total_like_img = $('#total_like_img').html();
	var daily_new_like_img = $('#daily_new_like_img').html();
	var fb_total_checkins = $('#fb_total_checkins').val();
	var fb_dailynew_checkins = $('#fb_dailynew_checkins').val();
	var fb_total_checkins_img = $('#fb_total_checkins_img').html();
	var fb_dailynew_checkins_img = $('#fb_dailynew_checkins_img').html();
	var categories1 = $('#categories1').val();
	var data1 = $('#data1').val();
	var categories2 = $('#categories2').val();
	var data2 = $('#data2').val();
	var mypage = $('#mypagename').val();

	if(value!='')
	{
		$('#benchmark').submit();
		
		/*$('#another_fburl').css('border-color', '#666');
		
		$("html, body").animate({ scrollTop: $('#fbsummary').offset().top }, 1000);

		$('#fbsummary').html('<center><img src="'+website_url+'/images/ajax-loader.gif" /></center>');

		$.ajax({
			type : 'POST',
			url : website_url+'/index.php/location/compareurl',
			dataType : 'html',
			
			data: 'url='+value+'&fblikes='+fb_likes+'&fb_daily_new_likes='+fb_daily_new_likes+'&total_like_img='+total_like_img+'&daily_new_like_img='+daily_new_like_img+'&fb_total_checkins='+fb_total_checkins+'&fb_dailynew_checkins='+fb_dailynew_checkins+'&fb_total_checkins_img='+fb_total_checkins_img+'&fb_dailynew_checkins_img='+fb_dailynew_checkins_img+'&categories1='+categories1+'&data1='+data1+'&categories2='+categories2+'&data2='+data2+'&mypage='+ mypage,
			
			success : function(data){
				$('#fbsummary').html(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) { alert(errorThrown) }
		});	*/
	}
	else
		$('#another_fburl').css('border-color', '#CC6699');
}

</script>