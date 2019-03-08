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
		if (strlen($input) < 8) {
			$_SESSION['msg'][] = $name." too short, min 8!";
			return false;
		}
		if (strlen($input) > 32) {
			$_SESSION['msg'][] = $name." too long, max32!";
			return false;
		}
		if (!preg_match('/^[a-zA-Z0-9]+$/', $input))
		{
			$_SESSION['msg'][] = $name." must use only letter ane numbers !";
			return false;
		}
		return (true);
	}

	public function vmail($id, $token){
		$user = Data::getDb()->prepare("SELECT * FROM users WHERE id = ? AND token = ?", [$id, $token], null, true);
		if ($user->verified === 1){
			$_SESSION['msg'][] = "Mail alredy confirm";
			return false;
		}
		if ($user){
			Data::getDb()->insert("UPDATE `users` SET `verified` = '1' WHERE `users`.`id` = ?;", [$id]);
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
				Mail::mail($user->mail,$mailcontent);
				return $_SESSION['msg'][] = "Check your mail";
			}
			else{
				return $_SESSION['msg'][] = "Username dosn't exist !";
		}

	}

	public function setting($nusername, $nmail, $oldpasswd, $npasswd, $npasswdc, $switch){
		if ($nusername)
		{
			$nusername = ucfirst(strtolower($nusername));
			$user = Data::getDb()->prepare("SELECT * FROM users WHERE username = ?", [$nusername], null, true);
			if ($user){
				return $_SESSION['msg'][] = "Username exist, choose another";
			}
			else{
				Data::getDb()->insert("UPDATE `users` SET `username` = ?
				WHERE `users`.`id` = ?;", [$nusername, $_SESSION['auth']['id']]);
				$_SESSION['msg'][] = "Username changed";
				$_SESSION['auth']['username'] = $nusername;
				return;
			}
		}
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
		if ($switch){
				Data::getDb()->insert("UPDATE `users` SET `mailcom` = ?
				 WHERE `users`.`id` = ?;", [$switch, $_SESSION['auth']['id']]);
				 $_SESSION['auth']['mailcom'] = $switch;
		}
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

}