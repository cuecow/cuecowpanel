<?php
error_reporting(E_ALL ^ E_NOTICE);
include('simple_html_dom.php');

$url = $_REQUEST['url'];

if (strpos($url, 'http') === false) 
	$url = 'http://'.$url;
	
$string = file_get_contents($url);

/// fecth title
$title_regex = "/<title>(.+)<\/title>/i";
preg_match_all($title_regex, $string, $title, PREG_PATTERN_ORDER);

$url_title = $title[1][0];

/// fecth decription
$tags = get_meta_tags($url);


$description = $tags['description'];


$html = file_get_html($url);

$images_array=array();

if(strpos($url, 'youtube.com') === false)
{
	foreach($html->find('img') as $element) 
	{
		if((strstr($element->src,'jpg') || strstr($element->src,'gif')))
		{
			if(!strstr($element->src,'white') && !strstr($element->src,'blank') && !strstr($element->src,'transparent') && !strstr($element->src,'dot') && !strstr($element->src,'arrow'))
			{
				if(!empty($element->src) && (strstr($element->src,'.net') || strstr($element->src,'.com') || strstr($element->src,'.info') || strstr($element->src,'.org') || strstr($element->src,'.dk')))
					array_push($images_array,$element->src);
				else
					array_push($images_array,$url.'/'.$element->src);
			}
		}
	}
}
else
{
	$queryString = parse_url($url, PHP_URL_QUERY);
	parse_str($queryString, $params);
	
	if (isset($params['v'])) 
	{
    	$thumb = "http://i3.ytimg.com/vi/{$params['v']}/default.jpg";
		
		array_push($images_array,$thumb);
	}
}
?>

<style type="text/css">

.fbpreview_div
{
	float:left;
	width:70%;
	border:#B4BBCD 1px solid;
	padding:10px 0px 0px 0px;
	margin-bottom:20px;	
}

.fb_preview_div1
{
	width:20%;
	float:left;
}

.fb_preview_images
{
	float:left;
	width:100%;
	padding-bottom:15px;	
}

.fb_preview_div2
{
	width:45%;
	float:left;	
}

.fb_preview_title
{
	float:left;
	width:100%;
	display:block;
	color:#000;
	padding-bottom:2px;
	cursor:pointer;	
}

.fb_preview_link
{
	float:left;
	width:100%;
	padding-bottom:2px;
	color:#666;	
}

.fb_preview_description
{
	float:left;
	width:100%;
	padding-bottom:10px;
	display:block;
	cursor:pointer;
	color:#000;	
}

.fb_preview_div3
{
	float:left;
	width:100%;
	padding-bottom:15px;	
}

.fb_preview_arrows
{
	float:left;
	width:20%;	
}

.fb_previews_num_images
{
	float:left;
	width:15%;
	color:#000;
}

.fb_preview_choose_thumbnail
{
	float:left;
	width:40%;	
}

.fb_preview_no_thumb
{
	width:35%;
	float:left;
	padding-top:15px;
	font-size:11px;	
}

.fb_preview_close
{
	float:left;
	width:30%;
	border:#000 0px solid;
}

</style>

<span class="field_title">&nbsp;</span>
<div class="fbpreview_div">
	<div class="fb_preview_div1">
	    <div class="fb_preview_images" align="center">
	
		<?php
		
		$k=1;
		for ($i=0;$i<=count($images_array);$i++)
		{
			if($images_array[$i])
			{
				if($i==0)
					echo "<img src='".$images_array[$i]."' width='100' id='img_".$k."' alt='".$images_array[$i]."' >";
				else
					echo "<img src='".$images_array[$i]."' width='100' id='img_".$k."' alt='".$images_array[$i]."' style='display:none;' >";
					
				$k++;
			}
		}
		?>
	
		<input type="hidden" name="total_images" id="total_images" value="<?php echo $k-1;?>" />
		<input type="hidden" name="current_pic" id="current_pic" value="1" />
        <input type="hidden" name="current_pic_src" id="current_pic_src" value="<?=$images_array[0]?>" />
		</div>
        &nbsp;&nbsp;
	</div>
	
	<div class="fb_preview_div2">
		<div class="fb_preview_title" id="title_label" onclick="javascript:ChangeLabel('title_label','title_text');">
			<strong><?php  echo $url_title; ?></strong>
		</div>
		<div class="fb_preview_title" style="display:none;" id="title_text">
			<input type="text" name="link_title" value="<?php  echo $url_title; ?>" onblur="javascript:ChangeLabel('title_text','title_label');" onkeyup="javascript:dochanges('title_label','title',this.value);" />
		</div>
		<div class="fb_preview_link">
			<?php  echo substr($url ,0,35); ?>
			<input type="hidden" name="link_get" value="<?php  echo $url; ?>" />
		</div>
		<div class="fb_preview_description" id="desc_label" onclick="javascript:ChangeLabel('desc_label','desc_text');">
			<?php  echo $description; ?>
		</div>
		<div class="fb_preview_description" style="display:none; cursor:pointer;" id="desc_text">
			<textarea name="link_description" class="textarea" onblur="javascript:ChangeLabel('desc_text','desc_label');" onkeyup="javascript:dochanges('desc_label','desc',this.value);"><?php  echo $description; ?></textarea>
		</div>
        
		<div class="fb_preview_div3">
        	<div class="fb_preview_arrows">
            	<a href="javascript:decreasepic();"><img src="http://panel.cuecow.com/ajax/prev.png" id="prev" alt="" border="0" /></a>
              	<a href="javascript:increasepic();"><img src="http://panel.cuecow.com/ajax/next.png" id="next" alt="" border="0" /></a>
          	</div>
         	<div class="fb_previews_num_images" id="cur_lab_pic">1 of <?=$k-1?></div>
          	<div class="fb_preview_choose_thumbnail">choose a thumbnail</div>
          	<div style="clear:both;"></div>
          	<div class="fb_preview_no_thumb">
              <input type="checkbox" name="no_thumb" value="nothumb" style="width:10px;" onclick="thumbnail_display(this.checked)" /> &nbsp;&nbsp; No Thumbnail
          	</div>
      	</div>
                                                
	</div>
        
    <div class="fb_preview_close" align="right">
    	<a href="javascript:cleardiv(2);"><img src="http://panel.cuecow.com/images/close.png" border="0" /></a>
    </div>
        
</div>