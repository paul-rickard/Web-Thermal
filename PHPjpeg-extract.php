<?php

/*

PHPjpegExtract based on extract-files by mjb2k -> https://github.com/mjb2k/extract-files

Usage: 

*/





function PHPjpegExtract($filename="", $fileprefix="", $outdir="", $dir="./"){
	
	// Check for NULL filename
	if($filename=="") {
		echo "Error: No Input File Specified";
		return;
	}

	// Check for NULL fileprefix
	if($fileprefix=="") {
		$fileprefix = date('U');
		
	}

	// Check for NULL outdir
	if($outdir=="") {
		$outdir = "./".$fileprefix."./";
		
	}
	
	// JPEG file structure variables
	$headers = unpack("C*", "\xC0\xC2\xC4\xDB\xE0\xE1\xE2\xE3\xE4\xE5\xE6\xE7\xE8\xE9\xFE\xDD");
	$RSTn = unpack("C*", "\xD0\xD1\xD2\xD3\xD4\xD5\xD6\xD7");
 	$MARKER = 0xFF;
 	$SOI = 0xD8;
 	$SOS = 0xDA;
 	$EOI = 0xD9;
 	$NULL = 0x00;

    $has_marker = false;
    $has_SOI = false;
    $has_SOS = false;
    $has_header = false;
    $header_size_one = 0;
    $header_size_two = 0;
 	
 	var_dump($headers);

 	// read file
 	$handle = fopen($dir.$filename, "rb");
 	$contents = fread($handle, filesize($filename));
 	fclose($handle);

 	// Convert to Hex
 	$hex = bin2hex($contents);
 	

 	
}
PHPjpegExtract("readme.html");

?>