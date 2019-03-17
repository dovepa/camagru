<script>
	scrollh();
</script>

<?php
App\Table\Msg::msg();
?>
<h1>Camagru - Home</h1>
<div class="all">
	<div class="imgrp" id="imgrp">
		<?php foreach (App\Table\Img::getHome(0) as $img){
		echo '<div class="imglist">'. $img->getImg().'</div>';
		}
		?>
	</div>

</div>