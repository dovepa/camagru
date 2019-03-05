<?php

namespace App\Table;

class Mail{

	private $imgid;


	public static function mail($mail_to = "dove-dove@hotmail.fr", $mail_subject = "Test", $mail_message = "Tu viens de t inscrire sur camagru")
	{
		$from_name = "Camagru";
		$from_mail = "camagru@project42.fr";
		$encoding = "utf-8";

		// Preferences for Subject field
		$subject_preferences = array(
			"input-charset" => $encoding,
			"output-charset" => $encoding,
			"line-length" => 76,
			"line-break-chars" => "\r\n"
		);

		// Mail header
		$header = "Content-type: text/html; charset=".$encoding." \r\n";
		$header .= "From: ".$from_name." <".$from_mail."> \r\n";
		$header .= "MIME-Version: 1.0 \r\n";
		$header .= "Content-Transfer-Encoding: 8bit \r\n";
		$header .= "Date: ".date("r (T)")." \r\n";
		$header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

		// Send mail
		$success = mail($mail_to, $mail_subject, $mail_message, $header);
		if (!$success) {
			return false;
		}
		else{
			return true;
		}
	}
}
