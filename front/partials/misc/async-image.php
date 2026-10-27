<?php
if ( is_array($this->data) ) {
	$src = $this->data['src'] ?? '';
	$class = $this->data['class'] ?? '';
	$alt_text_imagem = $this->data['alt_text_imagem'] ?? '';
} else {
	$src = is_string($this->data) ? $this->data : '';
	$class = '';
	$alt_text_imagem = '';
}
?>
<img
	class="mp-async-image <?= esc_attr($class) ?>"
	src="/wp-admin/admin-ajax.php?action=mp_processed_image_loading_product"
	data-src="<?= esc_attr($src) ?>"
	alt="<?= esc_attr($alt_text_imagem) ?>"
>
