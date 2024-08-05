<h3 class="mp-painel-title">Extras</h3>
<div class="mp-listing" data-item="2">
	<?php if(!empty($this->data['items'])) { ?>
		<?php foreach($this->data['items'] as $key => $item) { ?>
			<div class="mp-item">
				<label class="mp-checkbox">
					<?php $checked = ($this->data['item'] == $item) ? 'checked data-previous-value="checked"' : ''; ?>
					<input type="radio" name="configuration_extra" value="<?php echo $item ?>" <?php echo $checked ?> />
					<span class="checkmark"></span>
					<div class="mp-checkbox-label"><strong><?php echo $item ?></strong></div>
				</label>
			</div>
		<?php } ?>
	<?php } else { ?>
		<div class="mp-listing-empty">Nenhuma opção...</div>
	<?php } ?>
</div>
