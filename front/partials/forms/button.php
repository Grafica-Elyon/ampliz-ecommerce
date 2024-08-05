<?php 
	$res = $this->data['data'];
	$url = home_url($res['url']);
?>
<a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-round vc_btn3-style-modern vc_btn3-color-green" href="<?= $url;?>" title=""><?= $res['texto']; ?></a>