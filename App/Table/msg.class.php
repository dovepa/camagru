<?php

namespace App\Table;

class Msg{
	public static function msg(){
		if(session_status() == PHP_SESSION_NONE){
			session_start();
		}
   		if($_SESSION['msg'] != NULL)
   		 {
        foreach($_SESSION['msg'] as $value)
        {
            echo '<div id="hide" class="hide" ><p >'.$value.' <button class="button" id="close">Close</button></p></div>';
		}
        unset($_SESSION['msg']);
		}
	}

}