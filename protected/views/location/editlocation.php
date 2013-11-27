<div class="container container-top">

	<div class="row-fluid">
		<?php
                                    
        $form=$this->beginWidget('CActiveForm', array('id'=>'location-form','htmlOptions'=>array('class'=>'styled'),'enableAjaxValidation'=>true,)); 
                                    
        if(isset($_POST['Location']))
        { 
        ?>	
                                        
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <? echo $form->errorSummary($model); ?>
        </div>
                                    
        <? } ?>
        
        <div class="clear"></div>
        
        <div class="clearfix"></div>
        
        <div class="span6" style="width:900px;">
        
        <?php 
                                        
        if(!empty($model->group_ids))
            $temp_hold = explode(',',$model->group_ids);
                                            
        $all_groups = LocationGroup::model()->AllGroups(); 
                                        
        if(count($all_groups))
        {
        ?>
            <div class="field-content-44">
                <div class="login_field-content-44-left"><label>Select Groups:</label></div>
                <div class="login_field-content-44-right left-content-fld">
                    <select name="group_ids[]" id="group_ids" multiple="multiple" style="color:#333333; padding:10px; width:300px;">
                    <?php foreach($all_groups as $key=>$value) { ?>
                        <option value="<?php echo $value['group_id'] ?>" <?php if(count($temp_hold)>0 && in_array($value['group_id'],$temp_hold)) echo 'selected'; ?>><?php echo $value['name'] ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="clearfix"></div>
                                        
            <? } ?>
        
            <input type="hidden" name="prev_group" value="<?php echo $model->group_ids; ?>" />
            
            <div class="field-content-44">
                <div class="login_field-content-44-left"><label>Enter Location Name:</label></div>
                <div class="login_field-content-44-right left-content-fld">
                    <?php echo $form->textField($model,'name',array('class'=>'textbox','style'=>'width:300px;')); ?>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="field-content-44">
                <div class="login_field-content-44-left"><label>Enter FB url:</label></div>
                <div class="login_field-content-44-right left-content-fld">
                    <?php echo $form->textField($model,'fburl',array('id'=>'fburl','class'=>'textbox','style'=>'width:300px;')); ?>
                
                    <a href="javascript:FindRelatedUrl($('#fburl').val(),'fb');" title="Find other venues with a similar or identical URL"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-search.png" /></a>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="field-content-44" id="fburlinfo" style="margin:0px 0px 20px 290px; display:none;"></div>
    		<div class="clearfix"></div>
    
            <div class="field-content-44">
                <div class="login_field-content-44-left"><label>Enter Foursquare url:</label></div>
                <div class="login_field-content-44-right left-content-fld">
                    <?php echo $form->textField($model,'fsurl',array('id'=>'fsurl','class'=>'textbox','style'=>'width:300px;')); ?>
                    <a href="javascript:FindRelatedUrl($('#fsurl').val(),'fs');" title="Find other venues with a similar or identical URL"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-search.png" /></a>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="field-content-44" id="fsurlinfo" style="margin:0px 0px 20px 290px; display:none;"></div>
    		<div class="clearfix"></div>
    
            <div class="field-content-44">
                <div class="login_field-content-44-left"><label>Enter Google url:</label></div>
                <div class="login_field-content-44-right left-content-fld">
                    
                    <?php echo $form->textField($model,'googleurl',array('id'=>'googleurl','class'=>'textbox','style'=>'width:300px;')); ?>
                    
                    <a href="javascript:FindRelatedUrl($('#googleurl').val(),'google');" title="Find other venues with a similar or identical URL"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-search.png" /></a>
                    
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="field-content-44" id="googleurlinfo" style="margin:0px 0px 20px 290px; display:none;"></div>
		    <div class="clearfix"></div>
            
            <div class="field-content-44">
                <div class="login_field-content-44-left">&nbsp;</div>
                
                <div class="login_field-content-44-right left-content-fld">
                    <input type="hidden" name="locid" id="locid" value="<?php echo $_REQUEST['id']; ?>" />
                    <input type="hidden" name="site_url" id="site_url" value="<?php echo Yii::app()->request->baseUrl; ?>" />
                    <input type="submit" value="Submit" class="btn btn-info btn-large" />
                </div>
            </div>
            
            <div class="clearfix"></div>
            
        </div>	
        
        <?php $this->endWidget(); ?>
        
	</div>
    
</div>    
