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

	public function getLikes()
	{
		$data = Data::getDb()->prepare("SELECT * FROM `like` WHERE `imgid` = ? AND `likeval` = 1", [$this->imgid]);
		$html = count($data).' likes';
		$data2 = Data::getDb()->prepare("SELECT * FROM `like` WHERE `imgid` = ? AND `userid` = ?", [$this->imgid, $_SESSION['auth']['id']], null, true);
		if ($data2->likeval === 1){
			$like = 'full';
		}else{
			$like = 'empty';
		}
		return '<div id="'.$this->imgid.'likes" class="'.$this->imgid.'likes"><p class="p">'.$html.' <a href="#" id="'.$this->imgid.'" onclick="likes(this.id); return false"><img src="pages/css/img/'.$like.'heart.png" class="heart"></a></div>';
	}

	public function getLikesnl()
	{
		$data = Data::getDb()->prepare("SELECT * FROM `like` WHERE `imgid` = ? AND `likeval` = 1", [$this->imgid]);
		$html = count($data).' likes';
		return '<div id="'.$this->imgid.'likes" class="'.$this->imgid.'likes"><p class="p">'.$html.' <a href="index.php?p=login"><img src="pages/css/img/emptyheart.png" class="heart"></a></div>';
	}

	public function postCom()
	{
		$form1 = new Form("#", "post");
				echo "</br>";
				echo $form1->area('Comment');
				echo $form1->submit("Submit");
				unset($from1);
	}

	public function share()
	{
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		echo
		'<button class="share twitter" data-url="'.$actual_link.'">
                Share on TWITTER
			</button>
		<button class="share facebook" data-url="'.$actual_link.'">
			Share in FACEBOOK
		</button><script src="../pages/js/share.js"></script>';
		return;
	}

	public function getCom()
	{
		$data = Data::getDb()->prepare("SELECT comment.id, comment.userid, comment.imgid, comment.comment, users.username
											FROM comment, users
											WHERE comment.imgid = ? AND comment.userid = users.id
											ORDER BY comment.id DESC", [$this->imgid]);
		$i = count($data);
		foreach ($data as $val)
		{
			echo '<div class="com"><p>N'.$i.'- Posted by : <a href="index.php?p=gal&id='. $val->userid . '">' . $val->username . '</a></p>
			<p>'.$val->comment.'</p></div>';
			$i--;
		}
		return;
	}
}