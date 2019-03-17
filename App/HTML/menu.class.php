<?php

namespace App\HTML;

class Menu{
	public static function menu(){

	if (isset($_SESSION['auth']['id'])){
		echo '<div class="topnav">
		<a href="index.php?p=home">Home</a>
		<a href="index.php?p=gal&id='.$_SESSION['auth']['id'].'">My Gallery</a>
		<a href="index.php?p=add">Add a Pic</a>
		<a href="index.php?p=setting">Setting</a>
		<a href="index.php?p=logout">Logout</a>
		</div>';
	}else{
		echo '<div class="topnav">
			<a href="index.php?p=login">Login</a>
			<a href="index.php?p=registration">Create Account</a>
			</div>';
	}
}
}