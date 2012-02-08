<?php
session_start();
header("Expires: Sat, 01 Jan 1990 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-type: image/gif');
$string = '';
$fileRand = md5(rand(100000,999999));
$string_a = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","R","S","T","U","V","W","X","Y","Z","2","3","4","5","6","7","8","9");
$font_path = "../fonts/";
$dir = opendir($font_path);
$font_array = array ();
while ($filename = readdir($dir))
{
	if ($filename != "." && $filename != "..")
		$font_array[] = $filename;
}
$keys = array_rand($string_a, 6);
foreach($keys as $n => $v)
{
   $string .= $string_a[$v];
}
$_SESSION['code'] = $string;
$im=imagecreate(120,30);
imagecolorallocate($im, rand(200,255), rand(200,255), rand(200,255));
for ($i=0; $i < 6; $i++)
{
	$color = imagecolorallocate($im, rand(0,100), rand(0,100), rand(0,100));
	$angle = rand(-15,15);
	$font = $font_path.$font_array[rand(1,count($font_array)) - 1];
	$text = $string[$i];
	imagettftext($im, 13, $angle, 3+($i * 20), 23, $color, $font, $text);
}
imagegif($im);
imagedestroy($im);
?>