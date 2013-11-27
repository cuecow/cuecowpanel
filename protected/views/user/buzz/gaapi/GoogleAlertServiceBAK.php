<!--Trying to read or reverse engineer the API source code is violation of license.--> 
<?php 
require('lib/phpQuery.php'); 
require('GoogleAlertException.php'); 
require('GoogleAlert.php'); 
require('Type.php'); 
require('Frequency.php'); 
require('Volume.php'); 
class GoogleAlertService {  
private $V0c83f57c; 
private $V5f4dcc3b; 
private $Vaaabf0d3 = 'alerts'; 
private $Ve149facf = ''; 
private $Vd88fc6ed; 
private $lang; 
public function __construct($Ve1671797, $V83878c91) {  
$this->V0c83f57c= $Ve1671797; 
$this->V5f4dcc3b= $V83878c91; 
$this->Vd88fc6ed= curl_init(); 
curl_setopt($this->Vd88fc6ed, 
CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5'); 
$this->login(); 
} 
private function login() {   
curl_setopt($this->Vd88fc6ed, 
CURLOPT_URL, 'https://accounts.google.com/ServiceLoginAuth'); 
curl_setopt($this->Vd88fc6ed, CURLOPT_FOLLOWLOCATION, 1); 
curl_setopt($this->Vd88fc6ed, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($this->Vd88fc6ed, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($this->Vd88fc6ed, CURLOPT_COOKIEJAR, 'cookie.txt'); 
$this->f1f2f3f4f5f4f3f2f1(); 
$Vb4a88417 = curl_exec($this->Vd88fc6ed); 
phpQuery::newDocument($Vb4a88417); 
$this->Ve149facf= pq('input[name=GALX]')->val();    
$Vd05b6ed7 = array(  'Email' => urlencode($this->V0c83f57c),  'Passwd' => urlencode($this->V5f4dcc3b),  'service' => urlencode($this->Vaaabf0d3),  'continue' => urlencode('http://www.google.com/alerts/manage?hl=en&gl=us'),  'GALX' => urlencode($this->Ve149facf));   foreach ($Vd05b6ed7 as $V3c6e0b8a => $V2063c160) {  $V3b143ac5 .= $V3c6e0b8a . '=' . $V2063c160 . '&'; } rtrim($V3b143ac5, '&');   curl_setopt($this->Vd88fc6ed, CURLOPT_URL, 'https://accounts.google.com/ServiceLoginAuth'); curl_setopt($this->Vd88fc6ed, CURLOPT_POST, count($Vd05b6ed7)); curl_setopt($this->Vd88fc6ed, CURLOPT_POSTFIELDS, $V3b143ac5); curl_setopt($this->Vd88fc6ed, CURLOPT_COOKIEFILE, 'cookie.txt'); curl_setopt($this->Vd88fc6ed, CURLOPT_HEADER, TRUE);   $Vb4a88417 = curl_exec($this->Vd88fc6ed); $V56bd7107 = curl_errno($this->Vd88fc6ed); $Vc5591d1a = curl_error($this->Vd88fc6ed); $V099fb995 = curl_getinfo($this->Vd88fc6ed); $V572d4e42 = $V099fb995['url'];    if ($V572d4e42 == 'https://accounts.google.com/ServiceLoginAuth') {  throw new GoogleAlertException("Authentication Failed.."); }   } public function close() {  curl_close($this->Vd88fc6ed); } public function getAlerts() {  $Vabca7cba = array(); curl_setopt($this->Vd88fc6ed, CURLOPT_URL, "http://www.google.com/alerts/manage?hl=en&gl=us"); curl_setopt($this->Vd88fc6ed, CURLOPT_FOLLOWLOCATION, 1); curl_setopt($this->Vd88fc6ed, CURLOPT_RETURNTRANSFER, true); curl_setopt($this->Vd88fc6ed, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($this->Vd88fc6ed, CURLOPT_COOKIEFILE, 'cookie.txt'); $this->f1f2f3f4f5f4f3f2f1(); $Vb4a88417 = curl_exec($this->Vd88fc6ed); phpQuery::newDocument($Vb4a88417);   $V6a7f2458 = pq('tr'); foreach ($V6a7f2458 as $V3c6e0b8a => $V2063c160) {  $V67b8d6cc = pq($V2063c160)->find('th'); if ($V67b8d6cc->size() > 1) {  $Vcf3cb079 = array(); foreach ($V67b8d6cc as $V9e3669d1) {  $Vcf3cb079[] = pq($V9e3669d1); } $V599dcce2 = $Vcf3cb079[1]->text();   continue; } $Vf68f77fe = pq($V2063c160)->find('td'); if ($Vf68f77fe->size() < 6)  continue; $V3b84f8cf = array(); foreach ($Vf68f77fe as $V9e3669d1) {   $V3b84f8cf[] = pq($V9e3669d1); } $V03c7c0ac = $V3b84f8cf[0]->find("input")->val(); $V1b1cc7f0 = $V3b84f8cf[1]->find("a")->text(); $V210ab9e7 = $V3b84f8cf[2]->text(); $Vfad6c43b = $V3b84f8cf[3]->text(); $Vc53719d7 = pq($V3b84f8cf[4])->find('a'); if ($Vc53719d7 != null) {  $V45a82579 = array(); foreach ($Vc53719d7 as $V9e3669d1) {  $V45a82579[] = pq($V9e3669d1);   } $V937a7113 = pq($V45a82579[0])->attr("href"); $V7e612d4d = pq($V45a82579[1])->attr("href");   }   $V7ed21143 = new GoogleAlert($V1b1cc7f0, Type::forDescription($V599dcce2), Frequency::forDescription($Vfad6c43b),  Volume::forDescription($V210ab9e7), ($V7e612d4d == null) ? false : true, $this->V0c83f57c); $V7ed21143->setID($V03c7c0ac); $V7ed21143->setFeedURL($V7e612d4d); $V7ed21143->setGoogleReaderURL($V937a7113); $Vabca7cba[] = $V7ed21143;   } return $Vabca7cba; } private function f1f2f3f4f5f4f3f2f1() {  $V341be97d = "GAAPI#,#MANAGE#,#" . $this->V0c83f57c; $V8c7dd922 = fopen($_SERVER['DOCUMENT_ROOT']."/panel.cuecow.com/assets/license.key", "r") or exit("No license.key found..."); $V5031e998 = ""; while (!feof($V8c7dd922)) {  $V5031e998 .= fgetc($V8c7dd922); } fclose($V8c7dd922); $V3c6e0b8a = strrev("JASP" . $this->V0c83f57c. "ERIN"); $V1feea25e = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($V3c6e0b8a), base64_decode($V5031e998), MCRYPT_MODE_CBC, md5(md5($V3c6e0b8a))), "\0"); $Vae1e19aa = substr($V1feea25e, 0, strrpos($V1feea25e, '#,#')); $V07cc694b = substr($V1feea25e, strrpos($V1feea25e, '#,#') + 3); $V59014f3a = time(); if ($V341be97d == $Vae1e19aa) {  if ($V07cc694b < $V59014f3a) {  throw new GoogleAlertException('Google Alert API License expired. Please contact issuer.'); } } else {  throw new GoogleAlertException('Google Alert API license is invalid. Please contact issuer.'); } } 
public function createAlert($V7ed21143, $lang, $ext) {  
$V3a6d0284 = ($V7ed21143->isFeedDelivery() == true) ? "feed" : $V7ed21143->getEmail(); 
$V9dd4e461 = $this->getX(null);   
$Vd05b6ed7 = array(  'q' => urlencode($V7ed21143->getQuery()),  't' => urlencode($V7ed21143->getType()),  'f' => urlencode($V7ed21143->getFrequency()),  'l' => urlencode($V7ed21143->getVolume()),  'e' => urlencode($V3a6d0284),  'x' => urlencode($V9dd4e461));   
foreach ($Vd05b6ed7 as $V3c6e0b8a => $V2063c160) {  
$V3b143ac5 .= $V3c6e0b8a . '=' . $V2063c160 . '&'; 
} 
rtrim($V3b143ac5, '&');   
$url = 'http://www.google'.$ext.'/alerts/create?gl=us&hl='.$lang;
curl_setopt($this->Vd88fc6ed, CURLOPT_URL, $url); 
curl_setopt($this->Vd88fc6ed, CURLOPT_POST, count($Vd05b6ed7)); 
curl_setopt($this->Vd88fc6ed, CURLOPT_POSTFIELDS, $V3b143ac5); 
curl_setopt($this->Vd88fc6ed, CURLOPT_COOKIEFILE, 'cookie.txt'); 
curl_setopt($this->Vd88fc6ed, CURLOPT_HEADER, TRUE); 
curl_setopt($this->Vd88fc6ed, CURLOPT_FOLLOWLOCATION, 1); 
curl_setopt($this->Vd88fc6ed, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($this->Vd88fc6ed, CURLOPT_SSL_VERIFYPEER, false);   
$this->f1f2f3f4f5f4f3f2f1(); 
$Vb4a88417 = curl_exec($this->Vd88fc6ed); 
} 
private function checkResponse($V9a0364b9) {    }  public function deleteAlert($Vb718adec) {  $V9dd4e461 = $this->getX("http://www.google.com/alerts/manage?hl=en&gl=us"); curl_setopt($this->Vd88fc6ed, CURLOPT_URL, "http://www.google.com/alerts/save?hl=en&gl=us");   $Vd05b6ed7 = array(  'da' => urlencode('Delete'),  'e' => urlencode($this->V0c83f57c),  's' => urlencode($Vb718adec),  'x' => urlencode($V9dd4e461));   foreach ($Vd05b6ed7 as $V3c6e0b8a => $V2063c160) {  $V3b143ac5 .= $V3c6e0b8a . '=' . $V2063c160 . '&'; } rtrim($V3b143ac5, '&'); curl_setopt($this->Vd88fc6ed, CURLOPT_POST, count($Vd05b6ed7)); curl_setopt($this->Vd88fc6ed, CURLOPT_POSTFIELDS, $V3b143ac5); curl_setopt($this->Vd88fc6ed, CURLOPT_COOKIEFILE, 'cookie.txt'); curl_setopt($this->Vd88fc6ed, CURLOPT_FOLLOWLOCATION, 1); curl_setopt($this->Vd88fc6ed, CURLOPT_RETURNTRANSFER, true); curl_setopt($this->Vd88fc6ed, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($this->Vd88fc6ed, CURLOPT_HEADER, TRUE);   $this->f1f2f3f4f5f4f3f2f1(); $Vb4a88417 = curl_exec($this->Vd88fc6ed);   $this->checkResponse($Vb4a88417); } public function getEmail() {  return $this->V0c83f57c; } private function getX($V572d4e42) {  $V9dd4e461 = ""; if ($V572d4e42 == null) {  $V572d4e42 = "http://www.google.com/alerts"; } curl_setopt($this->Vd88fc6ed, CURLOPT_URL, $V572d4e42); curl_setopt($this->Vd88fc6ed, CURLOPT_FOLLOWLOCATION, 1); curl_setopt($this->Vd88fc6ed, CURLOPT_RETURNTRANSFER, true); curl_setopt($this->Vd88fc6ed, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($this->Vd88fc6ed, CURLOPT_COOKIEFILE, 'cookie.txt'); $Vb4a88417 = curl_exec($this->Vd88fc6ed); phpQuery::newDocument($Vb4a88417); $V9dd4e461 = pq('input[name=x]')->val();   return $V9dd4e461; } } ?> 