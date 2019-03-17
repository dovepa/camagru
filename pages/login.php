<?php
	if ($_POST['submit'] === 'Login'){
		if (!empty($_POST['Username']) || !empty($_POST['Password'])){
			$auth = new App\Auth\dbAuth(App\Data::getDb());
				if ($auth->login($_POST['Username'], $_POST['Password'])){
					header('Location: index.php?home');
					$_SESSION['msg'][] = "Hello ".$_SESSION['auth']['username']. " !";
					exit;
				}
			else{
				$_SESSION['msg'][] = "Login or Password Error";
			}
		}
		else{
			$_SESSION['msg'][] = "Empty Form";
		}
	}
	use \App\HTML\Form;
	App\Table\Msg::msg();
?>

<script>scroll();</script>
<div class="logindiv">
	<img src="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/css/img/logo.png" class="logoimg">
	<div class="linediv"></div><h3> Login </h3><div class="linediv"></div>
	<?php
			$form1 = new Form();
				echo $form1->input('Username');
				$form1->type = "password";
				echo $form1->input('Password');
				echo $form1->submit("Login");
				unset($form1);
	?>
	<div class="linediv"></div>
	<p class="pright"><a href="index.php?p=registration">Create Account</a></p>
	<p class="pright"><a href="index.php?p=faccount">Forgot account?</a></p>

</div>

<h1>FEED.</h1>
<div id="post">

<?php
$i = 0;
foreach (App\Table\Img::getLog(0) as $img){
if (($i % 4) == 0)
	echo '<div class="flex-container">';
echo '<div class="item">'.$img->getImglog().'</div>';
$i++;
if (($i % 4) == 0)
	echo '</div>';

}
?>
</div>
<div ><h2>The END...</h2><br/></div>

