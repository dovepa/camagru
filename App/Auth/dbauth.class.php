<?php

namespace App\Auth;

use App\Data;

class dbAuth{

	private $db;

	public function __construct($db){
		$this->db = $db;
	}

	public function login($username, $password){
		$user = Data::getDb()->prepare("SELECT * FROM users WHERE username = ?", [$username], null, true);
		if ($user){

			if ($user->verified === '1')
			{
			if ($user->passwd === hash('whirlpool', $password))
			{
				$_SESSION['auth']['id'] = $user->id;
				return true;
			}
		}else{
			$_SESSION['msg'][] = "check email to activate your account";
			return false;
		}
		}
		return false;
	}

	public function regist($username, $mail, $p1, $p2){
		if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			if ($p1 === $p2){
				if (strlen($p1) < 5)
				{
					return $_SESSION['msg'][] = "Password to short min 5char";
				}
				if (!empty($username)){
					if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['newlogin'])){
						return $_SESSION['msg']['c'][] = "Use Only leter an numbers in username";
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



		$user = Data::getDb()->prepare("SELECT * FROM users WHERE username = ?", [$username], null, true);
		if ($user){
			if ($user->passwd === hash('whirlpool', $password))
			{
				$_SESSION['auth']['id'] = $user->id;
				return true;
			}
		}
		return false;
	}

	public function logged(){
		return isset($_SESSION['auth']);
	}

}