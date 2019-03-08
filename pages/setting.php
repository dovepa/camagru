<?php

$switch = 2;
if ($_POST['onoffswitch'] === "on")
	$switch = 1;

if ($_POST['submit'] === 'Save'){
	if (!empty($_POST) || $switch != $_SESSION['auth']['mailcom']){
		$auth = new App\Auth\dbAuth(App\Data::getDb());
		$auth->setting($_POST['New_Username'], $_POST['New_Mail'], $_POST['Old_Password'], $_POST['New_Password'], $_POST['New_Password_Confirm'], $switch);
	}else{
		$_SESSION['msg'][] = "Empty form";
	}
}

use \App\HTML\Form;
App\Table\Msg::msg();
?>
<h1>Hello <?=  ucfirst(strtolower($_SESSION['auth']['username']));?>,</h1>
<h3>You want to change something ?</h3>
<div class="all">
<div class="imgrp">
<div class="editlst">
<?php
			if ($_SESSION['auth']['mailcom'] === 1)
				$pic = true;
			else
				$pic = false;
			$form1 = new Form();
			echo '<p>You want to change your username,</p>';
				echo $form1->input('New_Username');
			echo '<p>You want to change your mail,</p>';
				echo $form1->input('New_Mail');
			echo '<p>You want to change your Password,</p>';
				$form1->type = "password";
				echo $form1->input('Old_Password');
				echo $form1->input('New_Password');
				echo $form1->input('New_Password_Confirm');
			echo '<p>Receive an email when a user comments my photo,</p>';
				echo $form1->toggle($pic);
			echo $form1->submit("Save");
			unset($form1);
	?>
</div>
</div>
<div class="menuitem">
<div class="menu">
<?php App\HTML\Menu::menu(); ?>
</div>
</div>