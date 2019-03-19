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
		if (count($data) > 1)
		{
			$plu = 's';
		}else{
			$plu = '';
		}
		$html = count($data).' like'.$plu;
		$data2 = Data::getDb()->prepare("SELECT * FROM `like` WHERE `imgid` = ? AND `userid` = ?", [$this->imgid, $_SESSION['auth']['id']], null, true);
		if ($data2->likeval === 1){
			$like = 'full';
		}else{
			$like = 'empty';
		}
		return '<div id="'.$this->imgid.'likes" class="'.$this->imgid.'likes"><p>'.$html.' <a href="#" id="'.$this->imgid.'" onclick="likes(this.id); return false"><img src="pages/css/img/'.$like.'heart.png" class="heart"/></a></p></div>';
	}

	public function getLikesnl()
	{
		$data = Data::getDb()->prepare("SELECT * FROM `like` WHERE `imgid` = ? AND `likeval` = 1", [$this->imgid]);
		if (count($data) > 1)
		{
			$plu = 's';
		}else{
			$plu = '';
		}
		$html = count($data).' like'.$plu;
		return '<div id="'.$this->imgid.'likes" class="'.$this->imgid.'likes"><p>'.$html.' <a href="index.php?p=login"><img src="pages/css/img/emptyheart.png" class="heart"/></a></p></div>';
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
			Share on FACEBOOK
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
			$user = Data::getDb()->prepare("SELECT img.userid FROM img WHERE id = ?", [$val->imgid], null, true);
			if ($val->userid === $_SESSION['auth']['id'] || $user->userid === $_SESSION['auth']['id']){
				$remove = '<button id="'. $val->id . '" class="submit_fields" onclick="removecom(this.id); return false"">Remove</button>';
			}
			else {
				$remove = "";
			}
			echo '<div class="com" id="'.$val->id.'com"><p>N'.$i.'- Posted by : <a href="index.php?p=gal&id='. $val->userid . '">' . $val->username . '</a></p>
			<p>'.$val->comment.'</p><p>'.$remove.'</p></div>';
			$i--;
		}
		return;
	}
}