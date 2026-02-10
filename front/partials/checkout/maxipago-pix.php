<?php

use MisterPrint\Helper\Log;
$sellerId = $dados['seller']; //producao
$clientId = $dados['client']; //producao
$clientSecret = $dados['secret']; //producao 

//PARTE 2: DADOS DO CLIENTE
$franquia = config("plugin", "franquia");
$site = $_SERVER['HTTP_HOST'];
$filial = "";
if ($site != "localhost") {
    $filial = explode(".", $site)[0];
    $filial = $filial == "mrprint" ? "PRO" : ucwords($filial);
}
$usuario = user()->getData();
$usuario = json_decode(json_encode($usuario), true);
$orderid = user()->getId() . ":{$usuario['dadosCliente']['qtde_pedidos']}:{$filial}:{$franquia}";
$complemento = $usuario['dadosEndereco']['complemento'] == null ? "" : $usuario['dadosEndereco']['complemento'];
$id = user()->getId();
?>
<style>
    /* Estilo para o overlay e o spinner */
    #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    #spinner {
        width: 100px;
        height: 100px;
        background-color: #1e73be;
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

    #timer {
        font-size: 24px;
        font-weight: bold;
        display: none;
    }
</style>
<div id="overlay">
    <div id="spinner"></div> <!-- Spinner de carregamento -->
</div>

<div id="div_pix_maxipago" style="display: none; text-align: center;">
    <div id="timer" >00:00</div>
    <h3 class="mp-painel-title">QRCode para Pagamento via Pix</h3>
    <img id="qrcode" style="display: none; margin: 0 auto;" alt="QR Code para Pagamento via Pix">
</div>

<?php $apiConfig = mp_get_api_configuration(); ?>
<script>
    const apiBaseMaxiPagoPix = window.MrPrint && window.MrPrint.apiUrl
        ? window.MrPrint.apiUrl.replace(/\/$/, '')
        : "<?= esc_js( $apiConfig['apiBase'] ) ?>";
    const url2 = apiBaseMaxiPagoPix + '/v2/maxi-pago/solicitar-pix';
    const headers2 = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'User-Agent': "https://mrprint.com.br",
    };
    <?php if (!empty($apiConfig['authorization'])) : ?>
    headers2['Authorization'] = '<?= esc_js( $apiConfig['authorization'] ) ?>';
    <?php endif; ?>
    const order2 = {
        referenceNum: "<?php echo  $orderid; ?>",
        fraudCheck: 'Y',
        //customerIdExt: cardCpf.value, //CPF CLIENTE 
        formatoPagamento: "pix",
        customerId: "<?php echo user()->getId() ?>",
        payment: {
            chargeTotal: parseFloat(jQuery("[data-total-price]").attr('data-total-price')),
        }
    };
    const data2 = {
        order: order2
    };

    const radios = document.querySelectorAll('input[name="payment"]');
    // Tempo de vida do QR code em segundos
    let timeLeft = 600;
    const timerElement = document.getElementById('timer');

    // Função para formatar o tempo no formato MM:SS
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
    }
    // Atualiza o elemento do timer com o tempo formatado
    function updateTimer() {
        const expiredMessageDiv = document.getElementById('message_pix_expired');
            if (expiredMessageDiv) {
                expiredMessageDiv.remove();
            }
        timerElement.textContent = formatTime(timeLeft);
        if (timeLeft > 0) {
            timeLeft--;
        } else {
            if (expiredMessageDiv) {
                expiredMessageDiv.remove();
            }
            // Adiciona um texto após a div do timer
            timerElement.insertAdjacentHTML('afterend', '<div id="message_pix_expired">QR Code expirado.</div>');
        }
    }
    // Atualiza o timer a cada segundo
    const timerInterval = setInterval(updateTimer, 1000);
    let imgElementQrCode = document.getElementById('qrcode');
    // Adiciona um evento change a cada radio
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Seleciona a div que será mostrada/ocultada
            const divMaxiPagoPix = document.getElementById('div_pix_maxipago');
            const overlayMaxiPagoPix = document.getElementById('overlay');
            // Verifica se o radio selecionado tem o valor 'maxipago-pix'
            if (this.value === 'maxipago-pix') {
                overlayMaxiPagoPix.style.display = 'block';
                divMaxiPagoPix.style.display = 'inline';
                fetch(url2, {
                        method: 'POST',
                        headers: headers2,
                        body: JSON.stringify(data2)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                            showError('Não foi possível realizar o pagamento. Tente novamente mais tarde ou contate o suporte.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            timerElement.style.display = 'block';
                            //inicializa o timer com o valor definiado na tabela de banco de dados
                            timeLeft = data.expirationTime;
                            // Atualiza o timer
                            updateTimer();
                            imgElementQrCode.src = 'data:image/png;base64,' + data.imagem_base64;
                            imgElementQrCode.style.display = 'block';
                            overlayMaxiPagoPix.style.display = 'none';
                        } else {
                            overlayMaxiPagoPix.style.display = 'none';
                            timerElement.style.display = 'none';
                            imgElementQrCode.style.display = 'none';
                            showError(data.message);
                        }
                    })
                    .catch(error => {
                        overlayMaxiPagoPix.style.display = 'none';
                        timerElement.style.display = 'none';
                        imgElementQrCode.style.display = 'none';
                        console.error('Fetch error:', error.message);
                        console.error('Fetch error details:', error);
                    });
            } else {
                divMaxiPagoPix.style.display = 'none';
            }
        });
    });
</script>