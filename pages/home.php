<?php
App\Table\Msg::msg();
?>
<h1>Camagru - Home</h1>
<div class="all">
	<div class="imgrp">
		<?php foreach (App\Table\Img::getHome(0) as $img){
		echo '<div class="imglist">'. $img->getImg().'</div>';
		}
		?>
	</div>
	<script>scrollh();</script>
	<div class="menuitem">
		<div class="menu">
		<?php App\HTML\Menu::menu(); ?>
		</div>
		</div>
</div>

