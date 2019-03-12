<script>
var offset = 10
var id="<?php echo $_GET['id']; ?>";
window.onscroll = function() {
	scrollgal(id);
	menu();
	}
</script>

<?php
App\Table\Msg::msg();
?>

<h1><?php $user = App\Table\Img::getGalusername(); echo ucfirst(strtolower($user->username));?>'s Gallery
</h1>

<div class="all">
<div class="imgrp" id="imgrp">
<?php
$i = 0;
foreach (App\Table\Img::getGal(0,$_GET['id']) as $img): ?>
<?php $i++; ?>
<?= $img->getImggal(); ?>
<?php endforeach; ?>
<?php
if ($i === 0)
	echo '<h1>Your Gallery Is empty</h1>';?>
</div>

<div class="menuitem">
<div class="menu" id="menu">
<?php App\HTML\Menu::menu(); ?>
</div>
</div>
</div>
