<?php
	use MisterPrint\Support\View;
	$productList = $this->data;
?>
<table class="mp-table-sm">
	<thead>
		<tr>
			<th colspan="2">Produto</th>
			<th>Valor</th>
			<th>Prazo</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($productList as $product) { ?>
			<tr>
				<td>
					<?php
						if ( $product['upload'] == false ) {

							if(strpos($product['name'], 'Promocionais') !== false) {$nocut = 1;} else {$nocut = 0;}

							if ( $nocut == 0 ) {			
							echo (new View(
								'product/preview',
								[
									'order' => $product['order'],
									'qnt_paginas' => $product['qnt_paginas'],
									'tamanho' => $product['tamanho'],
									'tem_verso' => $product['tem_verso'],
									'type' => $product['preview_type'],
									'item' => $product['id']

								]
							))->get();	

							} else {

							echo (new View(
								'product/preview-no-cut',
								[
									'order' => $product['order'],
									'qnt_paginas' => $product['qnt_paginas'],
									'tamanho' => $product['tamanho'],
									'tem_verso' => $product['tem_verso'],
									'type' => $product['preview_type'],
									'item' => $product['id']

								]
							))->get();

							}

							
						}
					?>
					
					
				</td>
				<td><?= $product['name'] ?></td>
				<td><?= $product['value'] ?></td>
				<td>
					<?php if($product['days'] > 1) { ?>
						<?= $product['days'] ?> Dias
					<?php } else { ?>
						<?= $product['days'] ?> Dia
					<?php } ?>
				</td>
			</tr>
			<?php if ( $product['upload'] && false ): ?>
				<tr>
					<td colspan="3">
						<div class="mp-row mp-text-center">
							<?php
							echo (new View(
								'product/template-simple-downloader',
								[
									'text' => 'CorelDraw',
									'class' => 'mp-col-5',
									'links' => [
										'horizontal' => $product['corel']['horizontal'],
										'vertical' => $product['corel']['vertical'],
									]
								]
							))->get();


							echo (new View(
								'product/template-simple-downloader',
								[
									'text' => 'Illustrator',
									'class' => 'mp-col-5',
									'links' => [
										'horizontal' => $product['illustrator']['horizontal'],
										'vertical' => $product['illustrator']['vertical'],
									]
								]
							))->get();
							?>
						</div>
					</td>
				</tr>
			<?php endif; ?>
		<?php } ?>
	</tbody>
</table>
