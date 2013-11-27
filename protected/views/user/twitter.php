<div class="clearfix"></div>
<div class="container container-top">
    <div class="row-fluid" style="min-height:400px;">
		
        <?php if($show_form) { ?>
        <form method="post" action="" name="twitter_form" id="twitter_form">
        
        <?php if( $msg != '' ) { ?>
		<div class="alert alert-<?php if( $error == 0 ) echo 'success'; else echo 'error'; ?>">
    		<button type="button" class="close" data-dismiss="alert">&times;</button>
    		<?php echo $msg; ?>
		</div>
	    <?php } ?>
        
        <div class="field-content-44">
            <div class="login_field-content-44-left" style="width:100px;"><label>Enter Message:</label></div>
            
            <div class="field-content-44-right left-content-fld" style="border:none;">
                <textarea name="textmsg" id="textmsg" class="textarea" onkeypress="GetUrlVals(this.value,event);" style="width:615px; height:100px;"><?php if( $error == 1 ) echo $_POST['textmsg'] ?></textarea>
            </div>
            
        </div>
        <div class="clearfix"></div>
                
        <div class="field-content-44" id="submit_button" style="padding-top:30px;">
        	<div class="login_field-content-44-left" style="width:100px;">&nbsp;</div>
            <div class="field-content-44-right left-content-fld" style="border:none;">
                <input type="submit" value="Submit" class="btn" />
                <input type="hidden" name="twitter_submit" value="done" />
            </div>
        </div>
        <div class="clearfix"></div>       
        </form>
        <?php } else { ?>
        <div class="alert alert-error">
    		Please authenticate us first to post on twitter.
		</div>
        <?php } ?>
    </div>    
</div>