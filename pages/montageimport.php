<?php

require_once "pages/functions.php";

if ($_GET['op'] === 'reset')
{
	delltmp();
}
if(!empty($_FILES['myfile']['name']))
{
	$fichier_temp = $_FILES['myfile']['tmp_name'];
	$filename = $_FILES['myfile']['name'];
	list($fl, $fh, $fichier_type, $fichier_attr) = getimagesize($fichier_temp);
	$fsizemax = 20000000;
	$fhmax = 1440;
	$flmax = 1920;
	$pathfile = 'img/';
	$fichier_ext = substr($filename,strrpos( $filename, '.')+1);
	if (!empty($fichier_temp) && is_uploaded_file($fichier_temp))
	{
	if (filesize($fichier_temp)<$fsizemax)
	{
		if ($fichier_type===2)
		{
		if (($fl === $flmax) && ($fh === $fhmax))
		{
			$finalfile = $pathfile.$_SESSION['auth']['id']."tmp-".uniqid().".".$fichier_ext;
		if (move_uploaded_file($fichier_temp, $finalfile))
			{
				$_SESSION['msg'][] = "file upload success";
			}
			else
			$_SESSION['msg'][] =  "file upload error";
		}
		else
			$_SESSION['msg'][] =  "file size is to big";
		}
		else
		$_SESSION['msg'][] =  "wrong file format";
	}
	else
		$_SESSION['msg'][] =  "file is to big";
	}
	else
	$_SESSION['msg'][] =  "no file";
}
if ($_POST['submit'] === 'submit'){

	$desc = str_replace(array("\r", "\n"), ' ', $_POST['desc']);
	if ($desc){
	if (!preg_match('/^[a-zA-Z0-9 .\/*-+@]+$/', $desc))
		{
			header('Location: index.php?p=import');
			$_SESSION['msg'][] = "Description must use only letter and numbers !";
			exit;
		}}
	$filter = $_POST['img'];
	$photo = "".$_POST['imagepath'];

	$final = "img/".$_SESSION['auth']['id']."final".uniqid().".jpg";
	$logo = imagecreatefromfile($filter);
	$img = imagecreatefromfile($photo);

	imagecopy($img, $logo, 0, 0, 0, 0, 1920, 1440);
	$success = imagejpeg($img, $final, 100);
	imagedestroy($img);
	delltmp();
	if ($success === true) {
		$auth = new App\Auth\dbAuth(App\Data::getDb());
		if ($auth->addimgtodata($_SESSION['auth']['id'],$final,$desc) === false)
		{
			header('Location: index.php?p=home');
			$_SESSION['msg'][] = "Error";
			exit;
		}
	 }
	else{
		header('Location: index.php?p=home');
			$_SESSION['msg'][] = "Error";
			exit;
	}
}