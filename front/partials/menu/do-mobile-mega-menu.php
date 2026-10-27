<?php
use MisterPrint\Support\MenuTree;

$grupos = $this->data['grupos'];
$arvore = $this->data['arvore'];
?>
<div class="mp-megamenu-mobile" id="products-sub-menu" data-megamenu-mobile>
	<ul class="mp-megamenu-mobile__familias">
		<?php foreach ( $grupos as $grupo ) : ?>
			<li class="menu-item">
				<button
					type="button"
					class="mp-megamenu-mobile__familia"
					data-abrir-familia="<?php echo esc_attr( (int) $grupo['id'] ); ?>"
				>
					<?php echo esc_html( $grupo['nome'] ); ?>
				</button>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php foreach ( $grupos as $grupo ) :
		$grupoId = (int) $grupo['id'];
		$raizes = isset( $arvore[ $grupoId ] ) ? $arvore[ $grupoId ] : array();
		?>
		<div class="mp-megamenu-mobile__painel" data-painel-mobile="<?php echo esc_attr( $grupoId ); ?>">
			<div class="mp-megamenu-mobile__cabecalho">
				<button type="button" class="mp-megamenu-mobile__voltar" data-voltar aria-label="Voltar">‹</button>
				<span><?php echo esc_html( $grupo['nome'] ); ?></span>
				<button type="button" class="mp-megamenu-mobile__fechar" data-fechar aria-label="Fechar menu">&times;</button>
			</div>

			<?php foreach ( $raizes as $raiz ) :
				$temFilhos = ! empty( $raiz['children'] );
				?>
				<div class="mp-megamenu-mobile__grupo<?php echo $temFilhos ? ' tem-filhos' : ''; ?>">
					<div class="mp-megamenu-mobile__item menu-item menu-item-object-product">
						<a href="<?php echo esc_url( MenuTree::url( $raiz ) ); ?>">
							<?php echo esc_html( MenuTree::nome( $raiz ) ); ?>
						</a>

						<?php if ( $temFilhos ) : ?>
							<button
								type="button"
								class="mp-megamenu-mobile__expandir"
								data-expandir
								aria-expanded="false"
								aria-label="Ver produtos de <?php echo esc_attr( MenuTree::nome( $raiz ) ); ?>"
							></button>
						<?php endif; ?>
					</div>

					<?php if ( $temFilhos ) : ?>
						<div class="mp-megamenu-mobile__filhos">
							<?php foreach ( $raiz['children'] as $filho ) : ?>
								<div class="mp-megamenu-mobile__item menu-item menu-item-object-product">
									<a href="<?php echo esc_url( MenuTree::url( $filho ) ); ?>">
										<?php echo esc_html( MenuTree::nome( $filho ) ); ?>
									</a>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
</div>
