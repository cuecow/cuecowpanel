<?php
include('simple_html_dom.php');

$html = file_get_html('http://maps.google.com/maps/place?hl=en&georestrict=input_srcid:3464879d6c89cb2c');

$result=$html->find('//span[@class="pp-headline-item pp-headline-address"]');

foreach($result as $e)
{
	echo str_replace('<span>','',str_replace('</span>','',$e->innertext));
}

?>