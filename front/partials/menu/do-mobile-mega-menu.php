<?php  
use MisterPrint\Support\View;
$data = $this->data['all'];
/*if(!$data){
	exit();
}*/
?>
<ul class="sub-menu" id="products-sub-menu">
	<?php  foreach($data as $produto){ 
			if (isset($produto['special_product']) && $produto['special_product']) {
				$url = get_product_url($produto['id'], $produto['name']);
				$urlConfiguration = $url;
			} else {
				$url = get_category_url($produto['id'], $produto['slug']);
			} 
		?>
	<li class="menu-item menu-item-type-post_type menu-item-object-product">
		<a href="<?php echo $url ?>"><?php echo '->'. $produto['name']; ?></a>
	</li>
	<?php } ?>
</ul>
<script type="text/javascript">
	jQuery("#products-mobile").click(function(){
		jQuery("#products-sub-menu").toggle();
	});
</script>