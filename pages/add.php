<script>
var offset = 10
var id="<?php echo $_SESSION['auth']['id']; ?>";
window.onscroll = function() {
	scrollgal(id);
	menu();
	}
</script>
<?php
App\Table\Msg::msg();
?>
<h1>Camagru - Home</h1>
<div class="all">
<div class="menuitem">
		<div class="menu"  id="menu">
		<?php App\HTML\Menu::menu(); ?>
		</div>
		</div>

	<div class="imgrp">
		<div class="imglist">
		<h1> Add a new Picture </h1>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>


<div class="main">
		<div class="select">
		<img class="imgmin" src="../pages/css/img/f1.png"></img>
		<input id="f1.png" type="radio" name="img" value="../pages/css/img/f1.png" onclick="onCheckBoxChecked(this)">
		<img class="imgmin" src="../pages/css/img/f2.png"></img>
		<input id="f2.png" type="radio" name="img" value="../pages/css/img/f2.png" onclick="onCheckBoxChecked(this)">
		<img class="imgmin" src="../pages/css/img/f3.png"></img>
		<input id="f3.png" type="radio" name="img" value="../pages/css/img/f3.png" onclick="onCheckBoxChecked(this)">
		</div>

<video width="100%" autoplay="true" id="webcam"></video>
          <div id="camera-not-available">CAMERA NOT AVAILABLE</div>
          <img id="hat" style="display:none;" src="../pages/css/img/f3.pn"></img>
          <img id="cigarette" style="display:none;" src="../pages/css/img/f3.pn"></img>
          <img id="cadre" style="display:none;" src="../pages/css/img/f3.pn"></img>
    		  <div class="capture" id="pickImage">
            <img class="camera" src="../pages/css/img/f3.pn"></img>
          </div>
          <canvas id="canvas" style="display:none;" width="640" height="480"></canvas>
          <div class="captureFile" id="pickFile">
            <img class="camera" src="../pages/css/img/f3.pn"></img>
          </div>
          <input type="file" id="take-picture" style="display:none;" accept="image/*">
        </div>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
		</div>
	</div>
	<div class="imgrp" id="imgrp">
		<?php
		$i = 0;
		foreach (App\Table\Img::getGal(0,$_SESSION['auth']['id']) as $img): ?>
		<?php $i++; ?>
		<?= $img->getImggal(); ?>
		<?php endforeach; ?>
		<?php
		if ($i === 0)
			echo '<h1>Your Gallery Is empty</h1>';?>
		</div>
</div>
<script src="../pages/js/pic.js"></script>
