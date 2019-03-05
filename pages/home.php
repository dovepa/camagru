<?php
App\Table\Msg::msg();
?>
<h1>test du home</h1>
<div class="all">
<div class="imgrp">
<?php foreach (App\Table\Img::getHome() as $img): ?>

<div class="imglist">
<?= $img->getImg(); ?>
</div>
<?php endforeach; ?>
</div>
<div class="menuitem">
<div class="menu">
<p >le menu est ici</p></div>
</div>
</div>