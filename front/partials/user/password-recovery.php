<?php

use MisterPrint\Support\View;
use app\Http\UserController;

$data = $this->data['params'];
$errors = $this->data['errors'];
?>

<div class="mp-painel">
	<div class="mp-painel-header">
		<h3 class="mp-painel-title">Problemas para entrar?</h3>
	</div>
	<form method="POST" action="/wp-admin/admin-ajax.php" class="mp-form">
		<input type="hidden" name="action" value="mp_recovery_password">
		<div class="mp-painel-body">

			<?php
			if ($errors == ['Cliente não encontrado']) {
				echo new View('misc/errors', ['errors' => $errors]);
			}
			?>

			<?php
			if ($errors == ['Email enviado com sucesso']) {
				echo new View('misc/success', ['errors' => $errors]);
			}
			?>

			<label>Insira seu E-mail e CPF/CNPJ </label><br>
			<input style="width: 300px;" class="mp-input" type="text" name="email" autocomplete="on" value="<?php @$_POST['email'] ?>" placeholder="E-mail" /> <br>

			<input style="width: 300px;" class="mp-input" type="text" name="cpf/cnpj" value="<?= @$data['cpf/cnpj'] ?>" autocomplete="off" placeholder="CPF/CNPJ" />

			<button name="enviar" value="enviar" action="{{route(recuperacao-senha)}}" method="POST" type="submit" class="mp-btn-primary mp-link">Enviar</button>
		</div>
	</form>
</div>