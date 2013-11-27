<?php Yii::app()->session['language'] = 2; ?>

<span class="loading" style="display:none;">Loading</span>

<input type="hidden" id="userid" value="<?php echo Yii::app()->user->user_id; ?>"/>

<div class="container container-top">
	<div class="row-fluid">
    
    <form name="categories" action="" id="filter" method="POST">
	<table class="table table-striped">
    <tr>
        <td width="12%"><?php echo getContent('user.buzz.selectlang',Yii::app()->session['language']); ?>:</td>
        <td width="20%">
            <select id="lang" name="language" class="pagesize" style="width:80%;">
                <option value="">All Languages</option>
                <option value="en">English</option>
                <option value="da">Danish</option>
            </select>
        </td>
        <td width="10%"><?php echo getContent('user.buzz.selectsource',Yii::app()->session['language']); ?>:</td>
        <td width="37%">
            <select id="source" name="source" class="pagesize" style="width:80%">
            <?php
            
            foreach($sources as $row) 
            {
            
            ?>
                <option value="<?php echo $row['source_value'];?>" <?php if($_POST['source']==$row['source_value']){ echo 'selected="selected"';}?>>
                    <?php echo $row['source_title'];?>
                </option>
            <?php
            }
            ?>
            </select>
        </td>
        <td width="21%">
        	<a href="#myModalKeywords" data-toggle="modal"><button class="btn" type="button"><?php echo getContent('user.buzz.editbrand',Yii::app()->session['language']); ?></button></a>
		</td>
    </tr>
    </table>

    <div class="clear"></div>
	<div class="clearfix"></div>
    
    <h4><?php echo getContent('user.buzz.categories',Yii::app()->session['language']); ?></h4>
	<table class="table" width="100%">
    <tr>
        <td>
            <label for="cat0" class="check"><input type="checkbox" name="category" value="10" class="cat" id="cat0" <?php if($_POST['category'] || (is_array($categories) && in_array('category=10',$categories))){ echo 'checked';}?>> &nbsp; <?php echo getContent('user.buzz.any',Yii::app()->session['language']); ?></label>
        </td>
        <td>
            <label for="cat1" class="check"><input type="checkbox" name="category1" value="1" class="cat" id="cat1" <?php if($_POST['category1'] || (is_array($categories) && in_array('category1=1',$categories))){ echo 'checked';}?>> &nbsp; <?php echo getContent('user.buzz.brand',Yii::app()->session['language']); ?></label>
        </td>
        <td>
            <label for="cat2" class="check"><input type="checkbox" name="category2" value="2" class="cat" id="cat2" <?php if($_POST['category2'] || (is_array($categories) && in_array('category2=2',$categories))){ echo 'checked';}?>> &nbsp; <?php echo getContent('user.buzz.product',Yii::app()->session['language']); ?></label>
        </td>
        <td>
            <label for="cat3" class="check"><input type="checkbox" name="category3" value="3" class="cat" id="cat3" <?php if($_POST['category3'] || (is_array($categories) && in_array('category3=3',$categories))){ echo 'checked';}?>> &nbsp; <?php echo getContent('user.buzz.person',Yii::app()->session['language']); ?></label>
        </td>
        <td>
            <label for="cat4" class="check"><input type="checkbox" name="category4" value="4" class="cat" id="cat4" <?php if($_POST['category4'] || (is_array($categories) && in_array('category4=4',$categories))){ echo 'checked';}?>> &nbsp; <?php echo getContent('user.buzz.competitor',Yii::app()->session['language']); ?></label>
        </td>
        <td>
            <label for="cat5" class="check"><input type="checkbox" name="category5" value="5" class="cat" id="cat5" <?php if($_POST['category5'] || (is_array($categories) && in_array('category5=5',$categories))){ echo 'checked';}?>> &nbsp; <?php echo getContent('user.buzz.industryterm',Yii::app()->session['language']); ?></label>
        </td>
        <td align="right">
            <a href="#myModalAlert" data-toggle="modal" id="newalert"><button class="btn" type="button"><?php echo getContent('user.buzz.makenewalert',Yii::app()->session['language']); ?></button></a>
        </td>
    </tr>
    </table>
    </form>
    
    <h4><?php echo getContent('user.buzz.searchresult',Yii::app()->session['language']); ?>:</h4>
    <table width="100%">
    <tbody><tr><td id="results"><?php include('buzz/postage.php'); ?></td></tr></tbody> 
    </table>
    
    </div>
    
</div>


<div id="myModalKeywords" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:50000;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4><?php echo getContent('user.buzz.keywordmanagement',Yii::app()->session['language']); ?></h4>
  </div>
  <div class="modal-body">
    <?php include('buzz/keywords.php'); ?>
  </div>
  <div class="modal-footer">
    <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

<div id="myModalMail" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4><?php echo getContent('user.buzz.keywordmanagement',Yii::app()->session['language']); ?></h4>
  </div>
  <div class="modal-body" id="maildiv">
  	<form name="emailform" action="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/buzz" method="post">
        
        <div class="datainsert"></div>
        
        <strong><?php echo getContent('user.buzz.towhatemails',Yii::app()->session['language']); ?></strong><br />
        
        <i><?php echo getContent('user.buzz.multiplemails',Yii::app()->session['language']); ?></i>
        <div class="clear"></div>
        
        <input type="text" class="input" name="email" value="Enter email(s)" onfocus="if (this.value == 'Enter email(s)') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Enter email(s)';}"/>
        
        <div class="clear"></div>
        
        <div id="missinglink">
            <input type="hidden" name="url" value="" />
            <input type="hidden" name="body" value="" />
        </div>

    	<input type="submit" value="submit" class="btn" style="margin-top: 10px;"/>
        
  	</form>
  </div>
  <div class="modal-footer">
    <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

<div id="myModalAlert" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h4><?php echo getContent('user.buzz.newalert',Yii::app()->session['language']); ?></h4>
  	</div>
  	<div class="modal-body" id="alerts">
  		<?php include('buzz/alert.php'); ?>
  	</div>
  	<div class="modal-footer">
    	<button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Close</button>
  	</div>
</div>

