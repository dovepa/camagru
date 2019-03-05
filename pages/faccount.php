<?php
	use \App\HTML\Form;


	App\Table\Msg::msg();
?>

<div class="logindiv">
	<img src="pages/css/img/logo.png" class="logoimg">
	<div class="linediv"></div><h3> Forgot Account </h3><div class="linediv"></div>
	<?php
			$form1 = new Form();
				echo $form1->input('Mail');
				echo $form1->submit("Submit");
	?>
	<p>You will receive a confirmation email</p>
	<div class="linediv"></div>
	<p class="pright"><a href="index.php?p=registration">Create Account</a></p>
	<p class="pright"><a href="index.php?p=login">Login</a></p>
</div>