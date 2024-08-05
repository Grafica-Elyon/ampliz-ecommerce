<?php
use MisterPrint\Support\View;
$url_comprar = $this->data['products_id'] > 0 ? true : false;
?>
<div class="mp-card">
	<div class="mp-card-thumbnail">
		<?php if(!empty($this->data['imagem'])) { ?>
			<?= new View('misc/async-image', $this->data['imagem']) ?>
		<?php } else { ?>
			<img src="<?php echo config('plugin', 'url') ?>front/assets/imgs/logo.png" />
		<?php } ?>
		<div class="mp-card-overlay mp-hide-small">
			<a class="mp-link-overlay" href="<?php echo $this->data['url'] ?>">
				<strong class="editar">Comprar</strong>
			</a>
			<button fav-id="<?= $this->data['hash'] ?>" class="remover_favorito mp-btn">
				<img style="width:30px;filter: contrast(0) brightness(5);" src="<?php echo config('plugin', 'url') ?>front/assets/imgs/fav-on.svg"><span><strong>Remover</strong> dos favoritos</span>
			</button>
		</div>
	</div>
	<div class="mp-card-caption">
		<h3 class="mp-card-title"><?php echo $this->data['nome'] ?></h3>
		<p class="mp-card-description" >
			<?php if(isset($this->data['qtde'])){?>
				<strong>Quantidade:</strong> <i><?php echo $this->data['qtde'] ?></i><br />
				<strong>Prazo:</strong> <i><?php echo $this->data['prazo'] ?> DU</i><br />
			<?php } ?>
			<strong>Formato:</strong> <i><?php echo $this->data['favorito']['formato'] ?></i><br />
			<strong>Papel:</strong> <i><?php echo $this->data['favorito']['papel'] ?></i><br />
			<strong>Cor:</strong> <i><?php echo $this->data['favorito']['cor'] ?></i><br />
			<strong>Enobrecimento:</strong> <i><?php echo $this->data['favorito']['enobrecimento']?></i><br />
			<strong>Arte:</strong> <i><?php echo $this->data['favorito']['arte'] ?></i><br />
		</p>

	</div>
</div>

<style type="text/css">
	button.remover_favorito.mp-btn{
		width: 85%;
		font-weight: 300;
		font-size: 13px;
		margin-top: 50px;
	    background: transparent;
	    color: #fff;
	    text-decoration: none;
	    display: flex;
	    flex-direction: column;
	    align-items: center;
	    opacity: 0.5;
	}
	button.remover_favorito.mp-btn:hover {
	    opacity: 1;
	}
	.mp-link-overlay .editar {
	    background: var(--primary-color);
	    padding: 10px 20px;
	    border-radius: 20px;
	}
</style>