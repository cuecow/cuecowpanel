<?php

error_reporting(E_ALL ^ E_NOTICE);
include('simple_html_dom.php');
?>
<link href="style1.css" type="text/css" rel="stylesheet" />
<link href="style2.css" type="text/css" rel="stylesheet" />
<link href="style3.css" type="text/css" rel="stylesheet" />
<?php
$html = file_get_html('http://maps.google.com/maps/place?cid=7821783855961629595');

$longlat	=	strpos($html,"sll=");

$sublonglat	=	substr($html,$longlat+4,23);

if(strstr($sublonglat,'&'))
{
	$amppos = strpos($sublonglat,'&');
	$sublonglat	=	substr($html,$longlat+4,$amppos);
}

$quotspace	=	strpos($sublonglat," ");
if($quotspace)
	$ll			=	substr($sublonglat,0,$quotspace-1);
else
	$ll			=	$sublonglat;

$expll		=	explode(",",$ll);
$lati		=	$expll[0];
$longi		=	$expll[1];

$locname = $l;

$strgoogle = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/place/search/json?location='.$lati.','.$longi.'&radius=500&name='.$locname.'&sensor=false&key=AIzaSyCjZdj2qvK8-_Dc5VKvzQtAN_7rIsJWZVM'));


$strgoogledata = json_decode(@file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?reference='.$strgoogle->results[0]->reference.'&sensor=true&key=AIzaSyCjZdj2qvK8-_Dc5VKvzQtAN_7rIsJWZVM'));

$address	=	$strgoogledata->result->formatted_address;	

?>