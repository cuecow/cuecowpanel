<div class="row-fluid">
		
	<?php 
	
	if($show_form) 
	{ 
		if( $msg != '' ) 
		{ 
		
	?>
    		<div class="alert alert-<?php if( $error == 0 ) echo 'success'; else echo 'error'; ?>">
        		<button type="button" class="close" data-dismiss="alert">&times;</button>
        		<?php echo $msg; ?>
    		</div>
    <?php 
	
		} 
		
	?>
    
    	<div class="field-content-44">
        	<div class="login_field-content-44-left" style="width:100px;"><label>Enter Message:</label></div>
        
	        <div class="field-content-44-right left-content-fld" style="border:none;">
    	        <textarea name="twittermsg" id="twittermsg" class="textarea" style="width:615px; height:100px;"></textarea>
        	</div>
        
	    </div>
    	<div class="clearfix"></div>
            
    <?php 
	} 
	else 
	{ 
	?>
    	<div class="alert alert-error">
        	Please authenticate us first to post on twitter.
	    </div>
    <?php 
	
	} 
	
	?>
    
</div>