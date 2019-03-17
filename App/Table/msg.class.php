<?php

namespace App\Table;

class Msg{
	public static function msg(){
		if(session_status() == PHP_SESSION_NONE){
			session_start();
		}
   		if($_SESSION['msg'] != NULL)
   		 {
			echo '<div id="hide" class="hide" >';
			foreach($_SESSION['msg'] as $value)
			{
				echo '<p >'.$value.'</p>';
			}
			echo '<button class="button" id="close">Close</button></p></div>';
        unset($_SESSION['msg']);
		}
	}

}