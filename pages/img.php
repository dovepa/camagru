<?php
App\Table\Msg::msg();
?>
<h1>IMG</h1>

<div class="all">
<div class="imgrp">
<?php $img = App\Table\Img::getImgpage(); ?>

<div class="imglist">
<?= $img->getImg(); ?>
</div>
</div>
<div class="menuitem">
<div class="menu">
<p >le menu est ici</p></div>
</div>
</div>