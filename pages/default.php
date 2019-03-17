<!DOCTYPE html>
<html>
<head>
<?php if(session_status() == PHP_SESSION_NONE){
		session_start();
	} ?>
<meta charset="UTF-8">
	<title>Camagru</title>
	<link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/css/style.css">
	<script src="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/js/http.js"></script>
	<script src="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/js/script.js"></script>
</head>

<body>
<?php App\HTML\Menu::menu(); ?>

<div class="footer"><p class="pfooter">Made By @Dpalombo With ❤️</p></div>

<?php
echo $content;
?>

<script>hide();</script>
<footer>
</footer>
</body>
</html>