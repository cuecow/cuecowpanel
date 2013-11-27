<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

<? $form=$this->beginWidget('CActiveForm', array('action'=>Yii::app()->request->baseUrl.'/index.php/location/location/view/Groups','id'=>'group-form','htmlOptions'=>array('class'=>'styled'),'enableAjaxValidation'=>true,)); ?>
                  
<?php if($_GET['err']==1) { ?>             
                	
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <? echo 'Group name can not be blank.'; ?>
</div>
                      
<?php }  ?>
    
<div class="clear"></div>
<div class="clearfix"></div>

<div class="span6" style="width:900px;">

	<?php if(empty($_REQUEST['group_id'])) { ?>
    
    <div class="field-content-44">
        <div class="login_field-content-44-left"><label><?php echo getContent('user.location.addgroup.label1',Yii::app()->session['language']); ?>:</label></div>
        <div class="login_field-content-44-right left-content-fld">
            <?php echo $form->textField($model_group,'name',array('style'=>'width:300px;')); ?>
        </div>
    </div>
    
    <div class="clearfix"></div>         
    
    <div style="float:left;">
    	
        <b><?php echo getContent('user.location.addgroup.label2',Yii::app()->session['language']); ?></b><br />
        
        <select name="itemsToChoose[]" id="left" multiple="multiple" style="padding:10px; outline:none; width:300px; height:200px;">
			<?php if(count($all_venues)) { ?>    
                <?php foreach($all_venues as $key=>$value) { ?>
                <option value="loc_<?php echo $value['loc_id']; ?>"><?php echo $value['name']; ?></option>
                <?php } 
            }
            ?>
            <?php if(count($facebook_pages)) { ?>
            <?php foreach($facebook_pages as $keys=>$values) { ?>
                <option value="fb_<?php echo $values['id']; ?>"><?php echo $values['page_name']; ?></option>
            <?php } 
            } 
            ?>
        </select>
	</div>
    
	<div style="float:left; padding-left:20px; padding-top:50px;" class="low">
        <center>
            <input name="left2right" value="add" type="button" class="btn btn-info"> <br /> <br />
            <input name="right2left" value="remove" type="button" class="btn btn-info">  
        </center>
    </div>
                              
    <div style="float:left; padding-left:20px;">
        <b><?php echo getContent('user.location.addgroup.label3',Yii::app()->session['language']); ?></b><br />
        <select name="itemsToAdd[]" id="right" multiple="multiple" style="padding:10px; outline:none; width:300px; height:200px;">
        </select>
    </div>
                          
	<?php } else {  ?>
    
    <div class="field-content-44">
        <div class="login_field-content-44-left"><label><?php echo getContent('user.location.addgroup.label4',Yii::app()->session['language']); ?>:</label></div>
        <div class="login_field-content-44-right left-content-fld">
            <?php echo $form->textField($model_group,'name',array('style'=>'width:300px;')); ?>
			<?php echo $form->hiddenField($model_group,'group_id'); ?>
            <?php echo $form->hiddenField($model_group,'userid'); ?>
        </div>
    </div>
    
    <div class="clearfix"></div>  
       
    <div style="float:left;">
        <b><?php echo getContent('user.location.addgroup.label2',Yii::app()->session['language']); ?></b><br />
        <select name="itemsToChoose[]" id="left" multiple="multiple" style="padding:10px; outline:none; width:300px; height:200px;">
            <?php if(count($all_venues)) { ?>    
            <?php foreach($all_venues as $key=>$value) { if(!in_array($value['loc_id'],$loc_array)) { ?>
            <option value="loc_<?php echo $value['loc_id']; ?>"><?php echo $value['name']; ?></option>
            <?php } } } ?>
            <?php if(count($facebook_pages)) { ?>
            <?php foreach($facebook_pages as $keys=>$values) { if(!in_array($values['id'],$pages_array)) { ?>
            <option value="fb_<?php echo $values['id']; ?>"><?php echo $values['page_name']; ?></option>
            <?php } } } ?>
        </select>
    </div>
                              
    <div style="float:left; padding-left:20px; padding-top:50px;" class="low">
        <center>
            <input name="left2right" value="add" type="button" class="btn btn-info"> <br /> <br />
            <input name="right2left" value="remove" type="button" class="btn btn-info">  
        </center>
    </div>
    
    <div style="float:left; padding-left:20px;">
        <b><?php echo getContent('user.location.addgroup.label3',Yii::app()->session['language']); ?></b><br />
        <select name="itemsToAdd[]" id="right" multiple="multiple" style="padding:10px; outline:none; width:300px; height:200px;">
        <?php if(count($loc_array)) { ?>    
            <?php foreach($loc_array as $key=>$value) { if($value) { $loca_id = LocationGroup::model()->GetSpecLocation($value); if(!empty($loca_id[0]['name'])) {  ?>
            <option value="loc_<?php echo $loca_id[0]['loc_id']; ?>" selected="selected"><?php echo $loca_id[0]['name']; ?></option>
            <?php } } } } ?>
            <?php if(count($pages_array)) { ?>
            <?php foreach($pages_array as $keys=>$values) { $pages_id = LocationGroup::model()->GetSpecPage($values); if(!empty($pages_id[0]['page_name'])) { ?>
            <option value="fb_<?php echo $pages_id[0]['id']; ?>" selected="selected"><?php echo $pages_id[0]['page_name']; ?></option>
            <?php } } } ?>
        </select>
    </div>
                          
	<?php } ?>
           
    <div class="clearfix"></div>
                   
    <div class="field-content-44"><br />
        <div class="login_field-content-44-left"><label><input type="submit" value="Submit" class="btn btn-info btn-large" onclick="SelectAllOpt();" /></label></div>
        <div class="login_field-content-44-right left-content-fld">&nbsp;</div>
    </div>
    
    <?php $this->endWidget(); ?>
    
</div>
<script>
						
$(function() 
{
	$(".low input[type='button']").click(function()
	{  
		var arr = $(this).attr("name").split("2");
		var from = arr[0];  
		var to = arr[1];  
		$("#" + from + " option:selected").each(function()
		{  
			$("#" + to).append($(this).clone().attr('selected',true));
			$(this).remove();
		});
	});
})

function SelectAllOpt()
{
	var arr = new Array;
	
	$("#right option").each  ( function() 
	{
	   $(this).attr('selected',true);
	});
}

</script>