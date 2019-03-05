<?php

namespace App\Table;

use App\Data;

class Img{

	public static function getHome()
	{
		$sql = "SELECT img.id, img.userid, img.linkimg, img.desc, img.ts, users.username
					FROM img, users
					WHERE img.userid = users.id";

		$data = Data::getDb()->query($sql, __CLASS__);

		return $data;
	}

	public static function getLog()
	{
		$sql = "SELECT img.id, img.userid, img.linkimg, img.desc, img.ts, users.username
					FROM img, users
					WHERE img.userid = users.id";

		$data = Data::getDb()->query($sql, __CLASS__);

		return $data;
	}

	public static function getImgpage()
	{
		$data = Data::getDb()->prepare("SELECT img.id, img.userid, img.linkimg, img.ts, img.desc, users.username
									FROM img, users
									WHERE img.userid = users.id
									AND img.id = ?", [$_GET['img']], __CLASS__);

		return $data[0];
	}

	public static function getGal()
	{
		$data = Data::getDb()->prepare("SELECT img.id, img.userid, img.linkimg, img.desc, img.ts, users.username
											FROM img, users
											WHERE img.userid = users.id
											AND userid = ?
											ORDER BY img.id ASC", [$_GET['id']], __CLASS__);

		return $data;
	}

	public function getImg(){
		$html = '<a href="index.php?p=gal&id='. $this->userid . '&img=' . $this->id . '"><img class="img" src="' . $this->linkimg . '" /></a>';
		date_default_timezone_set('Europe/Paris');
		$date = date_create($this->ts);
		$html .= '<p class="p">'. date_format($date, 'd/m/Y H:i').'  Posted by : <a href="index.php?p=gal&id='. $this->userid . '">' . $this->username . '</a> </p>';
		$html .= '<p class="p">'.$this->desc.'</p>';
		return $html;
	}
	public function getImglog(){
		$html = '<a href="index.php?p=gal&id='. $this->userid . '&img=' . $this->id . '"><img class="img" src="' . $this->linkimg . '" /></a>';
		date_default_timezone_set('Europe/Paris');
		$date = date_create($this->ts);
		$html .= '<p class="p">'. date_format($date, 'd/m/Y H:i').'  Posted by : <a href="index.php?p=gal&id='. $this->userid . '">' . $this->username . '</a> </p>';
		return $html;
	}

}