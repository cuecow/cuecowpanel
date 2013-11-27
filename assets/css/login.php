<?php header("Content-type: text/css"); 
$color = $_GET['color'];
?>

body { margin:20px 0; background:#<?php echo $color; ?> url('../images/body_bg.png') repeat; }