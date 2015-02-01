<?php

/*

PHPjpegExtract based on extract-files by mjb2k -> https://github.com/mjb2k/extract-files

Usage: 

*/


class PHPjpegExtract {

	public $filename = "";
	public $inDIR = "./";
	public $outDIR = "";
	public $MARKER = 0xFF;
 	public $SOI = 0xD8;
 	public $SOS = 0xDA;
 	public $EOI = 0xD9;
 	public $NULL = 0x00;
	public $headers = array();
	Public $RSTn = array();
	public $has_marker = false;
	public $has_SOI = false;
	public $has_SOS = false;
 	public $has_header = false;
	public $header_size_one = 0;
	public $header_size_two = 0;
	

	function __construct(){
	
		$this->headers = unpack("C*", "\xC0\xC2\xC4\xDB\xE0\xE1\xE2\xE3\xE4\xE5\xE6\xE7\xE8\xE9\xFE\xDD");
		$this->RSTn = unpack("C*", "\xD0\xD1\xD2\xD3\xD4\xD5\xD6\xD7");
	
	}
	
	
	function readfilehex() {
		
		$fullLocation = $this->inDIR.$this->filename;
		$handle = fopen($fullLocation, "rb");
 		$contents = fread($handle, filesize($fullLocation));
 		fclose($handle);
		$hex = bin2hex($contents);
		return $hex;

	}

	
	
}

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