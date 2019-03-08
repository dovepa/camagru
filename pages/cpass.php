<?php
echo $_GET['user']."      ".$_GET['token'];
	if ($_POST['submit'] === 'Submit'){
		if (!empty($_GET['user']) && !empty($_GET['token']) && !empty($_POST['Password']) && !empty($_POST['Password_Check'])){
			$auth = new App\Auth\dbAuth(App\Data::getDb());
			if ($auth->cpass($_GET['user'],$_GET['token'], $_POST['Password'], $_POST['Password_Check']) === true){
				header('Location: index.php?p=login');
				$_SESSION['msg'][] = "Password Canged sucesfully";
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
	<img src="pages/css/img/logo.png" class="logoimg">
	<div class="linediv"></div><h3> Change Password </h3><div class="linediv"></div>
	<?php
			$form1 = new Form();
				$form1->type = "password";
				echo $form1->input('Password');
				echo $form1->input('Password_Check');
				echo $form1->submit("Submit");
				unset($form1);
	?>
	<p></p><p>You will receive a confirmation email</p>
	<div class="linediv"></div>
	<p class="pright"><a href="index.php?p=login">Sign Up</a></p>
	<p class="pright"><a href="index.php?p=faccount">Forgot account?</a></p>
</div>
