<?php
if ($_POST['submit'] === 'Submit'){
	if (!empty($_POST['Comment'])){
		$com = $_POST['Comment'];
		$com = str_replace(array("\r", "\n"), ' ', $com);
		$auth = new App\Auth\dbAuth(App\Data::getDb());
		if ($auth->comment($com, $_GET['img']) === true){
			$_SESSION['msg'][] = "Done :)";
		}
	}else{
		$_SESSION['msg'][] = "Empty form";
	}
}
use App\Table\Landc;
App\Table\Msg::msg();
?>
<h1><?php $user = App\Table\Img::getGalusername(); echo ucfirst(strtolower($user->username));?>'s Picture </h1>

<div class="all">
<div class="imgrp">
<?php $img = App\Table\Img::getImgpage(); ?>

<div class="imglist">
<?php
echo $img->getImg();
$alandc = new Landc($img->id);
$alandc->share();
$alandc->postCom();
$alandc->getCom();
?>
</div></div>
<div class="menuitem">
<div class="menu">
<?php App\HTML\Menu::menu(); ?>
</div>
</div>