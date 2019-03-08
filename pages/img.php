<?php
App\Table\Msg::msg();
?>
<h1><?php $user = App\Table\Img::getGalusername(); echo ucfirst(strtolower($user->username));?>'s Picture </h1>

<div class="all">
<div class="imgrp">
<?php $img = App\Table\Img::getImgpage(); ?>

<div class="imglist">
<?= $img->getImg(); ?>
</div>
</div>
<div class="menuitem">
<div class="menu">
<?php App\HTML\Menu::menu(); ?>
</div>
</div>