<?php

namespace App\HTML;

class Menu{
	public static function menu(){
	echo '<ul>
		<li><a href="index.php?p=home">Home</a></li></ul><ul>
		<li><a href="index.php?p=gal&id='.$_SESSION['auth']['id'].'">My Gallery</a></li></ul><ul>
		<li><a href="index.php?p=add">Add a Pic</a></li></ul><ul>
		<li><a href="index.php?p=setting">Setting</a></li></ul><ul>
		<li><a href="index.php?p=logout">Logout</a></li>
		</ul>';
	}
	public static function menunl(){
		echo '<ul>
			<li><a href="index.php?p=login">Login</a></li></ul><ul>
			<li><a href="index.php?p=registration">Create Account</a></li></ul><ul>
			</ul>';
		}

}