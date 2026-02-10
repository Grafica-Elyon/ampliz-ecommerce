<?php
use MisterPrint\Support\View;
$data = $this->data['params'];
$this->data['favorites'] = json_decode($this->data['favorites'], true);
foreach($this->data['favorites'] as &$item){ 
	$item = json_decode(json_encode($item), true);
} 
?>

<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />
<div class="mp-user-panel">
	<div class="mp-heading">
		<div class="mp-heading-line">
			<h2 class="mp-head"><?= $data['titulo']?></h2>
		</div>
		<p><?= $data['subtitulo']?></p>
	</div>
	<div class="inner">
		<div class="sidebar" style="order:<?= $data['posicao_sidebar'] === 'right' ? '1': '0' ?>">
			<?= (new View('elements/menu-user-panel', ['params' => $data, 'active' => 'favorites']))->get(); ?>
		</div>
		<main>
			<div class="mp-painel favorites">
				<div class="mp-painel-header">
					<h3 class="mp-painel-title"><?= $data['titulo_painel']?></h3>
				</div>
				<div class="mp-painel-body">
					<div class="mp-tab-body">
						<div class="mp-row">
							<div class="mp-listing">
								<?php foreach ($this->data['favorites'] as $category) {?>
									<div class="mp-item">
										<?php  echo (new View('category/favorite-card', $category))->get(); ?>
									</div>
									
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
</div>
<script type="text/javascript">
jQuery('.remover_favorito').click(function(){
		var defaultStoreUrl = "<?= rtrim( esc_url( config('plugin', 'url_loja', home_url('/') ) ), '/' ) ?>";
		var base_url = (window.MrPrint && window.MrPrint.storeUrl)
			? window.MrPrint.storeUrl
			: defaultStoreUrl || ("https://" + window.location.hostname);

		jQuery('#salvar_favorito').attr('disabled', "true");
		jQuery('.loader').css('display', "block");
		var params = jQuery(this).attr('fav-id');
		console.log(params);
		var url = base_url+'/wp-admin/admin-ajax.php?action=mp_remove_favorite&id='+params;		
		fetch(url).then(function(response) {
			jQuery('.loader').css('display', "none");
			if(response){
				alert('Item removido dos seus favoritos');
				window.location.reload();
			}else{
				alert("Erro ao remover o item dos favoritos");
			}
		});
	});
</script>
<style type="text/css">
.mp-painel.favorites .mp-item {
    width: 100%;
    float: left;
    padding-left: 15px;
    padding-right: 15px;
    max-width: 273px;
}
</style>
