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
        background-color: #000000; /* Ampliz: spinner preto */
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

<div id="div_pix_rede" style="display: none; text-align: center;">
    <span id="messageRedePix"></span>
    <div id="timer">00:00</div>
    <h3 class="mp-painel-title">QRCode para Pagamento via Pix</h3>
    <img id="qrcode" style="display: none; margin: 0 auto;" alt="QR Code para Pagamento via Pix">
    <h3 class="mp-painel-title">Após confirmação de pagamento</h3>
    <div class="mp-form-footer">
        <a href="<?php echo config('plugin', 'url_loja');?>/painel/meus-pedidos/" class="mp-btn-primary ">Clique aqui!</a><br>
    </div>
</div>

<script>
    const baseUrl = window.location.origin;
    const body = {
        amount: parseFloat(jQuery("[data-total-price]").attr('data-total-price')),
    };

    const radios = document.querySelectorAll('input[name="payment"]');
    // Tempo de vida do QR code em segundos (por exemplo, 5 minutos)
    let timeLeft = 600;
    // Referência ao elemento do timer
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

    // Seleciona a div que será mostrada/ocultada
    const divRedePix = document.getElementById('div_pix_rede');
    const overlayRedePix = document.getElementById('overlay');
    const messageRedePix = document.getElementById('messageRedePix');

    function showErrorPix(message) {
        messageRedePix.innerHTML = `<div class="alert alert-danger alert-dismissible" role="alert">
            <strong>Oops!</strong> ${message}
        </div>`;
    }
    // Adiciona um evento change a cada radio
    document.querySelector('input[type="radio"][data-payment="e-rede-pix"]').addEventListener('change', function() {
        if (this.checked) {
            messageRedePix.innerHTML = '';
            overlayRedePix.style.display = 'block';
            divRedePix.style.display = 'inline';
            body.amount = parseFloat(jQuery("[data-total-price]").attr('data-total-price'));
            jQuery.ajax({
                    method: 'POST',
                    url: wp.ajax_url,
                    data: { action: 'mp_erede_gerar_pix', data: body }
                })
                .done(data => {
                    if (data.success) {
                        timerElement.style.display = 'block';
                        timeLeft = data.expirationTime;
                        // Atualiza o timer imediatamente ao carregar a página
                        updateTimer();
                        imgElementQrCode.src = 'data:image/png;base64,' + data.qrCode;
                        imgElementQrCode.style.display = 'block';
                        overlayRedePix.style.display = 'none';
                    } else {
                        overlayRedePix.style.display = 'none';
                        timerElement.style.display = 'none';
                        imgElementQrCode.style.display = 'none';
                        showErrorPix('Não foi possível gerar o QR Code. Atualize a página e tente novamente.');
                    }
                })
                .fail(() => {
                    overlayRedePix.style.display = 'none';
                    timerElement.style.display = 'none';
                    imgElementQrCode.style.display = 'none';
                    if (!messageRedePix.innerHTML) {
                        showErrorPix('Não foi possível realizar o pagamento. Verifique sua conexão e tente novamente.');
                    }
                });
        } else {
            divRedePix.style.display = 'none';
        }
    });
</script>
