<?php

require_once "pages/functions.php";

if ($_GET['op'] === 'reset')
{
	delltmp();
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
	$filter = $_POST['filter'];
	$photo = $_POST['imagetake'];

	$final = "img/".$_SESSION['auth']['id']."final".uniqid().".jpg";

	$tmp = "img/".$_SESSION['auth']['id']."tmp-".uniqid().".png";

	$logo = imagecreatefromfile($filter);

	$img = str_replace('data:image/png;base64,', '', $photo);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);

	file_put_contents($tmp, $data);

	$img = imagecreatefromfile($tmp);

	//imagesx($logo)
	imagecopy($img, $logo, 0, 0, 0, 0, 1920, 1080);
	$success = imagejpeg($img, $final, 100);
	imagedestroy($img);

	 if ($success === true) {
		$auth = new App\Auth\dbAuth(App\Data::getDb());// return false si error
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