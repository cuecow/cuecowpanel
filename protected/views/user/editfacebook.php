<!-- BEGIN SUBNAVIGATION -->
<div class="container_4 no-space">
	<div id="subpages" class="clearfix">
		<div class="grid_4">
			<div class="subpage-wrap">
				<ul>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook">List of Page(s)</a></li>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/Add">Add new Page</a></li>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/post">Manage Post(s)</a></li>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/fbposts">Add new Post</a></li>
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
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/dashboard">Home</a> / 
				
				<?php if(empty($_REQUEST['view']) || $_REQUEST['view']=='List') { ?>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/editfacebook/id/<?php echo $_REQUEST['id'];?>">Edit Page</a> <br />
				<?php } ?>
				
				<h2>Edit Facebook Page Content</h2>
				
			</div>
		</div>
	</div>
</div>
<!-- END PAGE BREADCRUMBS/TITLE -->



<!-- BEGIN FULL WIDTH ERROR BLOCK -->
<div class="container_4 no-space push-down">&nbsp;</div>
<!-- END FULL WIDTH ERROR BLOCK -->

<div class="container_4">
	<div class="grid_4">
	
		<div class="panel">
			<h2 class="cap">Facebook Page Content Management</h2>
				
			<!-- The tabs -->
			<div class="content tabbed">
				<div class="tab_container">
				
					<div style="border:#000000 0px solid; margin:50px 150px 50px 150px; width:870px;">
						
						<?php $form=$this->beginWidget('CActiveForm', array('id'=>'fbpage-form','enableClientValidation'=>true,'htmlOptions'=>array('class'=>'styled'),'clientOptions'=>array('validateOnSubmit'=>true,),)); ?>
						
						<?php if(isset($_POST['Fbpages'])){ ?>
														
							<div class="container_4 no-space push-down">
								<div class="alert-wrapper error clearfix">
									<div class="alert-text">
										<? echo $form->errorSummary($model); ?>
										<a href="#" class="close">Close</a>
									</div>
								</div>
							</div>
							
						<? } ?>

						<fieldset>
							
							<legend>Update Facebook Page</legend>
							
							<!-- Text Field -->
							<label for="textField">
								<span class="field_title">Enter FB Page Name:</span>
								<?php echo $form->textField($model,'page_name',array('class'=>'textbox','readonly'=>'readonly')); ?>
							</label>
							<label for="textField">
								<span class="field_title">Enter FB Page URL:</span>
								<?php echo $form->textField($model,'page_url',array('class'=>'textbox')); ?>
							</label>
							<label for="textField">
								<span class="field_title">Content for Public:</span>
								<?php echo $form->textArea($model,'for_public',array('id'=>'editor1','class'=>'editor','rows'=>'5','cols'=>'40')); ?> 
								<script type="text/javascript">
									CKEDITOR.replace( 'editor1', {
									extraPlugins : 'tableresize',
									toolbar : 'MyToolbar'
									});
								</script>
							</label>
							<label for="textField">
								<span class="field_title">Content for Fans:</span>
								<?php echo $form->textArea($model,'for_fan',array('id'=>'editor2','class'=>'editor','rows'=>'5','cols'=>'40')); ?> 
								<script type="text/javascript">
									CKEDITOR.replace( 'editor2', {
									extraPlugins : 'tableresize',
									toolbar : 'MyToolbar'
									});
								</script>
							</label>
							
							<!-- Buttons -->
							<div class="non-label-section"><input type="submit" value="Submit" class="button medium green float_right" /></div>

							<span><a class="button small" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook">Cancel</a></span>
						
						</fieldset>
						
						<?php $this->endWidget(); ?>

					</div>
							
				</div>
				
			</div>			
	
		</div>	
	</div>
</div>