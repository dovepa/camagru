<!DOCTYPE html>
<html>
<head>
<?php if(session_status() == PHP_SESSION_NONE){
		session_start();
	} ?>
<meta charset="UTF-8">
	<title>Camagru</title>
	<link rel="stylesheet" href="../pages/css/style.css">
</head>
<script src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script src="../pages/js/script.js"></script>

<body>


<div class="footer"><p class="pfooter">Made By @Dpalombo With ❤️</p></div>

<?php
echo $content;
?>


<footer>
</footer>
</body>
</html>