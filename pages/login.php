<?php
	if (!empty($_POST)){
		$auth = new App\Auth\dbAuth(App\Data::getDb());
		if ($auth->login($_POST['Username'], $_POST['Password'])){
			die('ok');
		}
		else{
			$_SESSION['msg'][] = "Login or Password Error";
		}
	}
	use \App\HTML\Form;
	App\Table\Msg::msg();
?>

<div class="logindiv">
	<img src="pages/css/img/logo.png" class="logoimg">
	<div class="linediv"></div><h3> Login </h3><div class="linediv"></div>
	<?php
			$form1 = new Form();
				echo $form1->input('Username');
				$form1->type = "password";
				echo $form1->input('Password');
				echo $form1->submit("Login");
	?>
	<div class="linediv"></div>
	<p class="pright"><a href="index.php?p=registration">Create Account</a></p>
	<p class="pright"><a href="index.php?p=faccount">Forgot account?</a></p>

</div>

<?php echo '
<div class="flex-container">

<?php foreach (App\Table\Img::getLog() as $img): ?>
<div class="item">
<?= $img->getImglog(); ?>
</div>
<?php endforeach; ?>
</div>
';?>'