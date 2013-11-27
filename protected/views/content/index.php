<?php if(isset(Yii::app()->user->role) && Yii::app()->user->role=='admin') { ?>

<div class="container container-top">
	<div class="row-fluid">    
    
		<?php if($_REQUEST['view'] != 'Edit') { ?>
                            
		<div style="margin-left:25px; float:right; padding-bottom:50px;">
                                
        	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/content/clear"><button class="btn btn-info" type="button">Clear Content Cache</button></a>
            
		</div>
                            
        <?php } if($_REQUEST['view'] == 'Edit') { ?>
		
        <div class="span6">
    		<div class="accordion" id="accordion1">
            	<div class="accordion-group">        	
                	<div id="collapseOne" class="accordion-body collapse in">
                    	<div class="accordion-inner">
                        
							<? $form=$this->beginWidget('CActiveForm', array('action'=>Yii::app()->request->baseUrl.'/index.php/content/index','id'=>'content-form','htmlOptions'=>array('class'=>'styled'),'enableAjaxValidation'=>true,)); ?>
                            
                            <?php if(isset($_POST['Contents']) && $validate>0){ ?>
                                                                                    
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <? echo $form->errorSummary($model); ?>
                            </div>
            
                            <?php } ?>
							
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Content Id:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
                            		<?php echo $form->textField($model,'content_id',array('class'=>'small textbox','value'=>$SingleRecord[0]['content_id'],'style'=>'width:300px;')); ?>
                            	</div>
							</div>
                            
                            <div class="clearfix"></div>
                            
                            <?php 
                                    
                            foreach($all_languages as $langs) 
                            { 
                            	$get_text = $model->GetRecord($SingleRecord[0]['content_id'],$langs['lang_id']);
                                        
										
							?>
                            	<div class="field-content-44">
                                	<div class="login_field-content-44-left login">
                                    	<label>Text in <?php echo ucfirst($langs['lang_name']); ?>:</label>
                                    </div>
                                    <div class="login_field-content-44-right left-content-fld">
                                    	<textarea class="small textbox" name="content_text_<?php echo $langs['lang_id']; ?>" style="width:300px; height:100px;"><?php echo $get_text['content_text']; ?></textarea>
									</div>
								</div>
                                <div class="clearfix"></div>
                                
							<?php 
							
							} 
							
							?>
                            
                            <div class="field-content-44">
                                <div class="login_field-content-44-left login">&nbsp;</div>
                                <div class="login_field-content-44-right left-content-fld">
                                    <input type="submit" value="Submit" class="btn btn-large" />
                                    <?php echo $form->hiddenField($model,'content_id',array('value'=>$_REQUEST['content_id'])); ?>
                                </div>
                            </div>    
                            <div class="clearfix"></div>
                            
                            <?php $this->endWidget(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
        
		<?php } else { ?>
		
        <form method="post" action="">
        <table class="table" style="border:none; width:40%;">
        	<tr>
            	<td style="border:none; width:5%">Search: </td>
                <td style="border:none; width:15%;">
                	<input type="text" name="keyword" autocomplete="off" value="<?php echo $_REQUEST['keyword']; ?>" />
				</td>
                <td style="border:none; width:10%;">
                	&nbsp;&nbsp; <input type="submit" name="search" value="search" class="btn" />
				</td>
            </tr>
        </table>
        </form>
        
        <?php
		
        if(count($AllRec))
        {
            
        ?>
            
            <table class="table table-striped">
            <thead> 
            <tr> 
                <th width="7%"><strong>S. No</strong></th> 
                <th width="10%"><strong>Content Id</strong></th> 
                <th width="6%"><strong>Language</strong></th>
                <th width="67%"><strong>Text</strong></th>
                <th width="10%"><strong>Action</strong></th>
            </tr> 
            </thead> 
            <tbody>
                
            <?php 
            
            $h=1;
            foreach($AllRec as $record)
            {
            
            ?>
            <tr> 
                <td align="center"><?php echo $h; ?></td> 
                <td><?php echo $record['content_id'];?></td> 
                <td><?php echo Languages::model()->GetLanguage($record['lang_id']);?></td> 
                <td><?php echo $record['content_text'];?></td> 
                <td align="center">
                    <a class="icon-button edit" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/content/index/view/Edit/content_id/<?=$record['content_id'];?>" title="Edit Record"><i class="icon-edit"></i></a>
                    <a class="icon-button delete" href="javascript:SubmitURL('<?php echo Yii::app()->request->baseUrl; ?>/index.php/content/deletecontent/content_id/<?=$record['content_id'];?>');" title="Delete Record"><i class="icon-trash"></i></a>
                </td>
            </tr>
            
            <?php 
            
            $h++;
            
            } 
            
            ?>
                        
            </tbody> 
            </table>
            
        <?php
         
        }
        else
        {
            
        ?>
                <div class="alert alert-error">
                    <strong>No Record added yet</strong>
                </div>
        <?php
        
        }	
        
        ?>
    </div>

<?php } ?>
            	
</div>
<?php } else { ?>

<div class="alert alert-error">
	You are not authorized to perform this action.
</div>
   
<?php } ?>


<script>

function SubmitURL(url)
{
	var answer = confirm("Are you sure, you want to delete this record?")
	
	if (answer)
		window.location.href = url;
}

</script>