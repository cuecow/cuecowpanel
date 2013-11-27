<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Jquery Date and Time Picker</title>
<link rel="stylesheet" type="text/css" href="anytime.css" />
<script src="jquery-1.6.4.min.js" type="text/javascript" language="javascript"></script>
<script src="anytime.js" type="text/javascript" language="javascript"></script>

<style type="text/css">
  #field2 { background-image:url("clock.png");
    background-position:right center; background-repeat:no-repeat;
    border:1px solid #FFC030;color:#3090C0;font-weight:bold}
  #AnyTime--field2 {background-color:#EFEFEF;border:1px solid #CCC}
  #AnyTime--field2 * {font-weight:bold}
  #AnyTime--field2 .AnyTime-btn {background-color:#F9F9FC;
    border:1px solid #CCC;color:#3090C0}
  #AnyTime--field2 .AnyTime-cur-btn {background-color:#FCF9F6;
      border:1px solid #FFC030;color:#FFC030}
  #AnyTime--field2 .AnyTime-focus-btn {border-style:dotted}
  #AnyTime--field2 .AnyTime-lbl {color:black}
  #AnyTime--field2 .AnyTime-hdr {background-color:#FFC030;color:white}
</style>
</head>

<body>
Date : <input type="text" id="field1" size="50" value="" /><br/>
Time : <input type="text" id="field2" value="" />

<script>
  AnyTime.picker( "field1",
    { format: "%m/%d/%z", firstDOW: 1 } );
  $("#field2").AnyTime_picker(
    { format: "%H:%i", labelTitle: "Hour",
      labelHour: "Hour", labelMinute: "Minute" } );
</script>

</body>
</html>
