<?php

namespace App\Auth;

use App\Data;
use App\Table\Mail;

class dbAuth{

	private $db;

	public function __construct($db){
		$this->db = $db;
	}


	private function checkPassword($pwd) {
		if (strlen($pwd) < 8) {
			$_SESSION['msg'][] = "Password too short, min 8!";
			return false;
		}
		if (strlen($pwd) > 32) {
			$_SESSION['msg'][] = "Password too long, max32!";
			return false;
		}
		if (!preg_match('/[0-9]+/', $pwd)) {
			$_SESSION['msg'][] = "Password must include at least one number!";
			return false;
		}
		if (!preg_match('/[a-zA-Z]+/', $pwd)) {
			$_SESSION['msg'][] = "Password must include at least one letter!";
			return false;
		}
		return (true);
	}

	private function checkInput($input, $name) {
		if (strlen($input) < 3) {
			$_SESSION['msg'][] = $name." too short, min 3 letter!";
			return false;
		}
		if (strlen($input) > 32) {
			$_SESSION['msg'][] = $name." too long, max32!";
			return false;
		}
		if (!preg_match('/^[a-zA-Z0-9]+$/', $input))
		{
			$_SESSION['msg'][] = $name." must use only letter and numbers !";
			return false;
		}
		return (true);
	}

	public function addimgtodata($id, $final, $desc){
		Data::getDb()->insert("INSERT INTO `img` (`id`, `userid`, `linkimg`, `desc`) VALUES (NULL, ?, ?, ?);", [$id,$final,$desc]);
		$data = Data::getDb()->prepare("SELECT * FROM img WHERE img.linkimg = ?", [$final], null, true);
		if ($data){
			header("Refresh:0");
			exit;
		}else{
			return false;
		}
	}

	public function comment($com, $imgid){
		if (!preg_match('/^[a-zA-Z0-9 .\/*-+@]+$/', $com))
		{
			$_SESSION['msg'][] = $name." must use only letter and numbers !";
			return false;
		}
		$data = Data::getDb()->prepare("SELECT comment.comment, comment.userid, comment.imgid
											FROM comment
											WHERE  comment.comment = ?
											AND comment.userid = ?
											AND comment.imgid = ?", [$com, $_SESSION['auth']['id'],$imgid], null, true);
		if ($data){
			$_SESSION['msg'][] = "you already posted this comment.";
			return false;
		}
		Data::getDb()->insert("INSERT INTO `comment` (`id`, `userid`, `imgid`, `comment`) VALUES (NULL, ?, ?, ?);", [$_SESSION['auth']['id'],$imgid,$com]);
		$user = Data::getDb()->prepare("SELECT users.username, users.mailcom, users.mail, users.id
											FROM users, img
											WHERE  users.id = img.userid
											AND img.id = ?", [$imgid], null, true);
		if ($user->mailcom === 1){
		$link = "http://localhost:8080/index.php?p=gal&id=".$user->id."&img=".$imgid;
		$mailcontent = "Hello ".$user->username."\n,
						You have a new comment on your photo to see it go to:\n
						<a href='".$link."'>".$link."</a>";
		echo $mailcontent;
		die();
		Mail::mail($user->mail,$mailcontent);
	}
		return true;
}

	public function vmail($id, $token){
		$user = Data::getDb()->prepare("SELECT * FROM users WHERE id = ? AND token = ?", [$id, $token], null, true);
		if ($user->verified === 1){
			$_SESSION['msg'][] = "Mail alredy confirm";
			return false;
		}
		if ($user){
			Data::getDb()->insert("UPDATE `users` SET `verified` = '1' WHERE `users`.`id` = ?;", [$id]);
			Data::getDb()->insert("UPDATE `users` SET `token` = '' WHERE `users`.`id` = ?;", [$id]);
			return true;
		}
		return false;
	}

	public function cpass($id, $token, $p1, $p2){
		if ($this->checkPassword($p1) === false)
			return;
		$user = Data::getDb()->prepare("SELECT * FROM users WHERE id = ? AND token = ?", [$id, $token], null, true);
		if ($user->verified !== 1){
			Data::getDb()->insert("UPDATE `users` SET `verified` = '1' WHERE `users`.`id` = ?;", [$id]);
		}
		if ($p1 === $p2)
		{

			if ($user)
			{
				$p1 = hash('whirlpool', $p1);
				Data::getDb()->insert("UPDATE `users` SET `passwd` =  ?
											WHERE `users`.`id` = ?;", [$p1, $id]);
				Data::getDb()->insert("UPDATE `users` SET `token` = '' WHERE `users`.`id` = ?;", [$id]);
				return true;
			}
			else{
				$_SESSION['msg'][] = "Error";
				return false;
			}
		}else{
			$_SESSION['msg'][] = "Password not match";
			return false;
		}

	}

	public function faccount($username){
		$username = ucfirst(strtolower($username));
		$user = Data::getDb()->prepare("SELECT * FROM users WHERE username = ?", [$username], null, true);
			if ($user){
				$bytes = random_bytes(20);
				$token = bin2hex($bytes);
				Data::getDb()->insert("UPDATE `users` SET `token` = ?
				WHERE `users`.`username` = ?;", [$token, $username]);
				$link = "http://localhost:8080/index.php?p=cpass&user=".$user->id."&token=".$token;
				$mailcontent = "Hello ".$user->username."\n,
								for change your password go to :\n
								<a href='".$link."'>".$link."</a>";
				echo $mailcontent;
				die();
				Mail::mail($user->mail,$mailcontent);
				return $_SESSION['msg'][] = "Check your mail";
			}
			else{
				return $_SESSION['msg'][] = "Username dosn't exist !";
		}

	}

	public function regist($username, $mail, $p1, $p2){
		if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			if ($p1 === $p2){
				if ($this->checkPassword($p1) === false)
					return ;
				if (!empty($username)){
					$username = ucfirst(strtolower($username));
					if (($this->checkInput($username, 'Username') === false)){
						return;
					}else{
						$user = Data::getDb()->prepare("SELECT * FROM users WHERE username = ?", [$username], null, true);
						if ($user){
							return $_SESSION['msg'][] = "Username exist, choose another";
						}
						else{
							$cmail = Data::getDb()->prepare("SELECT * FROM users WHERE mail = ?", [$mail], null, true);
							if ($cmail){
								return $_SESSION['msg'][] = "Mail exist";
							}
							else{
								$bytes = random_bytes(20);
								$token = bin2hex($bytes);
								$ph = hash('whirlpool', $p1);
								Data::getDb()->insert("INSERT INTO `users` (`username`, `mail`, `passwd`, `token`)
								VALUES (?, ?, ?, ?)", [$username, $mail, $ph, $token]);
								$user = Data::getDb()->prepare("SELECT * FROM users WHERE username = ?", [$username], null, true);
								$link = "http://localhost:8080/index.php?p=vmail&user=".$user->id."&token=".$token;
								$mailcontent = "Hello ".$user->username."\n,
												for activate your account go to :\n
												<a href='".$link."'>".$link."</a>";
								echo $mailcontent;
								die();
								Mail::mail($user->mail, $mailcontent);
								return true;
							}
						}
					}
				}
				else{
					return $_SESSION['msg'][] = "Use Username plz";
				}
				return $_SESSION['msg'][] = "wrong mail format";
			}
			else{
				return $_SESSION['msg'][] = "Password not match";
			}
		} else {
			return $_SESSION['msg'][] = "wrong mail format";
		}
	}

	public function login($username, $password){
		$username = ucfirst(strtolower($username));
		$user = Data::getDb()->prepare("SELECT * FROM users WHERE username = ?", [$username], null, true);
		if ($user){

			if ($user->verified === 1)
			{
				if ($user->passwd === hash('whirlpool', $password))
				{
					$_SESSION['auth']['id'] = $user->id;
					$_SESSION['auth']['username'] = $user->username;
					$_SESSION['auth']['mailcom'] = $user->mailcom;
					$lst = scandir("img");
					foreach ($lst as $val){
					if (preg_match('/^'.$_SESSION['auth']['id'].'tmp-.*$/', $val))
						{
							if (file_exists("img/".$val))
							{
								unlink("img/".$val);
							}
						}
					}
					return true;
				}
			}else{
				$_SESSION['msg'][] = "check email to activate your account";
				return false;
			}
		}
		return false;
	}

	public function logged(){
		return isset($_SESSION['auth']['id']);
	}

	//////////////////////////////////////////////// SETTING /////////////////////////////////
	private function setusername($nusername){
		if ($nusername)
		{
			$nusername = ucfirst(strtolower($nusername));
			$user = Data::getDb()->prepare("SELECT * FROM users WHERE username = ?", [$nusername], null, true);
			if ($user){
				return $_SESSION['msg'][] = "Username exist, choose another";
			}
			else if (($this->checkInput($nusername, 'Username') === false)){
				return;
			}
			else{
				Data::getDb()->insert("UPDATE `users` SET `username` = ?
				WHERE `users`.`id` = ?;", [$nusername, $_SESSION['auth']['id']]);
				$_SESSION['msg'][] = "Username changed";
				$_SESSION['auth']['username'] = $nusername;
				return;
			}
		}
	}

	private function setmail($nmail){
		if ($nmail){
			if (filter_var($nmail, FILTER_VALIDATE_EMAIL)){
				$cmail = Data::getDb()->prepare("SELECT * FROM users WHERE mail = ?", [$mail], null, true);
				if ($cmail){
					return $_SESSION['msg'][] = "Mail exist";
				}
				else{
					Data::getDb()->insert("UPDATE `users` SET `mail` = ?
					WHERE `users`.`id` = ?;",[$nmail, $_SESSION['auth']['id']]);
					$_SESSION['msg'][] = "Mail changed";
				}
			}else{
				return $_SESSION['msg'][] = "Bad Mail format";
			}
		}
	}

	private function setpass($oldpasswd, $npasswd, $npasswdc){
		if ($oldpasswd || $npasswd || $npasswdc){
			if ($oldpasswd && $npasswd && $npasswdc){
				if (($npasswd != $npasswdc) || ($this->checkPassword($npasswd) === false)){
					return $_SESSION['msg'][] = "Password are not same";
				}
				$oldpasswd = hash('whirlpool', $oldpasswd);
				$pass = Data::getDb()->prepare("SELECT passwd FROM users WHERE id = ?", [$_SESSION['auth']['id']], null, true);
				if ($pass->passwd === $oldpasswd){
					$npasswd = hash('whirlpool', $npasswd);
					if ($pass->passwd === $npasswd){
						return $_SESSION['msg'][] = "New Password = Old Password...";
					}
					else{
						Data::getDb()->insert("UPDATE `users` SET `passwd` =  ?
						 WHERE `users`.`id` = ?;", [$npasswd, $_SESSION['auth']['id']]);
						 return $_SESSION['msg'][] = "Password changed";
					}
				}
				else{
					return $_SESSION['msg'][] = "Bad old password";
				}
			}else{
				return $_SESSION['msg'][] = "Password error";
			}
		}
	}

	private function setswitch($switch){
		if ($switch !== $_SESSION['auth']['mailcom']){
			Data::getDb()->insert("UPDATE `users` SET `mailcom` = ?
			 WHERE `users`.`id` = ?;", [$switch, $_SESSION['auth']['id']]);
			 $_SESSION['auth']['mailcom'] = $switch;
			 $_SESSION['msg'][] = "Comments Mail set";
	}
	}

	public function setting($nusername, $nmail, $oldpasswd, $npasswd, $npasswdc, $switch){
		$this->setusername($nusername);
		$this->setmail($nmail);
		$this->setpass($oldpasswd, $npasswd, $npasswdc);
		$this->setswitch($switch);
		$_SESSION['msg'][] = "Done";
		return;
	}

}