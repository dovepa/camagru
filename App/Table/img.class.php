<?php

namespace App\Table;

use App\Data;

class Img{

	public static function getHome($offset)
	{
		$data = Data::getDb()->prepare("SELECT img.id, img.userid, img.linkimg, img.desc, img.ts, users.username
											FROM img, users
											WHERE img.userid = users.id
											ORDER BY img.id ASC
											LIMIT 10 OFFSET ?", [$offset], __CLASS__);

		return $data;
	}

	public static function getLog($offset)
	{
		$data = Data::getDb()->prepare("SELECT img.id, img.userid, img.linkimg, img.desc, img.ts, users.username
											FROM img, users
											WHERE img.userid = users.id
											ORDER BY img.id ASC
											LIMIT 28 OFFSET ?", [$offset], __CLASS__);

		return $data;
	}

	public static function getImgpage()
	{
		$data = Data::getDb()->prepare("SELECT img.id, img.userid, img.linkimg, img.ts, img.desc, users.username
									FROM img, users
									WHERE img.userid = users.id
									AND img.id = ?", [$_GET['img']], __CLASS__, true);

		return $data;
	}

	public static function getGalusername()
	{
		$data = Data::getDb()->prepare("SELECT username
											FROM users
											WHERE id = ?", [$_GET['id']], null, true);

		return $data;
	}

	public static function getGal($offset, $id)
	{
		$data = Data::getDb()->prepare("SELECT img.id, img.userid, img.linkimg, img.desc, img.ts, users.username
											FROM img, users
											WHERE img.userid = users.id
											AND userid = :id
											ORDER BY img.id ASC
											LIMIT 10 OFFSET :off", array(':id' => $id, ':off' => $offset), __CLASS__);

		return $data;
	}

	public function getImg(){
		$html = '<a href="index.php?p=gal&id='. $this->userid . '&img=' . $this->id . '"><img class="img" src="' . $this->linkimg . '" /></a>';
		date_default_timezone_set('Europe/Paris');
		$date = date_create($this->ts);
		$html .= '<p class="p">'. date_format($date, 'd/m/Y H:i').'  Posted by : <a href="index.php?p=gal&id='. $this->userid . '">' . $this->username . '</a> </p>';
		$html .= '<p class="p">'.$this->desc.'</p>';
		$landc = new Landc($this->id);
		$html .=  $landc->getLikes();
		return $html;
	}

	public function getImgnl(){
		$html = '<a href="index.php?p=gal&id='. $this->userid . '&img=' . $this->id . '"><img class="img" src="' . $this->linkimg . '" /></a>';
		date_default_timezone_set('Europe/Paris');
		$date = date_create($this->ts);
		$html .= '<p class="p">'. date_format($date, 'd/m/Y H:i').'  Posted by : <a href="index.php?p=gal&id='. $this->userid . '">' . $this->username . '</a> </p>';
		$html .= '<p class="p">'.$this->desc.'</p>';
		$landc = new Landc($this->id);
		$html .=  $landc->getLikesnl();
		$html .= '<p class="p">Log in for comment and like !!!</p>';

		return $html;
	}

	public function getImggal(){
		if ($_SESSION['auth']['id'] === $this->userid)
		{
			$remove = '<button id="'. $this->id . '" class="submit_fields" onclick="removepic(this.id); return false"">Remove</button>';
		}
		$landc = new Landc($this->id);
		$html = '<div class="imglist" id="'. $this->id .'"><a href="index.php?p=gal&id='. $this->userid . '&img=' . $this->id . '"><img class="img" src="' . $this->linkimg . '" /></a>';
		date_default_timezone_set('Europe/Paris');
		$date = date_create($this->ts);
		$html .= '<p class="p">'. date_format($date, 'd/m/Y H:i').'  Posted by : <a href="index.php?p=gal&id='. $this->userid . '">' . $this->username . '</a> </p>';
		$html .= '<p class="p">'.$this->desc.'</p>'.$remove.$landc->getLikes().'</div>';
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