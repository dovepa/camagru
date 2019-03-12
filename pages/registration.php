<?php
	if ($_POST['submit'] === 'Registration'){
		if (!empty($_POST['Username']) && !empty($_POST['Mail']) && !empty($_POST['Password']) && !empty($_POST['Password_Check'])){
			$auth = new App\Auth\dbAuth(App\Data::getDb());
			if ($auth->regist($_POST['Username'], $_POST['Mail'], $_POST['Password'], $_POST['Password_Check']) === true){
				header('Location: index.php?p=login');
				$_SESSION['msg'][] = "Confirm your email";
				exit;
			}
		}else{
			$_SESSION['msg'][] = "Empty form";
		}

	}
	use \App\HTML\Form;
?>
<?php
App\Table\Msg::msg();
?>

<div class="logindiv">
	<img src="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/css/img/logo.png" class="logoimg">
	<div class="linediv"></div><h3> Registration </h3><div class="linediv"></div>
	<?php
			$form1 = new Form();
				echo $form1->input('Username');
				echo $form1->input('Mail');
				$form1->type = "password";
				echo $form1->input('Password');
				echo $form1->input('Password_Check');
				echo $form1->submit("Registration");
				unset($form1);
	?>
	<p></p><p>You will receive a confirmation email</p>
	<div class="linediv"></div>
	<p class="pright"><a href="index.php?p=login">Sign Up</a></p>
	<p class="pright"><a href="index.php?p=faccount">Forgot account?</a></p>
</div>
