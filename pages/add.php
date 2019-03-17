<?php
App\Table\Msg::msg();
?>
<h1>How do you want to add your photo</h1>
<div class="all">
	<div class="imgrp" id="imgrp">
			<a href="index.php?p=webcam"><div class="imglist">
			<h2>Use My Webcam</h2>
				<img src="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/css/img/webcam.png" alt="" class="img" />
			</div></a>
	</div>
	<div class="imgrp" id="imgrp">
	<a href="index.php?p=import"><div class="imglist">
				<h2>Import a picture</h2>
				<img src="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/css/img/import.png" alt=""  class="img" />
			</div></a>
	</div>
</div>