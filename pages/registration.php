<?php
	$to      = 'dove-dove@live.fr';
	$subject = 'the subject';
	$message = 'hello';
	$headers = array(
		'From' => 'dove.dove@free.fr',
		'Reply-To' => 'dove.dove@free.fr',
		'X-Mailer' => 'PHP/' . phpversion()
	);
	if (mail($to, $subject, $message, $headers))
	{
		echo "ok";
	}
	else
	{
		echo "ko";
	}
die();
	if (!empty($_POST)){
		$auth = new App\Auth\dbAuth(App\Data::getDb());
		if ($auth->regist($_POST['Username'], $_POST['Mail'], $_POST['Password'], $_POST['Password Check']) === true){
			header('Location: index.php?p=login');
		}
	}
	use \App\HTML\Form;
?>
<?php
App\Table\Msg::msg();
?>

<div class="logindiv">
	<img src="../public/css/img/logo.png" class="logoimg">
	<div class="linediv"></div><h3> Login </h3><div class="linediv"></div>
	<?php
			$form1 = new Form();
				echo $form1->input('Username');
				echo $form1->input('Mail');
				$form1->type = "password";
				echo $form1->input('Password');
				echo $form1->input('Password Check');
				echo $form1->submit("Registration");
	?>
	<p></p><p>You will receive a confirmation email</p>
	<div class="linediv"></div>
	<p class="pright"><a href="index.php?p=login">Sign Up</a></p>
	<p class="pright"><a href="index.php?p=faccount">Forgot account?</a></p>
</div>
