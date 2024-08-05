<?php
use MisterPrint\Support\View;
$order = $this->data['order'];
$item  = $this->data['item'];
$qtdPag= $this->data['qnt_paginas'] ?: 1;
$type  = $this->data['type'];
$tam   = $this->data['tamanho'];
$verso = $this->data['tem_verso'];
$types = ['normal','pre-corte','3d'];

if ( !in_array($type, $types) ) {
	$type = $types[0];
}

$fullWhiteSvg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAAAAAA6fptVAAAACXBIWXMAAAAnAAAAJwEqCZFPAAAAB3RJTUUH4wwQDjEIC/XbmAAAAAxpVFh0Q29tbWVudAAAAAAAvK6ymQAAAApJREFUCNdj+A8AAQEBABu27lYAAAAASUVORK5CYII=';

?>
<div data-component="mp_preview_art"
	data-ajax="0"
	class="no-style-component mp-preview-art mp-preview-art-<?= $type ?>">
	<div class="mp-preview-art-icon">
		<img src="<?php echo config('plugin','thumbs');?><?= $order ?>/<?= $item ?>/thumbs/small-resized-1.png">
	</div>
	<div class="mp-preview-art-preview" data-show="false">
		<div class="mp-painel">
			<div class="mp-painel-header">
				<span class="mp-painel-title-sm">
					Visualização de Arte
				</span>
				<span class="mp-painel-close">x</span>
			</div>
			<div class="mp-painel-body">
				
				<div class="mp-preview mp-preview-normal" <?php if ( $type != 'normal' ) echo 'style="display: none;"' ?>>
					<?php foreach (range( 1, $qtdPag ) as $page): ?>
						<div class="mp-preview-image<?= $page==1?' active':'' ?> 
						     mp-preview-sangria mp-preview-corte"
						     data-art="<?= $page ?>" 
						     style="
						     --image-width: <?= $tam['width'] ?>;
						     --image-height: <?= $tam['height'] ?>;
						     --image-sangria: 0;
						     --image-corte: 0;
						     --image-protecao: 0;
						     border: 7px solid #fff; 
						     box-shadow: 15px 15px 15px rgba(0,0,0,0.4);						     
						     "> 
							

							<div class="mp-preview-image-base">
								<img src="<?php echo config('plugin','thumbs');?><?= $order ?>/<?= $item ?>/thumbs/large-resized-<?= $page ?>.png">
								<!-- <div class="mp-preview-image-sangria"></div>
								<div class="mp-preview-image-corte"></div> 
								<div class="mp-preview-image-protecao"></div>
 -->							</div>
						</div>
					
				<?php endforeach; ?>
					<div id="preview-pagination-normal" class="preview-pagination mp-item">
						<?php echo (new View('category/pagination', ['pagination' => ['total' => $qtdPag, 'current' => 1]]))->get() ?>
					</div>
					<!-- <div class="mp-preview-legend" style="display: flex; align-items: center; justify-content: center; width: 100%;">
						<span class="mp-preview-legend-corte"> Corte </span>
						<span class="mp-preview-legend-protecao"> Proteção de texto </span>
					</div> -->
				</div>
			

				<div class="mp-preview mp-preview-3d" <?php if ( $type != '3d' ) echo 'style="display: none; display: flex; justify-content: center; align-items: center; flex-direction: column;"' ?>>
					<?php if ( $verso ): ?>
						<?php foreach (range( 1, ceil($qtdPag/2) ) as $page): ?>
							<div class="mp-preview-image<?= $page==1?' active':'' ?>" data-art="<?= $page ?>" style="
							--image-width: <?= $tam['width'] ?>;
							--image-height: <?= $tam['height'] ?>;
							--image-sangria: 0;
							margin: 10px; 
							padding: 5px;
							">
								<div class="mp-preview-image-base mp-preview-image-flip">
									<img src="<?php echo config('plugin','thumbs');?><?= $order ?>/<?= $item ?>/thumbs/large-resized-<?= $page*2 - 1 ?>.png" style="border: 6px solid #fff; box-shadow: 12px 10px 10px rgba(0,0,0,0.4);">
									<?php if ( $page*2 <= $qtdPag ): ?>
										<img src="<?php echo config('plugin','thumbs');?><?= $order ?>/<?= $item ?>/thumbs/large-resized-<?= $page*2 ?>.png">
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
						<div id="preview-pagination-3d" class="preview-pagination">
							<?php echo (new View('category/pagination', ['pagination' => ['total' => ceil($qtdPag/2), 'current' => 1]]))->get() ?>
						</div>
					<?php else: ?>
						<?php foreach (range( 1, $qtdPag ) as $page): ?>
							<div class="mp-preview-image<?= $page==1?' active':'' ?>" data-art="<?= $page ?>" style="--image-width: <?= $tam['width'] ?>;--image-height: <?= $tam['height'] ?>;--image-sangria: <?= $tam['sangria'] ?>;">
								<div class="mp-preview-image-base mp-preview-image-flip">
									<img src="<?php echo config('plugin','thumbs');?><?= $order ?>/<?= $item ?>/thumbs/large-resized-<?= $page ?>.png" style="
											border: 7px solid #fff !important; 
											box-shadow: 12px 10px 15px rgba(0,0,0,0.4);
											outline-offset: 0;
										">
									<img src="<?= $fullWhiteSvg ?>">
								</div>
							</div>
						<?php endforeach; ?>
						<div id="preview-pagination-3d" class="preview-pagination">
							<?php echo (new View('category/pagination', ['pagination' => ['total' => $qtdPag, 'current' => 1]]))->get() ?>
						</div>
					<?php endif; ?>
				</div>


				<div class="mp-form-group mp-form-group mp-mt-1">
					<div class="mp-btn-group mp-btn-group-selection" style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 0 25px;">
						<button
							style="width: 33.3%"
							class="mp-btn mp-btn-sm <?= $type != 'normal' ? 'mp-btn-darker-transparent' : 'mp-btn-primary'?>"
							type="button"
							value="normal">
							Cortado 
						</button>
						
						<button
							style="width: 33.3%"
							class="mp-btn mp-btn-sm <?= $type != '3d' ? 'mp-btn-darker-transparent' : 'mp-btn-primary'?>"
							type="button"
							value="3d">
							3D
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
