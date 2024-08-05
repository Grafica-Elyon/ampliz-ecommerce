<?php
use MisterPrint\Support\View;
$data = $this->data['params'];
?>
<div class="mp-user-panel">
	<div class="mp-heading">
		<div class="mp-heading-line">
			<h2 class="mp-head"><?= $data['titulo']?></h2>
		</div>
		<p><?= $data['subtitulo']?></p>
	</div>
	<div class="inner">
		<div class="sidebar" style="order:<?= $data['posicao_sidebar'] === 'right' ? '1': '0' ?>">
			<?= (new View('elements/menu-user-panel', ['params' => $data, 'active' => 'addresses']))->get() ?>
		</div>
		<main>
			<div class="mp-painel">
				<div class="mp-painel-header">
					<h3 class="mp-painel-title"><?= $data['titulo_painel']?></h3>
				</div>
				<div class="mp-painel-body">
					<?php $_GET['message'] = explode('?',$_SERVER['HTTP_REFERER'])[1];
					$_GET['message'] = urldecode(explode('=',$_GET['message'])[1]);
					if(isset($_GET['message'])){?>
					<div class="mp-flash errors">
						<div class="flash-body"><?= $_GET['message']; ?></div>
						<div class="close" style="background: #ffbebe;"></div>
					</div>
					<div class="mp-flash address-message hidden">
						<div class="flash-body"></div>
						<div class="close"></div>
					</div>
					<?php } ?>
					<table class="addresses mp-addresses-table">
						<thead>
							<tr>
								<th><?= $data['painel_endereco']?></th>
								<th><?= $data['painel_telefone']?></th>
								<th><?= $data['painel_acoes']?></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<a href="#" class="mp-btn-primary" id="add-address"><?= $data['botao_adicionar_endereco']?></a>
					<form action="#" id="save-address" class="mp-form">
						<input type="hidden" name="id" id="id">
						<h3><?= $data['formulario_titulo']?></h3>
						<div class="mp-form-row">
							<div class="mp-form-col-3">
								<div class="mp-form-group">
									<label class="mp-label" for="cep"><?= $data['formulario_cep']?></label>
									<input type="text" name="cep" id="cep" class="mp-input" required>
								</div>
							</div>
							<div class="mp-form-col-3">
								<div class="mp-form-group">
									<label class="mp-label" for="estado"><?= $data['formulario_estado']?></label>
									<select name="estado" id="estado" class="mp-select">
										<option value="">Estado</option>
										<?php foreach(config('states') as $key => $state) { ?>
											<option value="<?= $key ?>"><?= $state ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="mp-form-col-3">
								<div class="mp-form-group">
									<label class="mp-label" for="cidade"><?= $data['formulario_cidade']?></label>
									<input type="text" name="cidade" id="cidade" class="mp-input" required>
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="bairro"><?= $data['formulario_bairro']?></label>
									<input type="text" name="bairro" id="bairro" class="mp-input" required>
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="rua"><?= $data['formulario_rua']?></label>
									<input type="text" name="rua" id="rua" class="mp-input" required>
								</div>
							</div>
						</div>
						<div class="mp-form-row">
							<div class="mp-form-col-3">
								<div class="mp-form-group">
									<label class="mp-label" for="numero"><?= $data['formulario_numero']?></label>
									<input type="text" name="numero" id="numero" class="mp-input" required>
								</div>
							</div>
							<div class="mp-form-col-3">
								<div class="mp-form-group">
									<label class="mp-label" for="complemento"><?= $data['formulario_complemento']?></label>
									<input type="text" name="complemento" id="complemento" class="mp-input">
								</div>
							</div>
							<div class="mp-form-col-3">
								<div class="mp-form-group">
									<label class="mp-label" for="telefone"><?= $data['formulario_telefone']?></label>
									<input type="text" name="telefone" id="telefone" class="mp-input" required>
								</div>
							</div>
						</div>
						<div class="mp-form-footer">
							<button type="submit" class="mp-btn-primary mp-link"><?= $data['formulario_botao']?></button>
						</div>
					</form>
				</div>
			</div>
		</main>
	</div>
</div>
<style type="text/css">
.errors{
	display: flex;
	border-radius: 5px;
    width: 100%;
    background: #da302b;
    font-weight: bold;
    text-align: left;
    margin: 0px 0px 10px 0px;padding: 10px;
    width: 100%;
    background: #da302b !important;
    font-weight: bold;
    text-align: left;
    margin: 0px 0px 10px 0px;
}
.errors .close:after,
.errors .close:before
{
	background: #be0000 !important;
}
</style>