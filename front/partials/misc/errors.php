<?php if(!empty($this->data['errors'])) { ?>
	<div class="mp-errors" style="display: block">
		<h4>Encontramos alguns erros!</h4>
		<div class="mp-errors-inner">
			<?php foreach($this->data['errors'] as $error) { ?>
				<div class="mp-field">
					<label class="mp-error"><?php echo $error ?></label>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>
