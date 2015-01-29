<?php





//Get Contents of Directory
$dir    = './ir_reports';
$files = scandir($dir);


//Open All files and process images
$f = 2;
while ($f <= sizeof($files)) {

	//file name excluding .is2
	$file_name = explode(".",$files[$f]);
	$file_name = $file_name[0];

	//file_tmo becomes actual file name with directory
	$file_tmp = $dir."/".$files[$f];
	$f++;

   // read file
   $handle = fopen($file_tmp, "rb");
   $contents = fread($handle, filesize($file_tmp));
   fclose($handle);


   // Convert to Hex
   $hex = bin2hex($contents);


   // Filter For Images
   $result = explode("ffd8ffe0", $hex);

   $i=1;
   $array_elements = (count($result) - 1);

   while ( $i <= $array_elements) {
	  $img="ffd8ffe0".$result[$i];
	  file_put_contents($dir."/".$file_name."-".$i.".jpg", pack("H*" , $img));
	  $i++;
   }

}

//Filter for IR
$ir_scale_factor = 0.015625;
$ir = substr($contents, 827, 19200);
print_r($ir);

// Create Rectangular gradient temp scale here.

/* 
bool image_gradientrect(resource $image, int $x1, int $y1, int $x2, int $y2, string $HexColorCodeStart, string $HexColorCodeEnd);
*/
function image_gradientrect($img,$x,$y,$x1,$y1,$start,$end) {
   if($x > $x1 || $y > $y1) {
      return false;
   }
   
   $s = array(
      hexdec(substr($start,0,2)),
      hexdec(substr($start,2,2)),
      hexdec(substr($start,4,2))
   );
   
   $e = array(
      hexdec(substr($end,0,2)),
      hexdec(substr($end,2,2)),
      hexdec(substr($end,4,2))
   );
   
   $steps = $y1 - $y;
   for($i = 0; $i < $steps; $i++) {
      $r = $s[0] - ((($s[0]-$e[0])/$steps)*$i);
      $g = $s[1] - ((($s[1]-$e[1])/$steps)*$i);
      $b = $s[2] - ((($s[2]-$e[2])/$steps)*$i);
      $color = imagecolorallocate($img,$r,$g,$b);
      imagefilledrectangle($img,$x,$y+$i,$x1,$y+$i+1,$color);
   }
   
   return true;
}




//Create Temperature gradient scale

$imgWidth = 50;
$imgHeight = 300;
$img = imagecreatetruecolor($imgWidth,$imgHeight);

image_gradientrect($img,10,0,$imgWidth,$imgHeight,'ff0000','0000ff');
/* Show In Browser as Image */
header('Content-Type: image/png');
imagepng($img);

/* Save as a File */
imagepng($img,'save.png');

/* Some Cleanup */
imagedestroy($img);








?>