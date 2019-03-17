<?php
use App\Table\Landc;
App\Table\Msg::msg();
?>
<h1><?php $user = App\Table\Img::getGalusername(); echo ucfirst(strtolower($user->username));?>'s Picture </h1>

<div class="all">
<div class="imgrp">
<?php $img = App\Table\Img::getImgpage(); ?>

<div class="imglist">
<?php
echo $img->getImgnl();
$alandc = new Landc($img->id);
$alandc->share();
$alandc->getCom();
?>
</div></div>
