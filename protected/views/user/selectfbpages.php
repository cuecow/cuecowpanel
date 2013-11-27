
<!-- BEGIN SUBNAVIGATION -->
<div class="container_4 no-space">
	<div id="subpages" class="clearfix">
		<div class="grid_4">
			<div class="subpage-wrap">
				<ul>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/post"><?php echo PageTitles::model()->SinglePageTitle('/user/facebook','post'); ?></a></li>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/fbposts"><?php echo PageTitles::model()->SinglePageTitle('/user/facebook','fbposts'); ?></a></li>
                    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/Manage"><?php echo PageTitles::model()->SinglePageTitle('/user/facebook','Manage'); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- END SUBNAVIGATION -->

<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4 no-space">
	<div id="page-heading" class="clearfix">
		
		<div class="grid_2 title-crumbs">
			<div class="page-wrap">
				
                <h2>Select your facebook pages to manage on cuecow</h2>
				
			</div>
		</div>
	</div>
</div>
<!-- END PAGE BREADCRUMBS/TITLE -->

<?php if($err_msg!='') { ?>
<div class="container_4 no-space push-down">
    <div class="alert-wrapper error clearfix">
        <div class="alert-text">
            <?php echo $err_msg; ?>
            <a href="#" class="close">Close</a>
        </div>
    </div>
</div>
<?php } ?>

<div class="container_4" style="padding-top:20px;">
	<div class="grid_4">
		<div class="panel">
			
            <h2 class="cap">Select Facebook pages</h2>
			
			<div class="content">
			
				<div class="content tabbed">
					<div class="tab_container">
					
						<table class="styled" style="border:none;" width="100%"> 
						<tbody> 
						<tr>
							<td align="left" style="border:none;" width="100%">
								
                                <?php if($show_message == 'no') { ?>
								<form name="fbpages_form" method="post" action="">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                	<td width="3%" style="border:0px;"></td>
                                    <td width="17%" style="border:0px;"></td>
                                    <td width="3%" style="border:0px;"></td>
                                    <td width="17%" style="border:0px;"></td>
                                    <td width="3%" style="border:0px;"></td>
                                    <td width="17%" style="border:0px;"></td>
                                    <td width="3%" style="border:0px;"></td>
                                    <td width="17%" style="border:0px;"></td>
                                    <td width="3%" style="border:0px;"></td>
                                    <td width="17%" style="border:0px;"></td>
                                </tr>
                                <?php if(count($allpages)) { ?>
                                <tr>
                                <?php 
								
								$e = 1; 
								foreach($allpages as $pages) 
								{ 
								
								?>
                                	<td style="border:0px;"><input type="checkbox" name="fbpages[]" value="<?php echo $pages['id']; ?>" <?php if($pages['status']=='active') echo 'checked'; ?> /></td>
                                    <td style="border:0px;"><?php echo $pages['page_name']; ?></td>
                                <?php 
								
								if($e%5==0)
									echo '</tr><tr>';
								
								$e++; 
								} 
								
								?>
                                </tr>
                                <tr>
                                	<td colspan="10" style="border:0px; padding-top:15px;" align="left">
                                    	<input type="submit" name="submit" value="Submit" class="button large blue" />
                                    </td>
                                </tr>
								<?php } ?>
                                
                                </table>
                                </form>
								<?php } else { ?>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                	<td style="border:0px;">
                                    	<div class="container_4 no-space push-down">
                                            <div class="alert-wrapper error clearfix">
                                                <div class="alert-text">
                                                    You can not set your facebook pages again. Please contact site administrator.
                                                    <a href="#" class="close">Close</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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
