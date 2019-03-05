<?php

namespace App\Table;
use \App\HTML\Form;
use \App\Data;

class Landc{

	private $imgid;

	public function __construct($imgid)
	{
		$this->imgid = $imgid;
	}

	public function likes()
	{
		$data = Data::getDb()->prepare("SELECT * FROM `like` WHERE `imgid` = ?", [$this->imgid]);
		$html = count($data).' likes';
		$like = '<a href="'.'link val'.'" > Like IT ! </a>';
		echo '<p> '.$html.'  '.$like.'</p>';
	}

	public function com()
	{
		$form1 = new Form("#", "post");
				echo $form1->input('Your comment');
				echo $form1->submit("Submit");
	}

}