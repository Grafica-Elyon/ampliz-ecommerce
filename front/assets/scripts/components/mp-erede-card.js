import {
    regrasDaBandeira,
    apenasDigitos,
    luhnValido,
    comprimentoValido,
    capacidadeDaMascara,
    validadeValida,
    partesDaValidade,
} from '../lib/cartao';

const DEBOUNCE_MS = 400;
const DIGITOS_BIN = 6;
const AGUARDANDO_CARTAO = 'Digite o número do cartão para ver as opções de parcelamento.';

export default function (el) {
    const form = document.getElementById('formCartaoRede');

    if (!form) return;

    const lista = document.getElementById('parcelamentoLista');
    const escolhida = document.getElementById('parcelamento');
    const grupo = document.getElementById('parcelamentoGroup');
    const cardNumber = document.getElementById('cardNumber');
    const expiry = document.getElementById('expiryDate');
    const mes = document.getElementById('monthExpiryDate');
    const ano = document.getElementById('yearExpiryDate');
    const cvv = document.getElementById('cvv');
    const cardName = document.getElementById('cardName');
    const cardCpf = document.getElementById('cardCpf');
    const formatoPagamento = document.getElementById('formatoPagamento');
    const bandeiraIcone = document.getElementById('bandeiraDetectada');
    const overlay = document.getElementById('overlay_rede');

    let cotacao = null;
    let bandeira = null;
    let sequencia = 0;
    let timer = null;
    let ultimaChave = null;

    function bin() {
        const digitos = apenasDigitos(cardNumber.value);
        return digitos.length >= DIGITOS_BIN ? digitos.substring(0, DIGITOS_BIN) : '';
    }

    function regras() {
        return regrasDaBandeira(bandeira && bandeira.identificada ? bandeira.codigo : null);
    }

    function usarSaldo() {
        return jQuery('[name="credito"]:checked').val() === 'utilizar';
    }

    function modalidade() {
        return formatoPagamento.value === 'debito' ? 'debit' : 'credit';
    }

    function mostrarErro(mensagem) {
        document.getElementById('messageRede').innerHTML =
            '<div class="alert alert-danger alert-dismissible" role="alert">' +
            '<strong>Oops!</strong> ' + mensagem + '</div>';
    }

    function limparErro() {
        document.getElementById('messageRede').innerHTML = '';
    }

    function aplicarMascaraDoNumero() {
        const mascara = regras().mascara;

        if (cardNumber.dataset.mascara === mascara) return;

        const digitos = apenasDigitos(cardNumber.value);

        // O jquery-mask redefine o maxlength e corta o excedente; quem barra o tamanho é a validação
        if (digitos.length > capacidadeDaMascara(mascara)) return;

        cardNumber.dataset.mascara = mascara;
        jQuery(cardNumber).unmask().mask(mascara);

        if (digitos) {
            // masked() só formata, não dispara input
            cardNumber.value = jQuery(cardNumber).masked(digitos);
        }
    }

    function aplicarMascaraDoCvv() {
        const digitos = regras().cvv;
        const mascara = '0'.repeat(digitos);

        if (cvv.dataset.mascara === mascara) return;

        cvv.dataset.mascara = mascara;
        cvv.placeholder = '0'.repeat(digitos);
        jQuery(cvv).unmask().mask(mascara);
    }

    function iniciarMascaras() {
        aplicarMascaraDoNumero();
        aplicarMascaraDoCvv();
        jQuery(expiry).mask('00/00');
        jQuery(cardCpf).mask('000.000.000-00');
    }

    const REGRAS = {
        numero: () => {
            const digitos = apenasDigitos(cardNumber.value);

            if (!digitos) return 'Informe o número do cartão.';

            const codigo = bandeira && bandeira.identificada ? bandeira.codigo : null;

            if (!comprimentoValido(digitos, codigo)) return 'Número incompleto.';
            if (!luhnValido(digitos)) return 'Número de cartão inválido.';

            return '';
        },
        validade: () => {
            if (!apenasDigitos(expiry.value)) return 'Informe a validade.';

            return validadeValida(expiry.value) ? '' : 'Validade inválida ou vencida.';
        },
        cvv: () => {
            const digitos = apenasDigitos(cvv.value);

            if (!digitos) return 'Informe o CVV.';

            return digitos.length === regras().cvv ? '' : `O CVV tem ${regras().cvv} dígitos.`;
        },
        nome: () => (cardName.value.trim() ? '' : 'Informe o nome impresso no cartão.'),
        cpf: () => {
            const digitos = apenasDigitos(cardCpf.value);

            if (!digitos) return 'Informe o CPF do titular.';

            return digitos.length === 11 ? '' : 'CPF incompleto.';
        },
    };

    const CAMPOS = {
        numero: cardNumber,
        validade: expiry,
        cvv: cvv,
        nome: cardName,
        cpf: cardCpf,
    };

    function grupoDoCampo(input) {
        return input.closest('[data-campo]');
    }

    function marcar(nome, mensagem) {
        const grupoCampo = grupoDoCampo(CAMPOS[nome]);

        if (!grupoCampo) return;

        const alvo = grupoCampo.querySelector('[data-campo-msg]');

        grupoCampo.classList.toggle('is-invalid', !!mensagem);
        grupoCampo.classList.toggle('is-valid', !mensagem && !!CAMPOS[nome].value);
        CAMPOS[nome].setAttribute('aria-invalid', mensagem ? 'true' : 'false');

        if (alvo) alvo.textContent = mensagem;
    }

    function prepararAcessibilidadeDosCampos() {
        Object.keys(CAMPOS).forEach((nome) => {
            const grupoCampo = grupoDoCampo(CAMPOS[nome]);
            const alvo = grupoCampo && grupoCampo.querySelector('[data-campo-msg]');

            if (!alvo) return;

            alvo.id = alvo.id || `mp-erro-${nome}`;
            alvo.setAttribute('role', 'alert');
            CAMPOS[nome].setAttribute('aria-describedby', alvo.id);
        });
    }

    function validarCampo(nome) {
        const mensagem = REGRAS[nome]();

        marcar(nome, mensagem);

        return !mensagem;
    }

    function validar() {
        const nomes = Object.keys(REGRAS);
        const invalidos = nomes.filter((nome) => !validarCampo(nome));

        if (invalidos.length) {
            // No celular o campo com erro fica fora da tela e o formulário parece travado
            const campo = CAMPOS[invalidos[0]];

            if (campo.scrollIntoView) campo.scrollIntoView({ block: 'center' });
            campo.focus();

            return false;
        }

        // O servidor só calcula o valor com o fingerprint; sem ele o débito seguia e tomava 422
        if (!cotacao || !cotacao.cart_fingerprint) {
            mostrarErro('Não foi possível calcular o valor. Revise o número do cartão e tente novamente.');
            return false;
        }

        if (modalidade() === 'credit' && !escolhida.value) {
            mostrarErro('Escolha uma opção de parcelamento.');
            return false;
        }

        return true;
    }

    function cotar(forcar = false) {
        clearTimeout(timer);

        if (!bin()) {
            sequencia++;
            cotacao = null;
            bandeira = null;
            ultimaChave = null;
            atualizarBandeira(null);
            renderizarIndisponivel(AGUARDANDO_CARTAO);
            return;
        }

        const chave = [bin(), modalidade(), usarSaldo() ? 1 : 0].join(':');

        // Do 7º dígito em diante o BIN não muda; sem isto cada tecla refaz frete e carrinho no servidor
        if (!forcar && chave === ultimaChave && temFaixas()) return;

        ultimaChave = chave;

        timer = setTimeout(() => {
            const requisicao = ++sequencia;

            carregando(true);

            jQuery.ajax({
                method: 'POST',
                url: wp.ajax_url,
                data: {
                    action: 'mp_erede_parcelas',
                    data: {
                        bin: bin(),
                        usar_saldo_conta_corrente: usarSaldo() ? 1 : 0,
                        payment_type: modalidade(),
                    },
                },
            }).done((resposta) => {
                if (requisicao !== sequencia) return;

                if (!resposta || resposta.response !== 'success') {
                    cotacao = null;
                    renderizarIndisponivel(resposta && resposta.message);
                    return;
                }

                cotacao = resposta;
                renderizar(resposta);
            }).fail(() => {
                if (requisicao !== sequencia) return;
                cotacao = null;
                renderizarIndisponivel();
            });
        }, DEBOUNCE_MS);
    }

    // O resumo segue com a última cotação boa durante a espera, para não piscar o acréscimo
    function carregando(ativo) {
        lista.setAttribute('aria-busy', ativo ? 'true' : 'false');

        if (!ativo) {
            lista.classList.remove('is-carregando');
            return;
        }

        lista.classList.add('is-carregando');
        lista.innerHTML = '<li class="mp-parcela-esqueleto"></li>'.repeat(3);
    }

    function renderizarIndisponivel(mensagem) {
        carregando(false);
        lista.innerHTML = '<li class="mp-parcelas-vazio">' +
            (mensagem || 'Não foi possível calcular o parcelamento agora.') + '</li>';
        escolhida.value = '';

        atualizarResumo();
    }

    function renderizar(resposta) {
        const opcoes = resposta.opcoes || [];

        carregando(false);
        atualizarBandeira(resposta.bandeira);

        if (!opcoes.length) {
            renderizarIndisponivel();
            return;
        }

        // Recotar refaz a lista; sem isto a escolha do cliente voltava para a primeira faixa
        const anterior = parseInt(escolhida.value, 10);
        const escolha = opcoes.some((opcao) => opcao.parcelas === anterior) ? anterior : opcoes[0].parcelas;

        lista.innerHTML = opcoes.map((opcao) => `
            <li class="mp-parcela ${opcao.parcelas === escolha ? 'is-selected' : ''}" data-parcelas="${opcao.parcelas}">
                <label>
                    <input type="radio" name="parcelaEscolhida" value="${opcao.parcelas}" ${opcao.parcelas === escolha ? 'checked' : ''}>
                    <span class="mp-parcela-principal">${opcao.label}</span>
                    <span class="mp-parcela-secundaria${opcao.sem_juros ? ' is-sem-juros' : ''}">${opcao.label_secundaria}</span>
                    <span class="mp-parcela-total">${opcao.label_total}</span>
                </label>
            </li>`).join('');

        selecionar(escolha);

        lista.querySelectorAll('input[name="parcelaEscolhida"]').forEach((radio) => {
            radio.addEventListener('change', () => selecionar(parseInt(radio.value, 10)));
        });
    }

    function atualizarBandeira(nova) {
        bandeira = nova;

        aplicarMascaraDoNumero();
        aplicarMascaraDoCvv();

        if (!bandeiraIcone) return;

        if (!nova || !nova.identificada) {
            bandeiraIcone.className = 'mp-bandeira';
            bandeiraIcone.title = '';
            return;
        }

        bandeiraIcone.className = 'mp-bandeira is-identificada mp-bandeira-' + nova.codigo;
        bandeiraIcone.title = nova.nome;
    }

    function temFaixas() {
        return Boolean(cotacao && (cotacao.opcoes || []).length);
    }

    function opcaoSelecionada() {
        if (!cotacao) return null;

        const parcelas = parseInt(escolhida.value, 10);

        return (cotacao.opcoes || []).find((opcao) => opcao.parcelas === parcelas) || null;
    }

    function selecionar(parcelas) {
        escolhida.value = parcelas;

        lista.querySelectorAll('.mp-parcela').forEach((item) => {
            item.classList.toggle('is-selected', parseInt(item.dataset.parcelas, 10) === parcelas);
        });

        atualizarResumo();
    }

    function atualizarResumo() {
        const opcao = opcaoSelecionada();
        const linhaAcrescimo = document.querySelector('[data-surcharge-row]');
        const linhaTotal = document.querySelector('[data-installment-total-row]');

        if (!linhaAcrescimo || !linhaTotal) return;

        if (!opcao || opcao.sem_juros || !cartaoEstaSelecionado()) {
            linhaAcrescimo.style.display = 'none';
            linhaTotal.style.display = 'none';
            return;
        }

        linhaAcrescimo.style.display = '';
        linhaAcrescimo.querySelector('[data-surcharge-price]').textContent = opcao.label_acrescimo;

        linhaTotal.style.display = '';
        linhaTotal.querySelector('[data-installment-total]').textContent = opcao.label_total;
    }

    // O resumo é global: sem isto o Pix e o depósito herdam o acréscimo cotado no cartão
    function cartaoEstaSelecionado() {
        const bloco = form.closest('[data-inputs]');
        const escolhido = document.querySelector('input[name="payment"]:checked');

        // Sem os dois marcadores não dá pra saber; assume que sim e mantém o comportamento
        if (!bloco || !escolhido) return true;

        return escolhido.value === bloco.dataset.inputs;
    }

    function esconderLinhasDoResumo() {
        const linhaAcrescimo = document.querySelector('[data-surcharge-row]');
        const linhaTotal = document.querySelector('[data-installment-total-row]');

        if (linhaAcrescimo) linhaAcrescimo.style.display = 'none';
        if (linhaTotal) linhaTotal.style.display = 'none';
    }

    function esconderParcelamento(esconder) {
        grupo.style.display = esconder ? 'none' : 'block';
    }

    const botaoPagar = document.getElementById('buttonPagamentoRede');

    function processando(ativo) {
        overlay.style.display = ativo ? 'block' : 'none';
        overlay.setAttribute('aria-busy', ativo ? 'true' : 'false');

        if (!botaoPagar) return;

        botaoPagar.disabled = ativo;
        botaoPagar.setAttribute('aria-disabled', ativo ? 'true' : 'false');
    }

    function pagar(event) {
        event.preventDefault();
        limparErro();

        if (!validar()) return;

        // O overlay é só visual: sem desabilitar, o botão segue acionável por teclado
        processando(true);

        const corpo = {
            card_number: apenasDigitos(cardNumber.value),
            card_holder_name: cardName.value
                .normalize('NFD')
                .replace(/[^A-Za-z ]/g, '')
                .trim()
                .toUpperCase()
                .substring(0, 30),
            expiration_month: partesDaValidade(expiry.value).mes,
            expiration_year: partesDaValidade(expiry.value).ano,
            cvv: cvv.value,
            payment_type: modalidade(),
            usar_saldo_conta_corrente: usarSaldo() ? 1 : 0,
        };

        if (cotacao && cotacao.cart_fingerprint) {
            corpo.cart_fingerprint = cotacao.cart_fingerprint;
        }

        if (modalidade() === 'credit') {
            corpo.installments = parseInt(escolhida.value, 10) || 1;
        }

        jQuery.ajax({
            method: 'POST',
            url: wp.ajax_url,
            data: { action: 'mp_erede_pagar_cartao', data: corpo },
        }).done((dados) => {
            if (dados && dados.success) {
                window.location.reload();
                return;
            }

            processando(false);
            mostrarErro((dados && dados.message) || 'Não foi possível realizar o pagamento.');

            const status = dados && dados.http_status;

            if (status === 409 || status === 422) cotar(true);
        }).fail(() => {
            processando(false);
            mostrarErro('Não foi possível realizar o pagamento. Tente novamente mais tarde ou contate o suporte.');
        });
    }

    function iniciarCaptcha() {
        const pergunta = document.getElementById('captchaQuestionRede');
        const campo = document.getElementById('captcha-e-rede');
        const bloco = document.getElementById('captchaFormRede');
        const botao = document.querySelector('[data-captcha-validar]');

        if (!pergunta || !campo || !bloco || !botao) return;

        let resposta = 0;

        function sortear() {
            const a = Math.floor(Math.random() * 10) + 1;
            const b = Math.floor(Math.random() * 10) + 1;

            resposta = a + b;
            campo.value = '';
            pergunta.innerText = `Quanto é ${a} + ${b}? (Responda a pergunta para prosseguir com o pagamento)`;
        }

        const aviso = document.querySelector('[data-captcha-msg]');

        botao.addEventListener('click', () => {
            if (parseInt(campo.value, 10) === resposta) {
                form.style.display = 'block';
                bloco.style.display = 'none';
                campo.setAttribute('aria-invalid', 'false');
                if (aviso) aviso.textContent = '';

                // O elemento focado acabou de ser escondido e o foco cairia no body
                cardNumber.focus();
                return;
            }

            form.style.display = 'none';
            sortear();

            campo.setAttribute('aria-invalid', 'true');
            if (aviso) aviso.textContent = 'Resposta incorreta. Tente novamente.';

            campo.focus();
        });

        sortear();
    }

    iniciarMascaras();
    prepararAcessibilidadeDosCampos();
    iniciarCaptcha();

    // O listener passaria o Event como primeiro argumento, ligando o forçar sem querer
    cardNumber.addEventListener('input', () => cotar());

    expiry.addEventListener('input', () => {
        const partes = partesDaValidade(expiry.value);

        mes.value = partes.mes;
        ano.value = partes.ano;
    });

    Object.keys(CAMPOS).forEach((nome) => {
        CAMPOS[nome].addEventListener('blur', () => validarCampo(nome));
        CAMPOS[nome].addEventListener('input', () => {
            const grupoCampo = grupoDoCampo(CAMPOS[nome]);
            if (grupoCampo && grupoCampo.classList.contains('is-invalid')) validarCampo(nome);
        });
    });

    formatoPagamento.addEventListener('change', () => {
        esconderParcelamento(modalidade() === 'debit');
        cotar();
    });

    // O billing reinicializa este componente; sem o off, cada inicialização acumula uma cotação
    jQuery(document)
        .off('mp:cart-total-changed.eredeCard')
        .on('mp:cart-total-changed.eredeCard', () => cotar(true));

    jQuery(document)
        .off('change.eredeCard', 'input[name="payment"]')
        .on('change.eredeCard', 'input[name="payment"]', () => {
            if (cartaoEstaSelecionado()) {
                atualizarResumo();
                return;
            }

            esconderLinhasDoResumo();
        });

    document.getElementById('buttonPagamentoRede').addEventListener('click', pagar);

    esconderParcelamento(modalidade() === 'debit');
    cotar();
}
