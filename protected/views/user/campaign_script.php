<script type="text/javascript">

var httpobj2=false;
if(window.XMLHttpRequest)
	httpobj2=new XMLHttpRequest();

if(window.ActiveXObject)
	httpobj2=new ActiveXObject("Microsoft.XMLHTTP");	
	
function CheckVenueSelect()
{
	if(document.getElementById('sel_venue').value == 0)
	{
		document.getElementById('sel_venue').style.border = '#FF0000 1px solid';
		document.getElementById('sel_venue_errro').style.display = 'block';
		document.getElementById('sel_venue').focus();
	}
	else
	{
		document.getElementById('sel_venue').style.border = '#7F9DB9 1px solid';
		document.getElementById('sel_venue_errro').style.display = 'none';
		document.getElementById('block_to_click').style.zIndex = '-10';
	}
}
	
function OpenHideDiv(id,status)
{
	if(status==true)
		document.getElementById(id).style.display='block';
	else
		document.getElementById(id).style.display='none';
		
	var fs_specials 		= document.getElementById('fs_specials').checked;
	var facebook_deals 		= document.getElementById('facebook_deals').checked;
	var google_places_chk 	= document.getElementById('google_places_chk').checked;
	var fbposts 			= document.getElementById('fbposts').checked;
	var twitter 			= document.getElementById('twitter').checked;
	var FB_ads 				= document.getElementById('FB_ads').checked;
	var google_adwords 		= document.getElementById('google_adwords').checked;
	
	if(fs_specials == false && facebook_deals == false && google_places_chk == false && fbposts == false && twitter == false && FB_ads == false && google_adwords == false)
		document.getElementById('group_div').style.display='none';
	else
		document.getElementById('group_div').style.display='block';
}

function ChangeTitle(val1,val2)
{
	var flag_html='<div id="previewIcon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/'+ val1 +'.png" /></div><span>'+ val2 +' Special</span>';
	document.getElementById('flag').innerHTML=flag_html;
	
	
	document.getElementById('swarm_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/swarm_off.png";
	document.getElementById('friends_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/friends_off.png";
	document.getElementById('flash_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/flash_off.png";
	document.getElementById('newbie_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/newbie_off.png";
	document.getElementById('checkin_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/check-in_off.png";
	document.getElementById('frequency_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/frequency_off.png";
	document.getElementById('mayor_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/mayor_off.png";
	
	
	if(val2=='Swarm')
		document.getElementById('swarm_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/swarm_on.png";
	else if(val2=='Friends')
		document.getElementById('friends_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/friends_on.png";
	else if(val2=='Flash')
		document.getElementById('flash_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/flash_on.png";
	else if(val2=='Newbie')
		document.getElementById('newbie_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/newbie_on.png";
	else if(val2=='Check-in')
		document.getElementById('checkin_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/check-in_on.png";
	else if(val2=='Loyalty')
		document.getElementById('frequency_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/frequency_on.png";
	else if(val2=='Mayor')
		document.getElementById('mayor_pic').src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/mayor_on.png";
}

function PutStep2()
{
	
	var html='';
	
	if(document.getElementById('swarm').checked==true)
		html +='When &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" value="20" id="swarm_people" name="swarm_people" onKeyUp="PutPhoneHtml2(\'swarm_people\',this.value);" />&nbsp;&nbsp; people are checked in at once with a maximum of &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" value="30" id="swarm_days" name="swarm_days" onKeyUp="PutPhoneHtml2(\'swarm_days\',this.value);" />&nbsp;&nbsp;  unlocks per day.';	
	else if(document.getElementById('friend').checked==true)
		html +='When &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" value="3" name="friend_people" id="friend_people" onKeyUp="PutPhoneHtml2(\'friend_people\',this.value);" />&nbsp;&nbsp; friends check in together.';	
	else if(document.getElementById('flash').checked==true)
		html +='When a customer is one of the first &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" value="10" name="flash_people" id="flash_people" onKeyUp="PutPhoneHtml2(\'flash_people\',this.value);" />&nbsp;&nbsp; people to check in between &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" name="flash_time1" id="flash_time1" value="5:00 PM" onKeyUp="PutPhoneHtml2(\'flash_time1\',this.value);" />&nbsp;&nbsp;  and &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" name="flash_time2" id="flash_time2" value="8:00 PM" onKeyUp="PutPhoneHtml2(\'flash_time2\',this.value);" />&nbsp;&nbsp; .';	
	else if(document.getElementById('newbie').checked==true)
		html +='<input type="radio" class="radio" name="newbie_check" id="each_venue" checked="checked" value="each_venue" /> When a user checks in for the first time at each venue.<br /><input type="radio" class="radio" name="newbie_check" id="any_venue" value="any_venue" /> When a user checks in for the first time at any venue.';	
	else if(document.getElementById('checkin').checked==true)
		html +='When anyone checks in.';	
	else if(document.getElementById('loyalty').checked==true)
		html +='<input type="radio" class="radio" name="loyalty_check" id="loyalty_check1" checked="checked" onclick="PutPhoneHtml();" value="1" /> Every &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" id="loyalty_opt1" name="loyalty_opt1" value="3" onKeyUp="PutPhoneHtml2(\'loyalty_opt1\',this.value);" />&nbsp;&nbsp; check-ins <br /><br /><input type="radio" class="radio" name="loyalty_check" id="loyalty_check2" onclick="PutPhoneHtml();" value="2"  /> When a customer checks in exactly &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" id="loyalty_opt2" name="loyalty_opt2" value="3" onKeyUp="PutPhoneHtml2(\'loyalty_opt2\',this.value);" />&nbsp;&nbsp; times <br /><br /><input type="radio" class="radio" name="loyalty_check" id="loyalty_check3" onclick="PutPhoneHtml();" value="3" /> When a customer has checked in &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" id="loyalty_opt3" name="loyalty_opt3" value="3" onKeyUp="PutPhoneHtml2(\'loyalty_opt3\',this.value);" />&nbsp;&nbsp; or more times in the last &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" id="loyalty_opt4" name="loyalty_opt4" value="7" onKeyUp="PutPhoneHtml2(\'loyalty_opt4\',this.value);" />&nbsp;&nbsp; days.<br /><br />Progress towards unlocking the special counts check-ins:<br /><br /><input type="radio" class="radio" name="loyalty_check_venue" id=loaylty_each_venue"" checked="checked" value="each_venue" /> At each venue separately  <br /><br /><input type="radio" class="radio" name="loyalty_check_venue" id="loaylty_all_venue" value="all_venue" /> Across all venues together';	
	else if(document.getElementById('mayor').checked==true)
		html +='When a customer is the mayor and checks in.';	
		
	document.getElementById('part2').innerHTML=html;
	
	PutPhoneHtml();
	
	document.getElementById('acc2_smaple').style.display='none';
	document.getElementById('acc2').style.display='block';
}

function StepChange(id)
{
	document.getElementById('acc'+ id +'_sample').style.display='none';
	document.getElementById('acc'+ id +'').style.display='block';
}

function DoneFQ()
{
	jQuery('#acc4').hide();
}

function PutPhoneHtml()
{
	var valhtml='';
	
	if(document.getElementById('swarm').checked==true)
		valhtml='Unlocked: <span class="unlocked"> for swarms of <span id="swarm_people_content">20</span> people (up to <span id="swarm_days_content">30</span> per day)</span>';
	if(document.getElementById('friend').checked==true)
		valhtml='Unlocked: <span class="unlocked"> for <span id="friend_people_content">3</span> friends checking in together</span>';
	if(document.getElementById('flash').checked==true)
		valhtml='Unlocked: <span class="unlocked"> for the first <span id="flash_people_content">20</span> people between <span id="flash_time1_content">5:00 PM</span> and <span id="flash_time2_content">8:00 PM</span></span>';
	if(document.getElementById('newbie').checked==true)
		valhtml='Unlocked: <span class="unlocked"> on your 1st check-in</span>';
	if(document.getElementById('checkin').checked==true)
		valhtml='Unlocked: <span class="unlocked"> every check-in</span>';
	if(document.getElementById('loyalty').checked==true)
	{
		if(document.getElementById('loyalty_check1').checked==true)
			valhtml='Unlocked: <span class="unlocked"> every <span id="loyalty_opt1_content">3</span> check-ins';
		else if(document.getElementById('loyalty_check2').checked==true)
			valhtml='Unlocked: <span class="unlocked"> on your <span id="loyalty_opt2_content">3</span> check-in</span>';
		else if(document.getElementById('loyalty_check3').checked==true)
			valhtml='Unlocked: <span class="unlocked"> for checking in <span id="loyalty_opt3_content">3</span> times in <span id="loyalty_opt4_content">7</span> days</span>';
	}
	if(document.getElementById('mayor').checked==true)
		valhtml='Unlocked: <span class="unlocked"> for the mayor</span>';
		
	document.getElementById('explanation').innerHTML=valhtml;
}

function PutPhoneHtml3(val)
{
	//document.getElementById('offer_same').value=val;
	//document.getElementById('offer').value=val;
	document.getElementById('description').innerHTML='<span class="deal">'+val+'</span>';
}

function PutPhoneHtml4(val)
{
	document.getElementById('fineprint').innerHTML=val;
}


/*function SaveData(userid)
{
	VerifyDate();
	
	if(document.getElementById('groups'))
		var group_ids = document.getElementById('groups').value;
	
	if(document.getElementById('pages'))
		var page_id = document.getElementById('pages').value;
	
	var start_date = document.getElementById('start_date').value;
	var start_time = document.getElementById('start_time').value;
	var end_date = document.getElementById('end_date').value;
	var end_time = document.getElementById('end_time').value;
	var timezone = document.getElementById('timezone').value;
	var name = document.getElementById('campaign_name').value;
	var kpi = document.getElementById('kpi').value;
	
	if(document.getElementById('facebook_deals').checked == true)
		var facebook_deals = 'yes';
	else
		var facebook_deals = 'no';
		
	if(document.getElementById('fs_specials').checked == true)
	{
		var foursquare_specials = 'yes';
		
		if(document.getElementById('swarm').checked)
		{
			var sp_type= 'swarm';
			
			var count1 = document.getElementById('swarm_people').value;
			var count2 = document.getElementById('swarm_days').value;
			
			var unlockedText='When '+ count1 +' people are checked in at once with a maximum of '+ count2 +' unlocks per day.';
			
		}
		
		if(document.getElementById('friend').checked)
		{
			var sp_type= 'friend';
			
			if(document.getElementById('friend_people').value)
				var count1 = document.getElementById('friend_people').value;
			
			var unlockedText='When '+ count1 +' friends check in together.';
		}
		
		if(document.getElementById('flash').checked)
		{
			var sp_type= 'flash';
			
			var count1 = document.getElementById('flash_people').value;
			var count2 = document.getElementById('flash_time1').value;
			var count3 = document.getElementById('flash_time2').value;	
			
			var unlockedText='When a customer is one of the first '+ count1 +' people to check in between '+ count2 +'  and '+ count3 +' .';
		}
		
		if(document.getElementById('newbie').checked)
		{
			var sp_type= 'newbie';
			
			if(document.getElementById('any_venue').checked==true)
				var unlockedText ='When a user checks in for the first time at any venue.';
			else if(document.getElementById('each_venue').checked==true)
				var unlockedText='When a user checks in for the first time at each venue.';
		}
		
		if(document.getElementById('checkin').checked)
		{
			var sp_type = 'checkin';
			var unlockedText ='When anyone checks in.';
		}
		
		if(document.getElementById('loyalty').checked)
		{
			var sp_type= 'loyalty';
			
			var unlockedText = '';
			
			if(document.getElementById('loyalty_check1').checked == true)
			{
				var count1 = document.getElementById('loyalty_opt1').value;
				unlockedText +='Every '+ count1 +' check-ins';
			}
			
			else if(document.getElementById('loyalty_check2').checked == true)
			{
				var count1 = document.getElementById('loyalty_opt2').value;
				unlockedText +='When a customer checks in exactly '+ count1 +' times';
			}
			
			else if(document.getElementById('loyalty_check3').checked == true)
			{
				var count1 = document.getElementById('loyalty_opt3').value;
				var count3 = document.getElementById('loyalty_opt4').value;
				
				unlockedText +='When a customer has checked in '+ count1 +' or more times in the last '+ count3 +' days.';
			}
			
			unlockedText +=' Progress towards unlocking the special counts check-ins:';
			
			if(document.getElementById('loaylty_each_venue').checked == true)
				unlockedText +=' At each venue separately';
			else if(document.getElementById('loaylty_all_venue').checked == true)
				unlockedText +=' Across all venues together';
		}
		
		if(document.getElementById('mayor').checked)
		{
			var sp_type= 'mayor';
			
			var unlockedText = 'When a customer is the mayor and checks in.';
		}	
		
		var offer = document.getElementById('offer').value;
		var finePrint = document.getElementById('rules').value;
		var cost = document.getElementById('cost').value;
		
		var querystring_fs = '&sp_type='+ sp_type +'&count1='+ count1 +'&count2='+ count2 + '&count3='+ count3 +'&unlockedText='+ unlockedText +'&offer='+ offer +'&finePrint='+ finePrint +'&cost='+ cost;
	}
	else
		var foursquare_specials = 'no';
	
	
	if(document.getElementById('google_places_chk').checked == true)
		var google_place = 'yes';
	else
		var google_place = 'no';
	
	if(document.getElementById('fbposts').checked == true)
	{
		var fb_posts = 'yes';
		
		if(document.getElementById('sel_wall'))
			var sel_wall = document.getElementById('sel_wall').value;
		else
			var sel_wall = 0;
			
		if(document.getElementById('selected_wall'))
			var selected_wall = document.getElementById('selected_wall').value;
		else
			var selected_wall = 0;
		
		var post_title = document.getElementById('fb_post_title').value;
		var message = document.getElementById('textmsg').value;
		
		if(document.getElementById('opt_nothing').checked)
			var content_type = 'text';
		else if(document.getElementById('opt_photo').checked)
			var content_type = 'photo';
		else if(document.getElementById('opt_video').checked)
			var content_type = 'video';
		
		if(document.getElementById('link_get'))
			var url_link = document.getElementById('link_get').value;
		
		if(document.getElementById('link_title'))
			var title = document.getElementById('link_title').value;
			
		if(document.getElementById('link_description'))
			var description = document.getElementById('link_description').value;
			
		var email_notify = document.getElementById('checkbox2').value;
		
		var querystring_fb = '&post_title='+ post_title +'&message='+ message +'&content_type='+ content_type +'&url_link='+ url_link +'&title='+ title +'&description='+ description +'&email_notify='+ email_notify + '&sel_wall='+ sel_wall +'&selected_wall='+ selected_wall;
		
	}
	else
		var fb_posts = 'no';
		
	if(document.getElementById('twitter').checked == true)
		var twitter = 'yes';
	else
		var twitter = 'no';
		
	if(document.getElementById('FB_ads').checked == true)
		var fb_ads = 'yes';
	else
		var fb_ads = 'no';
	
	if(document.getElementById('google_adwords').checked == true)
		var google_adwords = 'yes';
	else
		var google_adwords = 'no';
	
	var venue_type = '';
		
	if($('#sel_venue').val()!=0)
	{
		if($('#sel_venue').val()==1)	
			venue_type = 'single';
		else if($('#sel_venue').val()==2)
			venue_type = 'group';
		else if($('#sel_venue').val()==3)
			venue_type = 'all';
	}
	else
		venue_type = 0;
	
	if($('#groups').length>0)
	{
		var location_type = $('#groups').val();
	}
	else
		var location_type = 0;
		
	var querystring = 'group_ids= ' + group_ids +  '&page_id= ' + page_id + '&start_date=' + start_date + '&start_time=' + start_time + '&end_date=' + end_date + '&end_time=' + end_time + '&timezone=' + timezone + '&name=' + name + '&kpi=' + kpi + '&facebook_deals=' + facebook_deals + '&foursquare_specials=' + foursquare_specials + '&google_place=' + google_place + '&fb_posts=' + fb_posts + '&twitter=' + twitter + '&fb_ads=' + fb_ads + '&google_adwords=' + google_adwords + '&sp_type=' + sp_type +'&userid='+ userid + '&venue_type='+ venue_type + '&location_type='+ location_type;

	if(querystring_fs)
		querystring += querystring_fs;
	if(querystring_fb)
		querystring += querystring_fb;
		
	if(document.getElementById('savedid').value)
		querystring += '&savedid=' + document.getElementById('savedid').value;

	if(httpobj2)
	{		
		url_aj = '<?php echo Yii::app()->request->baseUrl; ?>/ajax/savecampaign.php?' + querystring;

		httpobj2.open("GET",url_aj,true);	
		httpobj2.onreadystatechange=function()
		{
			if(httpobj2.readyState==4 && httpobj2.status==200)
			{
				//alert(httpobj2.responseText);
				document.getElementById('savedid').value = httpobj2.responseText;
			}
		}	
		
		httpobj2.send(null);	
	}
	
	setTimeout('SaveData("<?php echo Yii::app()->user->user_id; ?>")', 10000);
}*/

//setTimeout('SaveData("<?php echo Yii::app()->user->user_id; ?>")', 10000);

function LoadCampSel(id,userid)
{
	CheckVenueSelect();

	if(id<=3)
	{	
		$('#sel_to_drop').show();
		
		$.ajax({
			type : 'POST',
			url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/load_camp_sel.php',
			dataType : 'json',
			data: 'id='+ id +'&userid='+ userid,
			success : function(data)
			{
				$('#sel_to_drop').html('');
				$('#sel_to_drop').html(data.msg);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) { alert(errorThrown); }
		});
	}
	return false;	
}


function LoadFBWall(id,userid)
{
	if(id<=3)
	{	
		$('#fbwall_options').show();
		
		$.ajax({
			type : 'POST',
			url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/load_wall_option.php',
			dataType : 'json',
			data: 'id='+ id +'&userid='+ userid,
			success : function(data)
			{
				$('#fbwall_options').html('');
				$('#fbwall_options').html(data.msg);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {}
		});
	}
	return false;	
}


function CheckForm(frm)
{
	var count = 0;
	
	if(frm.campaign_name.value=='')
	{
		$('#campaign_name_error_cntnr').show();
		$('#campaign_name_error').html("Please Enter Campaign Name.");
		
		count++;
	}
	else
	{
		$('#campaign_name_error_cntnr').hide();
		$('#campaign_name_error').html("");
	}
	
	if(frm.timezone.value=='0')
	{
		$('#timezone_error_cntnr').show();
		$('#timezone_error').html("Please Select Timezone.");
		
		count++;
	}
	else
	{
		$('#timezone_error_cntnr').hide();
		$('#timezone_error').html("");
	}
	
	if(document.getElementById('fs_specials').checked == true && document.getElementById('sel_venue').value==0)
	{
		$('#venue_error').html("select venues first to create FourSquare special.");
		
		count++;
	}
	
	var startdate = $('#start_date').val();
	var starttime = $('#start_time').val();
	var enddate = $('#end_date').val();
	var endtime = $('#end_time').val();
	var current_date = $('#current_date').val();
	
	if( startdate == '' || starttime == '' || enddate == '' || endtime == '')
	{
		$('#date_error_cntnr').show();
		$('#date_error').html('Start date/time and End date/time are coumpulsory.');
		count++;	
	}
	else
	{	
		if(startdate == enddate)
		{
			$('#date_error_cntnr').show();
			$('#date_error').html('End date should be greater than Start date.');	
			count++;		
		}
		
		else if( new Date(startdate).getTime() > new Date(enddate).getTime() )
		{
			$('#date_error_cntnr').show();
			$('#date_error').html('Start date can not be greater than End date.');
			count++;		
		}
		
		else if( startdate != current_date && new Date(startdate).getTime() < new Date())
		{
			$('#date_error_cntnr').show();
			$('#date_error').html('Start date can not be less than Current date.');	
			count++;	
		}
		
		else if( enddate != current_date &&  new Date(enddate).getTime() < new Date())
		{
			$('#date_error_cntnr').show();
			$('#date_error').html('End date can not be less than Current date.');	
			count++;	
		}
		
		else
		{
			$('#date_error_cntnr').hide();
			$('#date_error').html('');
		}
		
		/*$.ajax({
			type : 'POST',
			url : '<?php echo $this->createUrl('campaignOffer/Calculatedate'); ?>',
			data: "startdate="+startdate+"&starttime="+starttime+"&enddate="+enddate+"&endtime="+endtime,
			success : function(data)
			{
				alert(data);
				$('#date_error_cntnr').show();
				$('#date_error').html(data);
			},
			error : function(jqXHR, textStatus, errorThrown) 
			{
				alert(jqXHR.responseText);
				alert(textStatus);
				alert(errorThrown);
			}
		});*/
	}
	
	if( count > 0 )
	{
		$("html, body").animate({scrollTop: 0}, 1000);
		return false;
	}
	else
		return true;
}


</script>