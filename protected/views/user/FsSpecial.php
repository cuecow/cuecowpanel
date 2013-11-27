<div id="foursquare_specials" style="display:none;">
	<div class="panel">
	<h2 class="cap">Foursquare Specials : </h2>
		<div class="content">
			<table id="tablesorter-sample" class="tablesorter styled" border="0" cellpadding="0" cellspacing="1">
			<thead>
			<tr>
				<th width="73%">&nbsp;</th>
				<th width="27%"><strong>Preview your Special</strong></th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>
					<div class="accordion-wrapper">
	
						<div class="accordion-block nope" id="acc1">
							<h4>1. What kind of special do you want?</h4>
							<div class="accordion-content" style="display:block;">
								<table class="styled">
								<tr>
									<td colspan="3" style="border:none;"><b>Attract New Customers</b></td>
								</tr>
								<tr>
									<td width="5%" style="border:none;">
										<input type="radio" name="sp_type" value="swarm" checked="checked" id="swarm" onClick="ChangeTitle('swarm_unlocked','Swarm');" />
									</td>
									<td width="75%" style="border:none;">
										<b>Swarm Special</b><br />Like, "If 30 people check in at once, get 25 cent wings"
									</td>
									<td width="20%" style="border:none;" align="center">
										<img src="https://static-s.foursquare.com/img/specials/swarm_off-7080cd53395313dedb316b6c7098c130.png" />
									</td>
								</tr>
								<tr>
									<td style="border:none;"><input type="radio" name="sp_type" value="friend" id="friend" onClick="ChangeTitle('friends_unlocked','Friends');" /></td>
									<td style="border:none;">
										<b>Friend Special</b><br />Like, "Check in with 3 friends and get a free dessert"
									</td>
									<td style="border:none;" align="center">
										<img src="https://static-s.foursquare.com/img/specials/friends_off-4132f2fdefc2eedc1d509fccb19a973b.png" />
									</td>
								</tr>
								<tr>
									<td style="border:none;"><input type="radio" name="sp_type" value="flash" id="flash" onClick="ChangeTitle('flash_unlocked','Flash');" /></td>
									<td style="border:none;">
										<b>Flash Special</b><br />Like, "The first 10 people that check in after 8pm get 25% off their order"
									</td>
									<td style="border:none;" align="center">
										<img src="https://static-s.foursquare.com/img/specials/flash_off-10878cb6f3228d991866b78d62acccfd.png" />
									</td>
								</tr>
								<tr>
									<td style="border:none;"><input type="radio" name="sp_type" value="newbie" id="newbie" onClick="ChangeTitle('newbie_unlocked','Newbie');" /></td>
									<td style="border:none;">
										<b>Newbie Special</b><br />Like, "Get a free cupcake on your first check-in"
									</td>
									<td style="border:none;" align="center">
										<img src="https://static-s.foursquare.com/img/specials/newbie_off-5a7b29b4a2631e97a86a50317b6c07ab.png" />
									</td>
								</tr>
								<tr>
									<td style="border:none;"><input type="radio" name="sp_type" value="checkin" id="checkin" onClick="ChangeTitle('check-in_unlocked','Check-in');" /></td>
									<td style="border:none;">
										<b>Check-in Special</b><br />Like, "Get a free appetizer when you check in"
									</td>
									<td style="border:none;" align="center">
										<img src="https://static-s.foursquare.com/img/specials/check-in_off-4e758dabb5f6d3711296cee84f28872b.png" />
									</td>
								</tr>
								<tr>
									<td colspan="3" style="border:none;"><b>Reward Existing Customers</b></td>
								</tr>
								<tr>
									<td style="border:none;"><input type="radio" name="sp_type" value="loyalty" id="loyalty" onClick="ChangeTitle('frequency_unlocked','Loyalty');" /></td>
									<td style="border:none;">
										<b>Loyalty Special</b><br />Like, "Get a free cookie every 3rd check-in"
									</td>
									<td style="border:none;" align="center">
										<img src="https://static-s.foursquare.com/img/specials/frequency_off-2f447c8e77cfc78b73df7c7e636d77d1.png" />
									</td>
								</tr>
								<tr>
									<td style="border:none;"><input type="radio" name="sp_type" value="mayor" id="mayor" onClick="ChangeTitle('mayor_unlocked','Mayor');" /></td>
									<td style="border:none;">
										<b>Mayor Special</b><br />Like, "Mayor gets 20% off their entire bill"
									</td>
									<td style="border:none;" align="center">
										<img src="https://static-s.foursquare.com/img/specials/mayor_off-c2213276cd5d2919a1d0b5d45c143ca7.png" />
									</td>
								</tr>
								<tr>
									<td style="border:none;"></td>
									<td style="border:none;" colspan="2" align="left" class="fake">
										<h2 style="cursor:pointer;" onclick="javascript:PutStep2();">Next</h2> 
									</td>
								</tr>
								</table>
							</div>
						</div>
	
						<div class="accordion-block" id="acc2">
							<h4>2. When does the special get unlocked? </h4> 
							<div class="accordion-content">
								<table class="styled">
								<tr>
									<td style="border:none;" id="part2">
										When &nbsp;&nbsp;<input type="text" class="small_txtbx" />&nbsp;&nbsp; people are checked in at once with a maximum of &nbsp;&nbsp;<input type="text" class="small_txtbx" />&nbsp;&nbsp;  unlocks per day.
									</td>
								</tr>
								<tr>
									<td style="border:none;" align="left" class="fake2">
										<h2 style="cursor:pointer;">Next</h2> 
									</td>
								</tr>
								</table>
							</div>
						</div>
	
						<div class="accordion-block" id="acc3">
							<h4>3. What is the offer?</h4>
							<div class="accordion-content">
								<table class="styled">
								<tr>
									<td style="border:none;" id="part3">
										Offer Description<br /><br />
										The offer the customer sees when they view your special.<br /><br />
										
										<textarea name="offer" id="offer" onKeyUp="javascript:PutPhoneHtml3(this.value);" class="small_txtarea"></textarea>
										
									</td>
								</tr>
								<tr>
									<td style="border:none;" align="left" class="fake3">
										<h2 style="cursor:pointer;">Next</h2> 
									</td>
								</tr>
								</table>
							</div>
						</div>
						
						<div class="accordion-block" id="acc4">
							<h4>4. Advanced features (optional)</h4>
							<div class="accordion-content">
								<table class="styled">
								<tr>
									<td style="border:none;" id="part4">
										Custom Unlocked Offer Description <br /><br />
										Describe what the customer will receive, including any details that should only be viewed by users that unlock the special.<br /><br />
										<textarea id="offer_same" name="offer_same" onKeyUp="javascript:PutPhoneHtml3(this.value);" class="small_txtarea"></textarea><br /><br />
	
										Fine Print<br /><br />
										Add any additional rules or conditions the customer should understand. (No HTML tags or links, please)
										<textarea name="rules" id="rules" onKeyUp="javascript:PutPhoneHtml4(this.value);" class="small_txtarea"></textarea><br /><br />
										
									</td>
								</tr>
								<tr>
									<td style="border:none;" align="left" class="fake4">
										<a class="button medium green">Finish</a>
									</td>
								</tr>
								</table>
							</div>
						</div>
						
					</div>
				</td>
				<td align="center" style="font-size:16px; color:#000000;">
					<div class="specials">
						<div id="createSpecial" class="specials">
							<div id="right">
								<div class="unlocked" id="preview">
									  
									<div id="previewScreen">
										
										<div id="flag">
											<div id="previewIcon">
												<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/swarm_unlocked.png" />
											</div>
											<span>Sworm Special</span>
										</div>
										
										<div id="specialContainer">
											<div class="specialContent">
												<p id="welcome">
													Welcome to Your Venue
													<span id="address"></span>
												</p>
												<p id="helpText">
													<span class="deal">Your special offer will go here to tell customers what they’ll receive</span>
												</p>
												<p id="description">
													<span class="deal"></span>
												</p>
												<p id="lockedDescription">
													<span class="deal"></span>
												</p>
											</div>
											<div id="explanation" align="left">
											  Unlocked:
											  <span class="unlocked"> for swarms of <span id="swarm_people_content">20</span> people (up to <span id="swarm_days_content">30</span> per day)</span>
											</div>
										</div>
										<div id="fineprint" align="left">
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</td>
			</tr>
			</tbody>
			</table>
		</div>
	</div>
</div>

<script>
function PutPhoneHtml2(id,val)
{
	document.getElementById(id+'_content').innerHTML=val;
}
</script>