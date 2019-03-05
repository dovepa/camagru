<?php

namespace App\Table;

class Mail{

	private $imgid;


	public static function mail($mail_to = "dove-dove@hotmail.fr", $mail_subject = "Test", $mail_message = "Hello dove")
	{
		$from_name = "Camagru";
		$from_mail = "camagru@project42.fr";
		$encoding = "utf-8";
		$header = "Content-type: text/html; charset=".$encoding." \r\n";
		$header .= "From: ".$from_name." <".$from_mail."> \r\n";
		$success = mail($mail_to, $mail_subject, $mail_message, $header);
		if (!$success) {
			return false;
		}
		else{
			return true;
		}
	}
}
