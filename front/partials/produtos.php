<div class="row">
	<?php foreach ( $this->data as $produto ) : ?>
		<div class="col-md-3 mb-4">
			<div class="card text-center item-<?php echo $produto['id']?>">
				<div class="card-header"><?php echo $produto['nome']?></div>
				<?php if ( ! empty( $produto['urlImagem'] ) ) : ?>
					<img class="card-img-top" src="<?php echo $produto['urlImagem'] ?>" alt="<?php echo $produto['nome']?>">
				<?php else : ?>
					<img class="card-img-top" src="http://via.placeholder.com/260x130/cdd3d8/0275d8/?text=IMAGE" alt="Placeholder">
				<?php endif ?>
				<div class="card-block">
					<p>
						A partir de R$<?php echo $produto['precoAPartirDe'] ?>
						<?php if ( $this->data['price_quant'] ): ?>
							/<?= $this->data['price_quant'] ?>un
						<?php endif; ?>
					</p>
					<?php if ( $this->data['menorPrecoUnitario'] && $this->data['menorPrecoUnitarioQuantidade'] ): ?>
						<p>
							Ou R$ <?= $this->data['menorPrecoUnitario'] ?>/un em <?= $this->data['menorPrecoUnitarioQuantidade'] ?> un
						</p>
					<?php endif; ?>
					<p class="card-text"><a href="loja?categoria=<?php echo $produto['id']?>" class="btn btn-primary">Visualizar</a></p>
				</div>
			</div>
		</div>
	<?php endforeach ?>
</div>
