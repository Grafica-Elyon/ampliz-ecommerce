<?php
use MisterPrint\Support\MenuTree;

$grupos = $this->data['grupos'];
$arvore = $this->data['arvore'];
$primeiro = isset( $grupos[0] ) ? (int) $grupos[0]['id'] : 0;
?>
<div class="mp-megamenu" data-megamenu>
	<div class="mp-megamenu__familias" role="tablist">
		<?php foreach ( $grupos as $grupo ) :
			$grupoId = (int) $grupo['id'];
			$ativo = $grupoId === $primeiro;
			?>
			<button
				type="button"
				class="mp-megamenu__familia<?php echo $ativo ? ' is-active' : ''; ?>"
				data-familia="<?php echo esc_attr( $grupoId ); ?>"
				role="tab"
				aria-selected="<?php echo $ativo ? 'true' : 'false'; ?>"
			>
				<span class="mp-megamenu__familia-nome">
					<?php echo esc_html( $grupo['nome'] ); ?>
					<?php if ( ! empty( $grupo['badge'] ) ) : ?>
						<sup class="mp-megamenu__badge" style="<?php echo esc_attr( MenuTree::fundo( $grupo['badge_color'] ) ); ?>">
							<?php echo esc_html( $grupo['badge'] ); ?>
						</sup>
					<?php endif; ?>
				</span>
				<span class="mp-megamenu__chevron" aria-hidden="true"></span>
			</button>
		<?php endforeach; ?>
	</div>

	<div class="mp-megamenu__conteudo">
		<?php foreach ( $grupos as $grupo ) :
			$grupoId = (int) $grupo['id'];
			$raizes = isset( $arvore[ $grupoId ] ) ? $arvore[ $grupoId ] : array();
			?>
			<div
				class="mp-megamenu__painel<?php echo $grupoId === $primeiro ? ' is-active' : ''; ?>"
				data-painel="<?php echo esc_attr( $grupoId ); ?>"
				role="tabpanel"
			>
				<?php foreach ( $raizes as $raiz ) :
					$temFilhos = ! empty( $raiz['children'] );
					$url = MenuTree::url( $raiz );
					?>
					<div class="mp-megamenu__bloco<?php echo $temFilhos ? ' tem-filhos' : ''; ?>">
						<div class="mp-megamenu__item mp-megamenu__item--raiz">
							<a class="mp-megamenu__link" href="<?php echo esc_url( $url ); ?>">
								<?php echo esc_html( MenuTree::nome( $raiz ) ); ?>
								<?php if ( ! empty( $raiz['labels'] ) ) : ?>
									<span class="mp-megamenu__tag" style="<?php echo esc_attr( MenuTree::fundo( $raiz['labelColors'] ) ); ?>">
										<?php echo esc_html( $raiz['labels'] ); ?>
									</span>
								<?php endif; ?>
							</a>

							<?php if ( $temFilhos ) : ?>
								<button
									type="button"
									class="mp-megamenu__expandir"
									data-expandir
									aria-expanded="false"
									aria-label="Ver produtos de <?php echo esc_attr( MenuTree::nome( $raiz ) ); ?>"
								></button>
							<?php endif; ?>
						</div>

						<?php if ( $temFilhos ) : ?>
							<div class="mp-megamenu__filhos">
								<div class="mp-megamenu__rolagem">
									<?php foreach ( $raiz['children'] as $filho ) : ?>
										<a class="mp-megamenu__link mp-megamenu__link--filho" href="<?php echo esc_url( MenuTree::url( $filho ) ); ?>">
											<?php echo esc_html( MenuTree::nome( $filho ) ); ?>
											<?php if ( ! empty( $filho['labels'] ) ) : ?>
												<span class="mp-megamenu__tag" style="<?php echo esc_attr( MenuTree::fundo( $filho['labelColors'] ) ); ?>">
													<?php echo esc_html( $filho['labels'] ); ?>
												</span>
											<?php endif; ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>

				<?php if ( empty( $raizes ) ) : ?>
					<p class="mp-megamenu__vazio">Nenhum produto nesta categoria.</p>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
