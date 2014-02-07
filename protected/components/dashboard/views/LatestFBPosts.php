<?php 
//var_dump($records); die();
$count = count($records);
$page = $records[0]['page_id'];
//var_dump($records);
$user_curr = Yii::app()->user->user_id;

?>
<script>
    
    var refreshIntervalId;
    var refreshIntervalId2;
    var save_posts;
   // var ids = new Array();
   // var x = 0;
    <?php
    for($i=0;$i<$count;$i++)
    { ?>
        
        //ids[x] = '<?= $records[$i]['page_id']; ?>';
       // x++;
        //alert(id);
    <?php }
    ?>
       // alert(ids[0]);
        //alert(ids[1]);
        //var page = '<?= $page ?>';
        //alert(page);
            //alert(id);
            
            
    $(document).ready(function(){    
        get_all_page_posts();
        
        setInterval(refresh_page_posts, 6000);
    });
  
    function get_all_page_posts()
    {
    
        var ids = new Array();
        var ids_name = new Array();
        var x = 0;
        <?php
        for($i=0;$i<$count;$i++)
        { ?>

            ids[x] = '<?= $records[$i]['page_id']; ?>';
            ids_name[x] = '<?= $records[$i]['page_name']; ?>';
            x++;
            //alert(id);
        <?php }
        ?>
    
//        if( $("#refreshAll").is(':checked') )
//        {
//            //alert('helloooo');
//            if (refreshIntervalId == undefined)
//            refreshIntervalId = setInterval(get_fb_posts, 6000);
//
//            //alert(refreshIntervalId);
//        }
//        else{
//            window.clearInterval(refreshIntervalId);
//            refreshIntervalId = undefined;
//        }
        
    
        for (var k=0;k<ids.length;k++)
        {
            $('#p_name').empty();
            var pagem = 'Loading Posts from '+ids_name[k];
            $('#p_name').append(pagem);
            $('#wait').show();
            
            var page_id = ids[k];
    
            load_page_posts(page_id);
        }
    }
    
    
    function load_page_posts(page_id) {
        //var posts = '<?= $page ?>';
        var curr_user = '<?= $user_curr ?>';
        //alert(posts);
        //alert(curr_user);
        $.ajax({
            type : 'POST',
            url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/getPosts.php',
            dataType : 'json',

            data: 'page_id='+ page_id + '&user='+ curr_user,
            //data: 'user='+ curr_user,
            success : function(response){
                //alert('result');
                console.log(response);

                var resultdata = response['result'];
                console.log(resultdata);
                //save_posts = resultdata;
                //console.log(save_posts);
                var ids = response['pages_id'];
                //console.log(resultdata[0].acc);

                render_posts(resultdata);			
            },
            error : function(response) {
                //alert('error');
                console.log(response);             
            }
        });
    }

      
    function render_posts(resultdata)
{
    $('#post_content').empty();
                    for(var i=0;i<11;i++)
                        {
                            dataHTML = '<div id="div_msg'+resultdata[i].id+'" class="well well-small post_width" style="float:left;">';
                            dataHTML += '<div id="div_'+resultdata[i].id+'" style="display:block; background:#FFF; padding:10px;border-radius:6px ; -moz-border-radius:6px; width:95%; float:left;">';
                            dataHTML += '<div style="width:100%; border-bottom:#EEE 1px solid; float:left;">';
                            
                            dataHTML += '<div style="padding-bottom:10px; width:12%; margin-left:2%; float:left;">';
                            dataHTML += '<img src="https://graph.facebook.com/'+resultdata[i].from.id+'/picture?type=square" />';
                            dataHTML += '</div>';
                            
                            dataHTML += '<div style="width:76%; float:left;">';
                            dataHTML += '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                            
                            dataHTML += '<tr>';
                            dataHTML += '<td class="facebook_pagename">'+resultdata[i].from.name+'</td>';
                            dataHTML += '</tr>';
                            
                            if(resultdata[i].to != undefined){
                            dataHTML += '<tr>';
                            dataHTML += '<td>';
                            dataHTML += '<span class="facebook_time">'+resultdata[i].to.data[0].name+'</span>';
                            }
                            dataHTML += '</td>';
                            dataHTML += '</tr>';
                            
                            dataHTML += '<tr>';
                            dataHTML += '<td>';
                            
                            
                                
                            if(resultdata[i].created_time) 
                            {
                                //alert(resultdata[i].created_time);
                                var str = resultdata[i].created_time;
                                var temp_t1 = str.split('T');
                                var date_t = temp_t1[0];


                                if(temp_t1[1])
                                {
                                    var str1 = temp_t1[1];

                                    var temp_t2 = str1.split('+');

                                }

                                var time_t = temp_t2[0];
                            }

                            
                            dataHTML += '<span class="facebook_time">'+date_t+' at '+time_t+'';

                            if(resultdata[i].application)
                                {
                                dataHTML += ' via ' + resultdata[i].application.name;
                                }
                            dataHTML += '</span>';
                            
                            
                            
                            dataHTML += '</td>';
                            dataHTML += '</tr>';
                            
                            
                            
                            dataHTML += '</table>';
                            dataHTML += '</div>';
                            
                            dataHTML += '</div>'; //3rd div
                            
                            //post msg
                            dataHTML += '<div style="float:left; width:100%; padding-top:5px;">';
                            dataHTML += '<span class="facebook_message">';
                            dataHTML += resultdata[i].message;
                            dataHTML += '</span>';
                            dataHTML += '</div>';
                            
                            //if post has pic
                            dataHTML += '<div class="facebook_picture">';
                            if(resultdata[i].picture) {
                            dataHTML += '<div class="facebook_image"><img src="'+resultdata[i].picture+'" /></div>';
                            } 
                            dataHTML += '</div>';
                            
                            dataHTML += '</div>'; //2nd div
                            
                            dataHTML += '<div style="margin:-9px; float:left; width:103.4%; margin-top:15px; border-top:#EEE 1px solid;" id="comments_box_<?php echo $values->id; ?>">';
                            dataHTML += '<div style="width:98%; padding:10px 0px 10px 20px; border:#000 0px solid;">';
                            dataHTML += '<div class="cmnt_position">';
                            var str = resultdata[i].id;
                            var temp_t1 = str.split('_');

                            var cmnt_img = temp_t1[0];

                            dataHTML += '<img src="https://graph.facebook.com/'+cmnt_img+'/picture?type=square" width="35" height="32" />  &nbsp; </div>';
                            dataHTML += '<input type="text" name="comment_'+resultdata[i].id+'" id="comment_'+resultdata[i].id+'" placeholder="Post a comment ..." onkeyup="IdentifyMe(event,\''+resultdata[i].id+'\',\''+resultdata[i].acc+'\');" class="post-field-text" />';
                            dataHTML += '</div>';
                            dataHTML += '</div>';
                            
                            dataHTML += '</div>';
                            $('#wait').hide();
                            $('#p_name').empty();
                            $('#post_content').append(dataHTML);
                        }
}


function refresh_page_posts()
{
    var als = new Array();
    var allVals;
//    if($(".chkbx").is(':checked'))
//    {
        allVals = $("input[type=checkbox]:checked").map(
                            function () { return this.value; }
                        ).get();
     
        allVals = allVals.toString();        
        als = allVals.split(',');
//    }

        $('#c_b input[type=checkbox]:checked').each(function() {
            console.log($(this).val());
            console.log($(this).attr("name"));
            
            $('#p_name').empty();
            var pagem = 'Loading Posts from '+$(this).attr("name");
            $('#p_name').append(pagem);
            $('#wait').show();
            //allVals.push($(this).val());
            load_page_posts($(this).val());
        });
     
//    if($("input[name=chkbx]:checked"))
//    {
//        
//        var allVals = $("input[name=chkbx]:checked").map(
//     function () {return this.value;}).get();
//     
//    allVals = allVals.toString();
//    als = allVals.split(',');
//            
//        if (refreshIntervalId == undefined)
//        refreshIntervalId = setInterval(get_fb_posts, 6000);
//    
//        //alert(refreshIntervalId);
//    }
//    else{
//        window.clearInterval(refreshIntervalId);
//        refreshIntervalId = undefined;
//    }
     
//        for (var k=0;k<als.length;k++)
//        {
//            //alert(als[k]);
//            //$('#wait').show();
//            //console.log(als[k]);
//            var page_id = als[k];                
//            //load_page_posts(page_id);
//        }
}

function update(page,name)
{
    //alert(name);
    //alert(page);
 //setInterval(update, 6000);
//    $("#choose").change(function()
//    {
//        var id=$(this).val();
//
//        alert(id);
//
//    });
//console.log(save_posts);
    //var page = $('#choose').find(":selected").val();
    //alert(conceptName);
    $('#p_name').empty();
        var pagem = 'Loading Posts from ';
        $('#p_name').append(pagem);
        $('#wait').show();
        

    var curr_user = '<?= $user_curr ?>';
    //alert(posts);
    //alert(curr_user);
    //var poo = JSON.stringify(save_posts);
    $.ajax({
		type : 'POST',
		url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/getPosts.php',
		dataType : 'json',

                //data: 'records='+ posts + '&user='+ curr_user,
                //data: 'user='+ curr_user + '&page_id='+ page + '&old_post='+ save_posts,
                data: 'user='+ curr_user + '&page_id='+ page,
		success : function(response){
                    alert('ssss');
                    //alert('result');
                    //console.log(response);
                    
                    resultdata = response['result'];
                    render_posts(resultdata);
                    save_posts = resultdata;
                    ids = response['pages_id'];
                    //console.log(resultdata[0].acc);
                    render_posts(resultdata);
                    //alert(resultdata[0].to.data[0].name);
			
		},
		error : function(response) {
                    //alert('error');
                    console.log(response);             
                }
	});
}

//function chk()
//{
//    if($("#refresh").is(':checked'))
//    {
//        alert('aaaffff');
//    }
//    else
//        alert('nootttt');
//      // checked
//    //console.log(save_posts);
//}
function IdentifyMe(eve,id,access_token)
{

	if(eve.keyCode == 13)
		PostCommentFB(id,access_token);
}

function PostCommentFB(id,accesstoken)
{
	var msg = $("#comment_"+ id).val();
	if(msg!='')
	{
		CommenttoFB(id,msg,accesstoken);	
	}
	
	$('#cnt_'+id).html('<a href="javascript:PostComment(\''+ id +'\');">Post Comment</a>');
}

function CommenttoFB(id,message,accesstoken)
{
	$('#comments_'+id).html('<tr><td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" /></td></tr>');

	$.ajax({
		type : 'POST',
		url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/postcomment.php',
		dataType : 'json',
		data: 'id='+ id + '&msg='+ message + '&accesstoken='+ accesstoken,
		success : function(data){
                    //alert('abc');
			$('#comments_'+id).html(data.msg);
			$('#comment_'+id).val('');
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});	
}

</script>							
		
        
		<div class="tab-content">
        	
            <div class="tab-pane active" id="tab1">
                <center id="wait"><p id="p_name"></p> <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" /></center>
            	
    <span id="post_content">
                

<!-- umair-->


<!--         umair-->

	<div style="float:left; width:100%;" id="more_data"></div>

                </div>
              </span>
                
            </div>
            
<!-- <input type="button" value="check posts's array" onclick="chk();"/> -->
