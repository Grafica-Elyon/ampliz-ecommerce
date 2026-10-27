<?php

// Só as bandeiras com regra de parcelamento cadastrada; sem o SVG a bandeira some da faixa.
$bandeirasAceitas = ['visa' => 'Visa', 'mastercard' => 'Mastercard', 'elo' => 'Elo', 'amex' => 'American Express'];
$dirBandeiras = config('plugin', 'path') . 'front/assets/imgs/bandeiras/';
$urlBandeiras = config('plugin', 'url') . 'front/assets/imgs/bandeiras/';
?>

<div id="formCartaoRede" class="mp-form mp-cartao" style="display: none;">

    <h3>Formulário de Cartão de Crédito</h3>
    <span id="messageRede"></span>

    <div class="mp-form-row">
        <div class="mp-form-col-5">
            <div class="mp-form-group mp-campo" data-campo="numero">
                <label for="cardNumber" class="mp-label">Número do Cartão</label>
                <?php // o selo ancora só no input: no .mp-form-group ele centraria no rótulo junto ?>
                <div class="mp-campo-controle">
                    <input type="text" class="mp-input" id="cardNumber" name="cardNumberRede"
                           inputmode="numeric" autocomplete="cc-number" placeholder="0000 0000 0000 0000">
                    <span id="bandeiraDetectada" class="mp-bandeira"></span>
                </div>
                <span class="mp-campo-msg" data-campo-msg></span>
            </div>
        </div>

        <?php // Par fora do grid: abaixo de 576px o _forms.scss força width 100% !important nas colunas ?>
        <div class="mp-form-col-5">
            <div class="mp-cartao-duo">
                <div class="mp-form-group mp-campo" data-campo="validade">
                    <label for="expiryDate" class="mp-label">Validade</label>
                    <input type="text" class="mp-input" id="expiryDate" name="cardExpiryRede"
                           inputmode="numeric" autocomplete="cc-exp" placeholder="MM/AA">
                    <input type="hidden" id="monthExpiryDate">
                    <input type="hidden" id="yearExpiryDate">
                    <span class="mp-campo-msg" data-campo-msg></span>
                </div>

                <div class="mp-form-group mp-campo" data-campo="cvv">
                    <label for="cvv" class="mp-label">Código CVV</label>
                    <input type="text" class="mp-input" id="cvv" name="cvvRede"
                           inputmode="numeric" autocomplete="cc-csc" placeholder="000">
                    <span class="mp-campo-msg" data-campo-msg></span>
                </div>
            </div>
        </div>
    </div>

    <div class="mp-form-row">
        <div class="mp-form-col-5">
            <div class="mp-form-group mp-campo" data-campo="nome">
                <label for="cardName" class="mp-label">Nome no Cartão</label>
                <input type="text" id="cardName" name="cardNameRede" class="mp-input"
                       autocomplete="cc-name" placeholder="Como está impresso no cartão">
                <span class="mp-campo-msg" data-campo-msg></span>
            </div>

            <div class="mp-form-group mp-campo" data-campo="cpf">
                <label for="cardCpf" class="mp-label">Número de CPF</label>
                <input type="text" id="cardCpf" name="cardCpfRede" class="mp-input"
                       inputmode="numeric" placeholder="000.000.000-00">
                <span class="mp-campo-msg" data-campo-msg></span>
            </div>

            <div class="mp-form-group">
                <label for="formatoPagamento" class="mp-label">Formato de Pagamento</label>
                <select id="formatoPagamento" name="formatoPagamentoRede" class="mp-select">
                    <option value="credito">Cartão de Crédito</option>
                    <option value="debito">Cartão de Débito</option>
                </select>
            </div>

            <?php if ($bandeirasAceitas) : ?>
                <div class="mp-bandeiras-aceitas">
                    <span class="mp-bandeiras-titulo">Bandeiras aceitas</span>
                    <ul>
                        <?php foreach ($bandeirasAceitas as $codigo => $nome) : ?>
                            <?php if (file_exists($dirBandeiras . $codigo . '.svg')) : ?>
                                <li>
                                    <img src="<?= esc_url($urlBandeiras . $codigo . '.svg') ?>"
                                         alt="<?= esc_attr($nome) ?>" width="50" height="32" loading="lazy">
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div class="mp-form-col-5">
            <div class="mp-form-group" id="parcelamentoGroup">
                <span class="mp-label" id="rotuloParcelamento">Opção de Parcelamento</span>
                <input type="hidden" id="parcelamento" name="parcelamentoRede" value="">
                <ul id="parcelamentoLista" class="mp-parcelas"
                    role="radiogroup" aria-labelledby="rotuloParcelamento"></ul>
            </div>
        </div>
    </div>

    <div class="mp-form-footer">
        <button type="button" id="buttonPagamentoRede" class="mp-btn-primary mp-link">Realizar Pagamento</button>
    </div>
</div>

<div id="overlay_rede" class="mp-overlay-pagamento">
    <div id="spinner_rede" class="mp-overlay-spinner"></div>
</div>
