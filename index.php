<?php
require $_SERVER['DOCUMENT_ROOT']."/App/autoloader.class.php";
	App\Autoloader::register();

if(session_status() == PHP_SESSION_NONE){
		session_start();
	}

$auth = new App\Auth\dbAuth(App\Data::getDb());

 ob_start();
if (isset($_GET['p']))
{
	$p = $_GET['p'];
}
else
{
	if (!($auth->logged())){
		$p = 'login';}
	else
		$p = 'home';
}


 if ($p === 'home')
 {
	if (!($auth->logged())){
		header('Location: index.php?p=login');
		$_SESSION['msg'][] = 'You are not logged';
		exit;
	}
	else {
	 require $_SERVER['DOCUMENT_ROOT']."/pages/home.php";
	}
 }
 else if ($p === 'login')
 {
 if ($auth->logged()){
	require $_SERVER['DOCUMENT_ROOT']."/pages/home.php";
	$_SESSION['msg'][] = 'You are already logged';
}
else {
	require $_SERVER['DOCUMENT_ROOT']."/pages/login.php";
}
 }
 else if ($p === 'logout')
 {
	 if (!($auth->logged())){
		header('Location: index.php?p=login');
		$_SESSION['msg'][] = 'You are not logged';
		exit;
	}
	else {
	unset($_SESSION['auth']);
	header('Location: index.php?p=login');
	$_SESSION['msg'][] = 'You are not logged yet';
	exit;
	}
 }
 else if ($p === 'registration')
 {
	if ($auth->logged()){
		require $_SERVER['DOCUMENT_ROOT']."/pages/home.php";
		$_SESSION['msg'][] = 'You are already logged';
	}
	else {
	 require $_SERVER['DOCUMENT_ROOT']."/pages/registration.php";
	}
 }
 else if ($p === 'faccount')
 {
	if ($auth->logged()){
		require $_SERVER['DOCUMENT_ROOT']."/pages/home.php";
		$_SESSION['msg'][] = 'You are already logged';
	}
	else {
	 require $_SERVER['DOCUMENT_ROOT']."/pages/faccount.php";
	}
 }
 else if ($p === 'gal')
 {
	if (!($auth->logged())){
		if (!empty($_GET['img']))
			require $_SERVER['DOCUMENT_ROOT']."/pages/nlimg.php";
		else
			require $_SERVER['DOCUMENT_ROOT']."/pages/login.php";
	}
	else {
	 if (!empty($_GET['img']))
		require $_SERVER['DOCUMENT_ROOT']."/pages/img.php";
	 else if (!empty($_GET['id']))
		 require $_SERVER['DOCUMENT_ROOT']."/pages/gal.php";
	 else {
		$_GET['id'] = $auth->logged();
		require $_SERVER['DOCUMENT_ROOT']."/pages/gal.php";
	 }

	}
}
else if ($p === 'setting')
{
   if (!($auth->logged())){
	header('Location: index.php?p=login');
	$_SESSION['msg'][] = 'Log in first';
	exit;
   }
   else {
	   require $_SERVER['DOCUMENT_ROOT']."/pages/setting.php";
	}
}
else if ($p === 'vmail')
{
   if (!empty($_GET['user']) && !empty($_GET['token'])){
		if ($auth->vmail($_GET['user'], $_GET['token'])){
			header('Location: index.php?p=login');
			$_SESSION['msg'][] = 'Account succefully activated';
			exit;
		}else {
			header('Location: index.php?p=home');
			$_SESSION['msg'][] = 'Error';
			exit;
		}
   }
   else {
	header('Location: index.php?p=home');
	$_SESSION['msg'][] = 'Error';
	exit;
   }
}
else if ($p === 'cpass')
{
   if ($auth->logged()){
	   $_SESSION['msg'][] = 'Log out first !';
	   require $_SERVER['DOCUMENT_ROOT']."/pages/home.php";

   }
   else {
	   require $_SERVER['DOCUMENT_ROOT']."/pages/cpass.php";
	}
}else if ($p === 'add')
{
	if (!($auth->logged())){
		require $_SERVER['DOCUMENT_ROOT']."/pages/login.php";
	}
	else {
	   require $_SERVER['DOCUMENT_ROOT']."/pages/add.php";
	}
}else if ($p === 'webcam')
{
	if (!($auth->logged())){
		require $_SERVER['DOCUMENT_ROOT']."/pages/login.php";
	}
	else {
	   require $_SERVER['DOCUMENT_ROOT']."/pages/webcam.php";
	}
}else if ($p === 'import')
{
	if (!($auth->logged())){
		require $_SERVER['DOCUMENT_ROOT']."/pages/login.php";
	}
	else {
	   require $_SERVER['DOCUMENT_ROOT']."/pages/import.php";
	}
}
else{
	if (!($auth->logged())){
		require $_SERVER['DOCUMENT_ROOT']."/pages/login.php";
	}
	else {
	 require $_SERVER['DOCUMENT_ROOT']."/pages/home.php";
	}
 }



 $content = ob_get_clean();
 require $_SERVER['DOCUMENT_ROOT']."/pages/default.php";



 ?>