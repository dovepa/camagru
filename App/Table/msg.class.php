<?php

namespace App\Table;

class Msg{


	public static function msg(){
   		if($_SESSION['msg'] != NULL)
   		 {
        foreach($_SESSION['msg'] as $value)
        {
            echo '<div class="hide"><p >'.$value.' <a href="#"> -Close- </a></p></div>';
		}
        unset($_SESSION['msg']);
		}
	}

}