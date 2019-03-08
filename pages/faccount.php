<?php
 if ($_POST['submit'] === 'Submit'){
	$auth = new App\Auth\dbAuth(App\Data::getDb());
	$auth->faccount($_POST['Username']);
 };



	use \App\HTML\Form;
	App\Table\Msg::msg();
?>

<div class="logindiv">
	<img src="pages/css/img/logo.png" class="logoimg">
	<div class="linediv"></div><h3> Forgot Password </h3><div class="linediv"></div>
	<?php
			$form1 = new Form();
				echo $form1->input('Username');
				echo $form1->submit("Submit");
				unset($form1);
	?>
	<p>You will receive a confirmation email</p>
	<div class="linediv"></div>
	<p class="pright"><a href="index.php?p=registration">Create Account</a></p>
	<p class="pright"><a href="index.php?p=login">Login</a></p>
</div>