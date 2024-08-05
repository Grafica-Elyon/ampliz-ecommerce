<?php 
use MisterPrint\BO\Produto;
use MisterPrint\Support\View;
?>
	<div class="mp-tab" style=" display: flex; flex-flow: row wrap; justify-content: center;">
		<div class="mp-row" style="width: 100%;display:block; padding: 10px 20px; text-align: center;">
			<div class="mp-category-content mp-heading">
				<div class="mp-heading-line">
					<h1 class="mp-category-title mp-head"><?= $this->data['master'] ?></h1>
				</div>
			</div>
		</div>
		
<?php 
	$subcategorias = $this->data['subcats'];
	foreach($subcategorias as $item){
		$host = strpos($_SERVER['HTTP_HOST'], "localhost") !== false ? "ampliz.com.br" : $_SERVER['HTTP_HOST'];
		$url_item = "https://{$host}/configuracao/{$item['slug']}/{$item['codigoMenu']}";
		$url = "https://{$host}/product/{$item['slug']}";
		$item['precoAPartirDe'] = number_format($item['precoAPartirDe'], 2,",","");
		$item['menorPrecoUnitario'] = number_format($item['menorPrecoUnitario'], 2,",","");
		?>
		<div class="mp-item">
		<div class="mp-card">
			<div class="mp-card-thumbnail
			<?= empty($item['labels']) ?'': 'has_img_label'; ?>"
			<?= empty($item['labels']) ?'': 'label="'.$item['labels'].'"'; ?>
			<?= $item['labels'] == null ?'':'style="background:'.$item['labelColors'].';"'; ?>
			>
				<?php if(!empty($item['urlImagem'])) { ?>
					<img src="<?= $item['urlImagem'] ?>" />
				<?php } else { ?>
					<?= new View('misc/async-image', $item['urlImagem']) ?>
				<?php } ?>
				<div class="mp-card-overlay mp-hide-small">
					<div class="mp-link-overlay">
						<a href="<?= $url ?>"><strong><i class="mp-icon mp-icon-list"></i>Ver detalhes</strong></a>
						<a href="<?php echo $url_item ?>" class="mp-btn mp-btn-primary">Configurar produto</a>
					</div>
				</div>
			</div>
			<div class="mp-card-caption">
				<h3 class="mp-card-title"><?php echo str_replace("*","",$item['nomeMenu']) ?></h3>
				<p class="mp-card-description" >
					<i><?php echo $item['descricao'] ?></i><br />
				</p>
				<?php if($this->data['params']['precos_ligados']){ ?>
				<p>
				A partir de <span class="money mp-primary-color"><?php echo $item['precoAPartirDe'] ?></span>
				<?php if ( $item['quantidadeMenorPreco'] ): ?>
					/ <?= $item['quantidadeMenorPreco'] ?>un
				<?php endif; ?>
				</p>
				<?php if ( $item['menorPrecoUnitario'] && $item['menorPrecoUnitarioQuantidade'] ): ?>
				<p>
					<?= $item['menorPrecoUnitarioQuantidade'] ?> un por apenas <strong>R$ <?= $item['menorPrecoUnitario'] ?></strong> / un
				</p>
				<?php endif; ?>
				<div class="mp-card-overlay mp-show-small" style="display: none;">
					<div style="margin:5px auto;display: block;width: fit-content;">
						<a class="mp-btn-black" href="<?= $url ?>" style="margin:10px 0px;display: block;"><i class="mp-icon mp-icon-list"></i>Ver detalhes</strong></a>
						<a href="<?php echo $url_item ?>" class="mp-btn mp-btn-primary">Configurar produto</a>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		</div>
	<?php
	}
	?>
	</div>

<style type="text/css">
	.mp-item{
		max-width: 250px;
		margin: 20px;
	}
	.mp-link-overlay .editar {
	    background: var(--primary-color);
	    padding: 10px 20px;
	    border-radius: 20px;
	}
	.text-sm-center{
		text-align: inherit;
	}
	@media (max-width:  480px){
		.text-sm-center{
			text-align: center;
		}
	}
</style>