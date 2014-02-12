<? $form=$this->beginWidget('CActiveForm', array('action'=>Yii::app()->request->baseUrl.'/index.php/location/location/view/Add','id'=>'location-form','htmlOptions'=>array('class'=>'styled'),'enableAjaxValidation'=>true,'focus'=>array($model,'fburl'),)); ?>
                    
<?php if(isset($_POST['Location'])){ ?>

<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <? echo $form->errorSummary($model); ?>
</div>
  
<? } ?>

<div class="clear"></div>

<div class="clearfix"></div>

<div class="span8">
    	
	<?php 
                            
    $all_groups = LocationGroup::model()->AllGroups(); 
                        
    if(count($all_groups))
    {
                        
    ?>
        <div class="field-content-44">
            <div class="login_field-content-44-left"><label><?php echo getContent('user.location.groups.label1',Yii::app()->session['language']); ?>:</label></div>
            <div class="login_field-content-44-right left-content-fld">
                <select name="group_ids[]" id="group_ids" multiple="multiple" class="outter-select-addloc-ven">
                <?php foreach($all_groups as $key) { ?>
                    <option value="<?php echo $key['group_id'] ?>"><?php echo $key['name'] ?></option>
                <?php } ?>
                </select>
            </div>
        </div>
        
        <div class="clearfix"></div>
    
    <?
    
    }
    else
    {
    
    ?>
    
    <div class="field-content-44">
        <div class="login_field-content-44-left">&nbsp;</div>
        <div class="login_field-content-44-right left-content-fld">
            <?php echo getContent('user.location.groups.alert',Yii::app()->session['language']); ?>
        </div>
    </div>
    
    <div class="clearfix"></div>
        
    <?php
    
    }
                        
    ?>
    
    <div class="field-content-44">
        <div class="login_field-content-44-left"><?php echo getContent('user.location.groups.label2',Yii::app()->session['language']); ?></div>
        <div class="login_field-content-44-right left-content-fld">
            <?php echo $form->textField($model,'name',array('style'=>'width:500px;')); ?>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    
    
    <div class="field-content-44">
        <div class="login_field-content-44-left"><?php echo getContent('user.location.groups.label3',Yii::app()->session['language']); ?></div>
        <div class="login_field-content-44-right left-content-fld">
             
			 <?php echo $form->textField($model,'fburl',array('id'=>'fburl','class'=>'textbox','style'=>'width:500px;')); ?> 
             <a href="javascript:FindRelatedUrl($('#fburl').val(),'fb');" title="Find other venues with a similar or identical URL"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-search.png" border="0" /></a>
             <p>(Hint: enter url of place instead of page url)</p>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="field-content-44 fburl-addloc-venue" id="fburlinfo"></div>
    <div class="clearfix"></div>
    
    <div class="field-content-44">
        <div class="login_field-content-44-left"><?php echo getContent('user.location.groups.label4',Yii::app()->session['language']); ?></div>
        
        <div class="login_field-content-44-right left-content-fld">
            <?php echo $form->textField($model,'fsurl',array('id'=>'fsurl','class'=>'textbox','style'=>'width:500px;')); ?>
            <a href="javascript:FindRelatedUrl($('#fsurl').val(),'fs');" title="Find other venues with a similar or identical URL"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-search.png" border="0" /></a>
            
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="field-content-44 fburl-addloc-venue" id="fsurlinfo"></div>
    <div class="clearfix"></div>
                  
    <div class="field-content-44">
        <div class="login_field-content-44-left"><?php echo getContent('user.location.groups.label5',Yii::app()->session['language']); ?></div>
        
        <div class="login_field-content-44-right left-content-fld">
            <?php echo $form->textField($model,'googleurl',array('id'=>'googleurl','class'=>'textbox','style'=>'width:500px;')); ?>
            
            <a href="javascript:FindRelatedUrl($('#googleurl').val(),'google');" title="Find other venues with a similar or identical URL"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-search.png" border="0" /></a>
            
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="field-content-44 fburl-addloc-venue" id="googleurlinfo"></div>
    <div class="clearfix"></div>
    
    <div class="field-content-44">
        <div class="login_field-content-44-left">&nbsp;</div>
        
        <div class="login_field-content-44-right left-content-fld">
            <input type="submit" value="Submit" class="btn btn-info btn-large" />
            <input type="hidden" name="site_url" id="site_url" value="<?php echo Yii::app()->request->baseUrl; ?>" />
        </div>
    </div>
    
    <div class="clearfix"></div>
  
</div>

<?php $this->endWidget(); ?>