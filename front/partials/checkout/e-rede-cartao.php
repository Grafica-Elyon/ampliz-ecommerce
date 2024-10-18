<?php

$sellerId     = $dados['seller']; //producao
$clientId     = $dados['client']; //producao
$clientSecret = $dados['secret']; //producao


//PARTE 2: DADOS DO CLIENTE
$franquia = config( "plugin", "franquia" );
$site     = $_SERVER['HTTP_HOST'];
$filial   = "";
if ( $site != "localhost" ) {
	$filial = explode( ".", $site )[0];
	$filial = $filial == "mrprint" ? "PRO" : ucwords( $filial );
}
$usuario = user()->getData();
$usuario = json_decode( json_encode( $usuario ), true );
$orderid = user()->getId() . ":{$usuario['dadosCliente']['qtde_pedidos']}:{$filial}:{$franquia}";

?>
<style>
	/* Estilo para o overlay e o spinner */
	#overlay_rede {
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5);
		z-index: 1000;
	}

	#spinner_rede {
		width: 100px;
		height: 100px;
		background-color: #000000;
		border-radius: 50%;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		animation: spin 1s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
	}

	@keyframes spin {
		0% {
			transform: translate(-50%, -50%) rotateY(0deg);
		}

		100% {
			transform: translate(-50%, -50%) rotateY(360deg);
		}
	}
</style>


<!-- START formulário de cartão de crédito REDE -->
<div id="formCartaoRede" method="post" class="mp-form" style="display: none;">
	<h3>Formulário de Cartão de Crédito</h3>
	<span id="messageRede"></span>
	<br>
	<div class="mp-form-row">
		<div class="mp-form-col-4">
			<div class="mp-form-group">
				<label for="cardNumber" class="mp-label">Número do Cartão</label>
				<input type="text" class="mp-input" id="cardNumber" name="card-number" placeholder="1234 1234 1234 1234"
					   title="Digite um número de cartão válido com 16 dígitos" maxlength="16">
			</div>
		</div>

		<div class="mp-form-col-2">
			<div class="mp-form-group">
				<label for="expiryDate" class="mp-label">Mês/Validade</label>
				<input type="text" class="mp-input month-expiry-date" id="monthExpiryDate" name="monthExpiryDate"
					   placeholder="12" title="Digite uma data de expiração válida no formato MM" maxlength="2">
			</div>
		</div>

		<div class="mp-form-col-2">
			<div class="mp-form-group">
				<label for="expiryDate" class="mp-label">Ano/Validade</label>
				<input type="text" class="mp-input year-expiry-date" id="yearExpiryDate" name="yearExpiryDate"
					   placeholder="2030" title="Digite uma data de expiração válida no formato AAAA" maxlength="4">
			</div>
		</div>
		<div class="mp-form-col-2">
			<div class="mp-form-group">
				<label for="cvv" class="mp-label">Código CVV</label>
				<input type="text" class="mp-input" id="cvv" name="cvv" pattern="\d{3,4}" placeholder="123 ou 1234"
					   title="Digite um código CVV válido com 3 dígitos ou 4 dígitos" maxlength="4">
			</div>
		</div>
	</div>

	<div class="mp-form-row">

		<div class="mp-form-col-5">
			<div class="mp-form-group">
				<label for="cardName" class="mp-label">Nome no Cartão</label>
				<input type="text" id="cardName" name="cardName" class="mp-input" placeholder="Nome completo">
			</div>
		</div>

		<div class="mp-form-col-5">
			<div class="mp-form-group">
				<label for="cardCpf" class="mp-label">Número de CPF</label>
				<input type="text" id="cardCpf" name="cardCpf" class="mp-input cpf" placeholder="123.123.123-12" maxlength="11">
			</div>
		</div>
	</div>
	<div class="mp-form-row">
		<div class="mp-form-col-5">
			<div class="mp-form-group">
				<label for="formatoPagamento" class="mp-label">Formato de Pagamento</label>
				<select id="formatoPagamento" name="formatoPagamento" class="mp-select">
					<option value="credito">Cartão de Crédito</option>
					<option value="debito">Cartão de Débito</option>
				</select>
			</div>
		</div>

		<div class="mp-form-col-5">
			<div class="mp-form-group" id="parcelamentoGroup">
				<label for="parcelamento" class="mp-label">Opção de Parcelamento</label>
				<select id="parcelamento" name="parcelamento" class="mp-select">

				</select>
			</div>
		</div>
	</div>

	<div class="mp-form-footer">
		<button id="buttonPagamentoRede" class="mp-btn-primary mp-link">Realizar Pagamento</button>
	</div>

</div>
<!-- END formulário de cartão de crédito REDE -->
<div id="overlay_rede">
	<div id="spinner_rede"></div> <!-- Spinner de carregamento -->
</div>

<!-- jQuery Mask Plugin CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
	$(document).ready(function () {
		$('#monthExpiryDate').mask('00');
		$('#yearExpiryDate').mask('0000');
		$('#cvv').mask('0000');
		$('#cardCpf').mask('000.000.000-00');
		$('#cardNumber').mask('0000 0000 0000 0000');

		$('#monthExpiryDate, #yearExpiryDate, #cvv').on('input', function () {
			this.value = this.value.replace(/\D/g, '');
		});

		$('#cardCpf').on('blur', function () {
			let cpf = $(this).val().replace(/\D/g, '');
			/*if (cpf.length < 11) {
				$(this).val('');
			}*/
		});

	});
	let correctAnswerRede;

	function generateCaptchaRede() {
		const num_1 = Math.floor(Math.random() * 10) + 1;
		const num_2 = Math.floor(Math.random() * 10) + 1;
		correctAnswerRede = num_1 + num_2;
		document.getElementById('captchaQuestionRede').innerText = 'Quanto é ' + num_1 + ' + ' + num_2 + '? (Responda a pergunta para prosseguir com o pagamento)';
	}


	function validateCaptchaRede() {
		const captchaInputRede = document.getElementById('captcha-e-rede').value;
		if (parseInt(captchaInputRede) === correctAnswerRede) {
			document.getElementById('formCartaoRede').style.display = 'block';
			document.getElementById('captchaFormRede').style.display = 'none';
		} else {
			document.getElementById('formCartaoRede').style.display = 'none';

			alert('Resposta incorreta. Tente novamente.');
			generateCaptchaRede(); // Gera uma nova pergunta após uma resposta incorreta
		}
	}

	generateCaptchaRede();
	const overlayRede = document.getElementById('overlay_rede');

	document.getElementById('formatoPagamento').addEventListener('change', function () {

		var parcelamentoGroup = document.getElementById('parcelamentoGroup');
		if (this.value === 'debito') {
			parcelamentoGroup.style.display = 'none';
		} else {

			var parcelamentoSelect = document.getElementById('parcelamento');

			if (parseFloat(jQuery("[data-total-price]").attr('data-total-price')) <= 300.00) {
				// Adiciona apenas a opção de 1x
				jQuery('#parcelamento').html('<option value="1">1 Parcela</option>');
			} else {
				// Adiciona as opções de 1x, 2x e 3x
				jQuery('#parcelamento').html('<option value="1">1 Parcela</option><option value="2">2 Parcelas</option><option value="3">3 Parcelas</option>');
			}
			parcelamentoGroup.style.display = 'block';
		}
	});

	// Inicializar o estado do parcelamento ao carregar a página
	document.getElementById('formatoPagamento').dispatchEvent(new Event('change'));
	//submite do formulário de pagamento com cartão REDE.
	document.getElementById('buttonPagamentoRede').addEventListener('click', function (event) {
		event.preventDefault();
		var cardNumber = document.getElementById('cardNumber');
		var monthExpiryDate = document.getElementById('monthExpiryDate');
		var yearExpiryDate = document.getElementById('yearExpiryDate');
		var cvv = document.getElementById('cvv');
		var cardName = document.getElementById('cardName');
		var cardCpf = document.getElementById('cardCpf');
		var formatoPagamento = document.getElementById('formatoPagamento');
		var parcelamento = document.getElementById('parcelamento');

		var isValid = true;

		// Função para adicionar mensagem de erro
		function addError(input, message) {

			input.style.backgroundColor = 'rgb(255, 238, 238)';
			input.style.borderColor = 'rgb(255, 0, 0)';
			let formGroup = input.closest('.mp-form-group');
			formGroup.setAttribute('data-error', message);
		}

		// Função para remover mensagem de erro
		function removeError(input) {
			input.style.backgroundColor = '';
			input.style.borderColor = '';
			let formGroup = input.closest('.mp-form-group');
			formGroup.removeAttribute('data-error');
		}

		function showError(message) {
			var messageSpan = document.getElementById('messageRede');

			var alertHtml = `<div class="alert alert-danger alert-dismissible" role="alert">
          <strong>Oops!</strong> ${message}
        </div>`;

			// Insere o alerta no span
			messageSpan.innerHTML = alertHtml;
		}

		if (!cardNumber.value) {
			addError(cardNumber, 'O campo número do cartão é obrigatório!');
			isValid = false;
		} else {
			removeError(cardNumber);
		}

		if (!monthExpiryDate.value) {
			addError(monthExpiryDate, 'O campo mês de expiração é obrigatório!');
			isValid = false;
		} else {
			removeError(monthExpiryDate);
		}

		if (!yearExpiryDate.value) {
			addError(yearExpiryDate, 'O campo ano de expiração é obrigatório!');
			isValid = false;
		} else {
			removeError(yearExpiryDate);
		}

		if (!cvv.value) {
			addError(cvv, 'O campo CVV é obrigatório!');
			isValid = false;
		} else {
			removeError(cvv);
		}

		if (!cardName.value) {
			addError(cardName, 'O campo nome no cartão é obrigatório!');
			isValid = false;
		} else {
			removeError(cardName);
		}

		if (!cardCpf.value) {
			addError(cardCpf, 'O campo CPF do titular é obrigatório!');
			isValid = false;
		} else {
			removeError(cardCpf);
		}

		if (!['credito', 'debito'].includes(formatoPagamento.value)) {
			addError(formatoPagamento, 'O campo formato de pagamento é inválido!');
			isValid = false;
		} else {
			removeError(formatoPagamento);
		}

		// Verificação dos campos de select
		if (formatoPagamento.value === 'credito') {
			if (!parcelamento.value || !['1', '2', '3'].includes(parcelamento.value)) {
				addError(parcelamento, 'O campo opção de parcelamento é obrigatório e deve ser 1, 2 ou 3!');
				isValid = false;
			} else {
				removeError(parcelamento);
			}
		} else {
			removeError(parcelamento);
		}
		//se todos os campos do formulário de pagamento estiverem corretamente preenxidos o post será feito para o endpoint
		if (isValid) {
			overlayRede.style.display = 'block';
			//url do endpoint da api Mr Print para receber os dados de pagamento cartão REDE.
			const url = "<?php echo config( 'plugin', 'api' );?>" + 'rede/process-card-payment';
			const headers = {
				'Content-Type': 'application/json',
				'Accept': 'application/json',
				'Authorization': 'Basic ZXplcXVpZWxAc3R1ZGlvdmlzdWFsLmNvbS5icjpKVzJCM1RIeE1PanJPYjcxVGdTNlpzOWFDaG4yUm1ibHIwdUIxc1RTWnhwd2YxSlFvbVdnTTJmdDdyTGo='
			};
			const body = {
				reference: "<?php echo $orderid; ?>",
				amount: parseFloat(jQuery("[data-total-price]").attr('data-total-price')),
				card_number: cardNumber.value.replace(/\s+/g, ''),
				expiration_month: monthExpiryDate.value,
				expiration_year: yearExpiryDate.value,
				cvv: cvv.value,
				customer_id: "<?php echo user()->getId() ?>",
			};

			if (formatoPagamento.value === 'credito') {
				body.installments = parcelamento.value;
				body.payment_type = 'credit';
			} else if (formatoPagamento.value === 'debito') {
				body.payment_type = 'debit';
			}
			//disparando post para endpoint
			fetch(url, {
				method: 'POST',
				headers: headers,
				body: JSON.stringify(body)
			})
				.then(response => {
					if (!response.ok) {
						showError('Não foi possível realizar o pagamento. Tente novamente mais tarde ou contate o suporte.');
						return response.json().then(errorResponse => {
							throw new Error(errorResponse.message || 'Erro desconhecido');
						});

					}
					return response.json();
				})

				.then(data => {
					console.log(data);
					if (data.success) {
						window.location.reload();
					} else {
						overlayRede.style.display = 'none';
						showError(data.message);
					}
				})
				.catch(response => {
					overlayRede.style.display = 'none';
					console.error('Fetch error1:', response.message);
					console.error('Fetch error details:', error);
				});
		}


	});
</script>
