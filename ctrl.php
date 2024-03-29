<?php

use App\Data;

$p = $_GET['p'];

if(session_status() == PHP_SESSION_NONE){
	session_start();
}
require $_SERVER['DOCUMENT_ROOT']."/App/autoloader.class.php";
App\Autoloader::register();
$auth = new App\Auth\dbAuth(App\Data::getDb());


if ($p === 'remove'){
				if (!($auth->logged())){
				echo 'Error';
				}
			else{
			$item = $_POST['item'];

			$data = Data::getDb()->prepare("SELECT img.id, img.userid, img.linkimg, img.ts, img.desc, users.username
												FROM img, users
												WHERE img.userid = users.id
												AND img.id = ?", [$item], null, true);
			if (file_exists($data->linkimg))
				unlink($data->linkimg);
			if ($data->userid === $_SESSION['auth']['id']){
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
} else if ($p === 'removecom'){
	if (!isset($_SESSION['auth']['id'])){
	header('Location: index.php?p=home');
}

$item = $_POST['item'];

$data = Data::getDb()->prepare("SELECT * FROM comment WHERE id = ?", [$item], null, true);
$user = Data::getDb()->prepare("SELECT img.userid FROM img WHERE id = ?", [$data->imgid], null, true);
if ($data->userid === $_SESSION['auth']['id'] || $user->userid === $_SESSION['auth']['id']){
	//dell comment
	Data::getDb()->insert("DELETE FROM `comment` WHERE `comment`.`id` =  ?", [$item]);
	echo "ok";
}
else{
	echo "Error";
}
}
else if ($p === 'loader'){
	$result = '';
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
			$result .= '<div class="flex-container">';
			$result .=  '<div class="item">'.$img->getImglog().'</div>';
		$i++;
		if (($i % 4) == 0)
			$result .=  '</div>';

		}
		}
		echo $result;
}
else if ($p === "loader2"){
	$result = '';
	if (isset($_GET['off'])){
		$offset = $_GET['off'];
	}else{
		$offset = 0;
	}
	$val = App\Table\Img::getHome($offset);
	if ($val !== null)
	{
		foreach ($val as $img){
			$result .= '<div class="imglist">'. $img->getImg().'</div>';
			}

	}
	str_replace("&", "bonjour", $result);
	echo $result;
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
else if ($p === "likes"){
	$data = Data::getDb()->prepare("SELECT * FROM `like` WHERE `imgid` = ? AND `userid` = ?", [$_POST['img'], $_SESSION['auth']['id']], null, true);
	if ($data->likeval === 1){
		Data::getDb()->insert("UPDATE `like` SET `likeval` = '2' WHERE `like`.`id` = ?;", [$data->id]);
	}else if ($data->likeval === 2){
		Data::getDb()->insert("UPDATE `like` SET `likeval` = '1' WHERE `like`.`id` = ?;", [$data->id]);
	}else{
		Data::getDb()->insert("INSERT INTO `like` (`id`, `userid`, `imgid`, `likeval`) VALUES (NULL, ?, ?, ?);", [$_SESSION['auth']['id'], $_POST['img'], 1]);
	}
	if (isset($_POST['img'])){
		$landc = new App\Table\Landc($_POST['img']);
		echo $landc->getLikes();
	}
}
else if ($p === "com"){
	if (isset($_GET['id'])){
		$landc = new App\Table\Landc($_GET['id']);
		echo $img->getImggal();
	}
}
else{
	header('Location: index.php?p=home');
}