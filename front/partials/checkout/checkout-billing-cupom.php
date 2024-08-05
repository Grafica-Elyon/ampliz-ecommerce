<?php use MisterPrint\Support\View; ?>
<div class="mp-painel mp-painel-auto mp-mb-3">
	<div class="mp-painel-header">
		<h3 class="mp-painel-title">Cupom de Desconto</h3>
		<p>Caso possua cupom de desconto informe abaixo</p>
	</div>

	<div class="mp-painel-body">
		<div class="mp-form-group">
			<label class="mp-label">Possui cupom de desconto?</label>
			<input class="mp-input no-margin" type="text" name="coupon" value="<?php echo $this->data['coupon']['name'] ?>" placeholder="Digite o número do cupom" />
		</div>
		<div class="mp-text-right">
			<div class="mp-coupon-message pull-left mb-1">
				<?php if(isset($this->data['coupon']['success'])) { ?>
					<?php if($this->data['coupon']['success']) { ?>
						<div class="mp-success mp-tex-default-lg">
							O cupom foi aplicado com o valor de:
							<span class="mp-primary-color">
								<span class="value">
									<?php echo $this->data['coupon']['value'] ?>
								</span>
							</span>
						</div>
					<?php } else { ?>
						<div class="mp-error">Cupom invalido!</div>
					<?php } ?>
				<?php } ?>
			</div>
			<button type="button" class="mp-btn mp-btn-primary mp-add-coupon">Aplicar cupom</button>
		</div>
	</div>
</div>

<?php
	if(isset($this->data['coupon']['success'])) {
		echo (new View('data-layers/checkout-use-coupon', $this->data['coupon']))->get();
	}
?>
