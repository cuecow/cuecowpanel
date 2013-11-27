<?php if(Yii::app()->user->role=='admin') { ?>

<?php include('usermenu.php'); ?>

<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4 no-space">
	<div id="page-heading" class="clearfix">
		
		<div class="grid_2 title-crumbs">
			<div class="page-wrap">
                <h1><?php echo $PageTitle; ?></h1>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE BREADCRUMBS/TITLE -->

<div class="container_4" style="padding-top:20px;">
	<div class="grid_4" style="background:#FFF;">
		<div class="panel" style="background:#FFF; border:none;">
			<div class="content">
				<div class="content tabbed">
					<div class="tab_container">			
						<table class="styled" style="border:none;"> 
						<tbody> 
						<tr>
							<td align="left" style="border:none;">
								<?php if(!empty($error)){ ?>
									<div class="container_4 no-space push-down">
										<div class="alert-wrapper error clearfix">
											<div class="alert-text">
												<? echo $error; ?>
												<a href="#" class="close">Close</a>
											</div>
										</div>
									</div>
								<? } ?>
                                <form name="fb_benchmark" class="styled" method="post" action="">
								<div id="add">
									<fieldset>
										<div style="padding-bottom:10px;">
                                        	<label for="textField">
                                                <span class="field_title">FB URL:</span>
                                                <input type="text" name="url" class="small textbox" />
                                            </label>
                                        </div>
											
										<!-- Buttons -->
										<div class="non-label-section" id="submit_button" style="border:none;">
                                        	<input type="submit" value="Submit" class="button large green" />
                                        </div>
									</fieldset>
								</div>
                                </form>
                                
                                <?php if(!empty($_POST['url'])) { ?>
                                <table border="0" cellpadding="0" cellspacing="0" class="styled">
                                <tr>
                                	<td><b>Likes</b></td>
                                    <td><b>Checkins</b></td>
                                    <td><b>Talking about</b></td>
                                </tr>
                                <tr>
                                	<td><?php echo $likes; ?></td>
                                    <td><?php echo $checkins; ?></td>
                                    <td><?php echo $talking_about; ?></td>
                                </tr>
                                </table>
                                <?php } ?>
							</td>
						</tr>
						</tbody> 
						</table>	
					</div>
				</div>			
			</div>	
		</div>	
	</div>
</div>
<?php } else { ?>
<div class="container_4" style="padding-top:20px;">
	<div class="grid_4">
		<div class="panel">
			<h2 class="cap">Users</h2>
			<div class="content" align="center" style="color:#990000; font-size:20px; padding:150px 0px 150px 0px;">
				You are not authorized to perform this action.
			</div>
		</div>
	</div>
</div>
<?php } ?>