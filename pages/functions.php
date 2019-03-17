<?php

function imagecreatefromfile( $filename ) {
	if (file_exists($filename)) {
	switch ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ))) {
		case 'jpeg':
		case 'jpg':
			return imagecreatefromjpeg($filename);
		break;

		case 'png':
			return imagecreatefrompng($filename);
		break;
	}
}}

function delltmp(){
$lst = scandir("img");
foreach ($lst as $val){
if (preg_match('/^'.$_SESSION['auth']['id'].'tmp-.*$/', $val))
	{
		if (file_exists("img/".$val))
		{
			unlink("img/".$val);
		}
	}
}
}
