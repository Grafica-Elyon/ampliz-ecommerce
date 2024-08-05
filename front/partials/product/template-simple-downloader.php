<?php
use MisterPrint\Support\View;
$data = $this->data;

?>
<div class="<?= $data['class'] ?>">
	<strong><?= $data['text'] ?></strong>
	<div>
		<a class="mp-btn-link" href="<?= $data['link']['horizontal'] ?>">Horizontal</a>
		|
		<a class="mp-btn-link" href="<?= $data['link']['vertical'] ?>">Vertical</a>
	</div>
</div>