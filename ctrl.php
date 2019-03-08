<?php

use App\Data;

$p = $_GET['p'];

if(session_status() == PHP_SESSION_NONE){
	session_start();
}
require "App/autoloader.class.php";
App\Autoloader::register();
$auth = new App\Auth\dbAuth(App\Data::getDb());


if ($p === 'remove'){
				if (!($auth->logged())){
				header('Location: index.php?p=home');
			}

			$item = $_POST['item'];

			$data = Data::getDb()->prepare("SELECT img.id, img.userid, img.linkimg, img.ts, img.desc, users.username
												FROM img, users
												WHERE img.userid = users.id
												AND img.id = ?", [$item], __CLASS__);
			if ($data[0]['userid'] === $_SESSION['auth']['id']){
				//dell all comment
				Data::getDb()->insert("DELETE FROM `comment` WHERE imgid = ?", [$item]);
				//dell all likes
				Data::getDb()->insert("DELETE FROM `like` WHERE imgid = ?", [$item]);
				//del pic
				Data::getDb()->insert("DELETE FROM `img` WHERE id = ?", [$item]);
				echo "Done";
			}
			else
				echo "Error";
}
else if ($p === 'loader'){
		if (isset($_GET['off'])){
			$offset = $_GET['off'];
		}else{
			$offset = 0;
		}
		$i = 0;
		$val = App\Table\Img::getLog($offset);
		if ($val !== null)
		{
		foreach ($val as $img){
		if (($i % 4) == 0)
			echo '<div class="flex-container">';
		echo '<div class="item">'.$img->getImglog().'</div>';
		$i++;
		if (($i % 4) == 0)
			echo '</div>';

		}
		}
}
else if ($p === "loader2"){

	if (isset($_GET['off'])){
		$offset = $_GET['off'];
	}else{
		$offset = 0;
	}
	$val = App\Table\Img::getHome($offset);
	if ($val !== null)
	{
		foreach ($val as $img){
			echo '<div class="imglist">'. $img->getImg().'</div>';
			}

	}
}
else if ($p === "loader3"){

	if (isset($_GET['off'])){
		$offset = $_GET['off'];
	}else{
		$offset = 0;
	}

	foreach (App\Table\Img::getGal($offset,$_GET['id']) as $img){
		echo $img->getImggal();
	}
}
else{
	header('Location: index.php?p=home');
}