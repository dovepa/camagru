<?php

require_once "pages/functions.php";

if ($_GET['op'] === 'reset')
{
	delltmp();
}
if(!empty($_FILES['myfile']['name']))
{
	$fichier_temp = $_FILES['myfile']['tmp_name'];
	$fichier_nom = $_FILES['myfile']['name'];
	list($fichier_larg, $fichier_haut, $fichier_type, $fichier_attr) = getimagesize($fichier_temp);
	$fichier_poids_max = 20000000;
	$fichier_h_max = 1080;
	$fichier_l_max = 1920;
	$fichier_dossier = 'img/';
	$fichier_ext = substr($fichier_nom,strrpos( $fichier_nom, '.')+1);
	if (!empty($fichier_temp) && is_uploaded_file($fichier_temp))
	{
	if (filesize($fichier_temp)<$fichier_poids_max)
	{
		if ($fichier_type===2)
		{
		if (($fichier_larg === $fichier_l_max) && ($fichier_haut === $fichier_h_max))
		{
			$finalfile = $fichier_dossier.$_SESSION['auth']['id']."tmp-".uniqid().".".$fichier_ext;
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

	imagecopy($img, $logo, 0, 0, 0, 0, 1920, 1080);
	$success = imagejpeg($img, $final, 100);
	imagedestroy($img);

	if ($success === true) {
		$auth = new App\Auth\dbAuth(App\Data::getDb());
		if ($auth->addimgtodata($_SESSION['auth']['id'],$final,$desc) === false)
		{
			header('Location: index.php?p=home');
			$_SESSION['msg'][] = "Error";
			delltmp();
			exit;
		}
		delltmp();
	 }
	else{
		header('Location: index.php?p=home');
			$_SESSION['msg'][] = "Error";
			delltmp();
			exit;
	}
}