<?php
	if ( !is_string($this->data) ) {
		$this->data['src'] = $this->data;
		if ( !(@$this->data['src']) ) {
			$this->data['src'] = '';
		}
		if ( !(@$this->data['class']) ) {
			$this->data['class'] = '';
		}
	}
?>
<img
	class="mp-async-image"
	src="/wp-admin/admin-ajax.php?action=mp_processed_image_loading_product"
	data-src="<?= $this->data ?>"
>
