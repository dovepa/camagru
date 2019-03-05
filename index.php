<?php
require "App/autoloader.class.php";
	App\Autoloader::register();

if(session_status() == PHP_SESSION_NONE){
		session_start();
	}


 if (isset($_GET['p']))
 {
	 $p = $_GET['p'];
 }
 else
 {
	$p = 'home';
 }

$auth = new App\Auth\dbAuth(App\Data::getDb());

 ob_start();
 if ($p === 'home')
 {
	if (!($auth->logged())){
		require "pages/login.php";
		$_SESSION['msg'][] = 'Log in first !';
	}
	else {
	 require "pages/home.php";
	}
 }
 else if ($p === 'login')
 {
	 if (($auth->logged())){
		require "pages/home.php";
		$_SESSION['msg'][] = 'You are already logged';
	}
	else {
	require "pages/login.php";
	}
 }
 else if ($p === 'logout')
 {
	 if (!($auth->logged())){
		require "pages/login.php";
		$_SESSION['msg'][] = 'You are not logged';
	}
	else {
	unset($_SESSION['auth']);
	$_SESSION['msg'][] = 'You are not logged yet';
	require "pages/login.php";
	}
 }
 else if ($p === 'registration')
 {
	if (($auth->logged())){
		require "pages/home.php";
		$_SESSION['msg'][] = 'You are already logged';
	}
	else {
	 require "pages/registration.php";
	}
 }
 else if ($p === 'faccount')
 {
	if (($auth->logged())){
		require "pages/home.php";
		$_SESSION['msg'][] = 'You are already logged';
	}
	else {
	 require "pages/faccount.php";
	}
 }
 else if ($p === 'gal')
 {
	if (!($auth->logged())){
		require "pages/login.php";
		$_SESSION['msg'][] = 'Log in first !';
	}
	else {
	 if (isset($_GET['img']))
		require "pages/img.php";
	 else
	 	require "pages/gal.php";

	}
}
else{
	if (!($auth->logged())){
		require "pages/login.php";
		$_SESSION['msg'][] = 'Log in first !';
	}
	else {
	 require "pages/home.php";
	}
 }



 $content = ob_get_clean();
 require "pages/default.php";



 ?>