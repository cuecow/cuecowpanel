<?php

include('simple_html_dom.php');

$url = $_REQUEST['url'];
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
foreach($html->find('img') as $element) 
{
	if((strstr($element->src,'jpg') || strstr($element->src,'gif')))
	{
		if(!strstr($element->src,'white') && !strstr($element->src,'blank') && !strstr($element->src,'transparent') && !strstr($element->src,'dot') && !strstr($element->src,'arrow'))
		{
			if(!empty($element->src) && (strstr($element->src,'.net') || strstr($element->src,'.com') || strstr($element->src,'.info') || strstr($element->src,'.org')))
				array_push($images_array,$element->src);
			else
				array_push($images_array,$url.'/'.$element->src);
		}
	}
}

?>
<span class="field_title">&nbsp;</span>
<div style="float:left; width:100%; border:#999999 1px solid; padding:10px 0px 0px 0px; margin-bottom:20px;">
	<div style="width:15%; float:left;">
		<div style="float:left; width:100%; padding-bottom:15px;" align="center">
	
		<?php
		
		$k=1;
	
		for ($i=0;$i<=count($images_array);$i++)
		{
			if($images_array[$i])
			{
				if($i==0)
					echo "<img src='".$images_array[$i]."' width='100' id='".$k."' >";
				else
					echo "<img src='".$images_array[$i]."' width='100' id='".$k."' style='display:none;' >";
			}
			
			$k++;
		}
		?>
	
		<input type="hidden" name="total_images" id="total_images" value="<?php echo $k-1;?>" />
		
		</div>
	</div>
	
	<div style="width:80%; float:left;">
		<div style="float:left; width:100%; padding-bottom:15px; display:block; cursor:pointer;" id="title_label" onclick="javascript:ChangeLabel('title_label','title_text');">
			<strong><?php  echo $url_title; ?></strong>
		</div>
		<div style="float:left; width:100%; padding-bottom:15px; display:none;" id="title_text">
			<input type="text" name="link_title" value="<?php  echo $url_title; ?>" onblur="javascript:ChangeLabel('title_text','title_label');" onkeyup="javascript:dochanges('title_label','title',this.value);" />
		</div>
		<div style="float:left; width:100%; padding-bottom:15px;">
			<?php  echo substr($url ,0,35); ?>
			<input type="hidden" name="link_get" value="<?php  echo $url; ?>" />
		</div>
		<div style="float:left; width:100%; padding-bottom:15px; display:block; cursor:pointer;" id="desc_label" onclick="javascript:ChangeLabel('desc_label','desc_text');">
			<?php  echo $description; ?>
		</div>
		<div style="float:left; width:100%; padding-bottom:15px; display:none; cursor:pointer;" id="desc_text">
			<textarea name="link_description" class="textarea" onblur="javascript:ChangeLabel('desc_text','desc_label');" onkeyup="javascript:dochanges('desc_label','desc',this.value);"><?php  echo $description; ?></textarea>
		</div>
		<div style="float:left; width:100%; padding-bottom:15px;">
			<!--<div style="float:left; width:10%;">
				<img src="/socialsuites/ajax/prev.png" id="prev" alt="" />
				<img src="/socialsuites/ajax/next.png" id="next" alt="" />
			</div>
			<div style="float:left; width:15%;">
				Total <?php echo $k-1; ?> images
			</div>-->
			<div style="float:left; width:40%;">
				<!--choose a thumbnail &nbsp;&nbsp;&nbsp; --><a href="javascript:cleardiv(2);">Close</a>
			</div>
		</div>
	</div>
</div>