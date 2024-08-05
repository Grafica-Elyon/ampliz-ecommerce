<?php // Script responsável por adicionar o data-layer ?>

<script type="text/javascript">
	if ( typeof dataLayer == "undefined" ) dataLayer = [];
	<?php if ( is_string($this->data) ): ?>
		dataLayer.push(<?= $this->data ?>);
	<?php else: ?>
		dataLayer.push(<?= json_encode($this->data) ?>);
	<?php endif; ?>

	<?php if ( strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ): ?>
		console.log( "Data Layer Insert: ", JSON.stringify(dataLayer[dataLayer.length - 1], null, 2) );
	<?php endif; ?>
</script>
