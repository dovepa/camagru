<script>
var id="<?php echo $_SESSION['auth']['id']; ?>";
scrollgal(id);
</script>

<?php
require_once "pages/montagewebcam.php";
App\Table\Msg::msg();
?>

<h1> Add a new Picture </h1>
<div class="all">

	<div class="imgrp" style="display:none;" id="yescam">
		<div class="imglist">
			<h2>Use your webcam</h2>
			<div class="select">
				<label>
				<img class="imgmin" src="../pages/css/img/f1.png"/>
				<input id="f1box" type="radio" name="img" value="pages/css/img/f1r.png" onclick="box(this)">
				</label>

				<label>
				<img class="imgmin" src="../pages/css/img/f2.png"/>
				<input id="f2box" type="radio" name="img" value="pages/css/img/f2r.png" onclick="box(this)">
				</label>

				<label>
				<img class="imgmin" src="../pages/css/img/f3.png"/>
				<input id="f3box" type="radio" name="img" value="pages/css/img/f3r.png" onclick="box(this)">
				</label>
				</div>
				<div class="test">
						<div class="camera">
						<video id="video"><p>Video stream not available.</p></video>
						<button id="startbutton" class="submit_fields"  style="display:none;" >Take photo</button>
					</div>
					<img id="f1rs" class="overdiv" style="display:none;" src="../pages/css/img/f1r.png"/>
					<img id="f2rs" class="overdiv" style="display:none;" src="../pages/css/img/f2r.png"/>
					<img id="f3rs" class="overdiv" style="display:none;" src="../pages/css/img/f3r.png"/>
				</div>



		</div><div class="imglist" style="display:none;" id="Submit">
		<h2>Previw, Describe And Send</h2>
		<form action='#' method='POST'>
			<div class="test">
					<canvas id="canvas"></canvas>
					<img id="f1rs2" class="overdiv" style="display:none;" src="../pages/css/img/f1r.png"/>
					<img id="f2rs2" class="overdiv" style="display:none;" src="../pages/css/img/f2r.png"/>
					<img id="f3rs2" class="overdiv" style="display:none;" src="../pages/css/img/f3r.png"/>
					</div>
					<textarea maxlength="230" rows="2" class="form_fields" name="desc" id="desc"></textarea>
					<input type="text" name="imagetake" id="imagetake" style="display:none;"/>
					<input type="text" name="filter" id="filter" style="display:none;"/>
					<button class="submit_fields"  type="submit" name="submit" value="submit">Submit</button>
			</form>
				</div>
				<button  class="submit_fields" onclick="window.location.href='index.php?p=webcam&op=reset'">Reset</button>
			</div>

			<div class="imgrp" id="notcam">
				<div class="imglist">
					 <h1>Camera not available.</h1>
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
<script src="../pages/js/webcam.js"></script>
