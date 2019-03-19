<script>
var id="<?php echo $_SESSION['auth']['id']; ?>";
scrollgal(id);
</script>

<?php
require_once "pages/montageimport.php";
App\Table\Msg::msg();
?>

<h1> Add a new Picture </h1>
<div class="all">
	<div class="imgrp">

		<?php
			if (empty($finalfile)){
				echo '	<div class="imglist">
				<h2>Choose a photo</h2>
				<form name="upload" method="post" action="" enctype="multipart/form-data">
					<label for="icone">File (JPG Format 1920w * 1440h, Max 20 Mo Respect That !) :</label>
					<input type="file" name="myfile" id="myfile"><br>
					<input class="submit_fields" type="submit" name="submit" value="Upload" />
				</form>
			</div>';
			}else{
				echo '<div class="imglist">
				<h2>Choose a filter, Previw, Describe And Send</h2>
				<form action="#" method="POST">
					<div class="select">
						<label>
						<img class="imgmin" src="../pages/css/img/f1.png"/>
						<input id="f1box" type="radio" name="img" value="pages/css/img/f1r.png" onclick="box(this.id)">
						</label>

						<label>
						<img class="imgmin" src="../pages/css/img/f2.png"/>
						<input id="f2box" type="radio" name="img" value="pages/css/img/f2r.png" onclick="box(this.id)">
						</label>

						<label>
						<img class="imgmin" src="../pages/css/img/f3.png"/>
						<input id="f3box" type="radio" name="img" value="pages/css/img/f3r.png" onclick="box(this.id)">
						</label>
					</div>

					<div class="test">
						<img src="'.$finalfile.'" alt="" class="imgtest">
						<img id="f1rs2" class="overdiv" style="display:none;" src="../pages/css/img/f1r.png"/>
						<img id="f2rs2" class="overdiv" style="display:none;" src="../pages/css/img/f2r.png"/>
						<img id="f3rs2" class="overdiv" style="display:none;" src="../pages/css/img/f3r.png"/>
					</div>
					<div class="down">
							<textarea maxlength="230" rows="2" class="form_fields" name="desc" id="desc"></textarea>
							<input type="text" name="imagepath" id="imagefilter" value="'.$finalfile.'" style="display:none;"/>
							<button class="submit_fields"  type="submit" name="submit" value="submit" style="display:none;" id="sub">Submit</button>
					</div>
					</form>
				</div>';
			} ?>
<button  class="submit_fields" onclick="window.location.href='index.php?p=import&op=reset'">Reset</button>
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
<script src="../pages/js/import.js"></script>
