<?php
include('simple_html_dom.php');
?>
<link href="style1.css" type="text/css" rel="stylesheet" />
<link href="style2.css" type="text/css" rel="stylesheet" />
<link href="style3.css" type="text/css" rel="stylesheet" />
<?php
$html = file_get_html('http://maps.google.co.in/maps/place?cid=13395612007731065085');



$result=$html->find('div#pp-headline');

$result1=$html->find('div#pp-photos-container');
$result2=$html->find('span.pp-headline-item pp-headline-address');


foreach($result as $e)
{
	echo $e->innertext;
}
foreach($result1 as $e)

{
	echo $e->innertext;
}
echo '<br />==============================================<br />';

foreach($result2 as $e)

{

	echo $e->innertext;
}
?>