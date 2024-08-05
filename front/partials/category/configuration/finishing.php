<?php 
	$name = @$this->data['name'] ?: 'configuration_finishing';
	$this->data['item'] = is_array($this->data['item']) ? $this->data['item'] : [];
 ?>
<div class="finishing-options">
	<h3 class="mp-painel-title"><?= $this->data['titulo']?></h3>
	<?php if(!empty($this->data['items'])) { ?>
		<div class="mp-listing" data-item="2">
			<?php foreach($this->data['items'] as $key => $item) { ?>
				<?php
					if ( $item['grupo'] ) {
						if ( !isset($this->data['grouped-items']) )
							$this->data['grouped-items'] = [];

						if ( !isset($this->data['grouped-items'][$item['grupo']]) )
							$this->data['grouped-items'][$item['grupo']] = [];

						$this->data['grouped-items'][$item['grupo']][] = $item;

						continue;
					}
				?>
				<div class="mp-item" style="width:50%;">
					<label class="mp-checkbox">
						<?php 
						$checked = (in_array( $item['id'], $this->data['item'] )) ? 'checked data-previous-value="checked"' : ''; ?>
						<input class="finish-input" type="checkbox" name="<?= $name ?>" value="<?php echo $item['id'] ?>" data-slug="<?php echo $item['slug'] ?>" <?php echo $checked; ?>
							<?php if(isset($item['valor'])) echo "data-price='{$item['valor']}'" ?>
							<?php if(isset($item['quantidade'])) echo "data-price-quantity='{$item['quantidade']}'" ?>
							<?php if(isset($item['valor_setup'])) echo "data-price-setup='{$item['valor_setup']}'" ?>/>
						<span class="checkmark"></span>
						<div class="mp-checkbox-label"><strong><?php echo $item['nome'] ?></strong></div>
					</label>
				</div>
			<?php } ?>
		</div>

		<?php foreach ($this->data['grouped-items'] as $group => $items): //pra cada item como grupo > items?>
			<hr class="mp-divisor-simple">
			<div  class="mp-listing group-checkbox" data-item="3">
				<?php foreach ($items as $item): 	//pra cada item do grupo como item > dados?>		
					<div class="mp-item"  style="width:50%;">
						<label class="mp-checkbox">
							<?php $checked = (in_array( $item['id'], $this->data['item'] )) ? 'checked data-previous-value="checked"' : ''; ?>
							<input class="finish-input finish-input-grouped" type="radio" name="<?= $name ?>[<?= htmlspecialchars($group) ?>]" value="<?php echo $item['id'] ?>" data-slug="<?php echo $item['slug'] ?>" <?php echo $checked ?>
								<?php if(isset($item['valor'])) echo "data-price='{$item['valor']}'" ?>
								<?php if(isset($item['quantidade'])) echo "data-price-quantity='{$item['quantidade']}'" ?>
								<?php if(isset($item['valor_setup'])) echo "data-price-setup='{$item['valor_setup']}'" ?>/>
							<span class="checkmark"></span>
							<div class="mp-checkbox-label"><strong><?php echo $item['nome'] ?></strong></div>
						</label>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
	<?php } else { ?>
		<div class="mp-listing" data-item="3">
			<div class="mp-listing-empty"><?= $this->data['painel_2_sem_dados']?></div>
		</div>
	<?php } ?>
</div>
