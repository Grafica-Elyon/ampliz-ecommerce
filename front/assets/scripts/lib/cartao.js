const MASCARA_AMEX = '0000 000000 00000';
const MASCARA_PADRAO = '0000 0000 0000 0000 000';

const PADROES = {
    amex: { mascara: MASCARA_AMEX, digitos: [15], cvv: 4 },
    visa: { mascara: MASCARA_PADRAO, digitos: [13, 16, 18, 19], cvv: 3 },
    mastercard: { mascara: MASCARA_PADRAO, digitos: [16], cvv: 3 },
    elo: { mascara: MASCARA_PADRAO, digitos: [16], cvv: 3 },
    diners: { mascara: MASCARA_PADRAO, digitos: [14, 16, 19], cvv: 3 },
    hipercard: { mascara: MASCARA_PADRAO, digitos: [14, 15, 16, 19], cvv: 3 },
    hiper: { mascara: MASCARA_PADRAO, digitos: [16], cvv: 3 },
    jcb: { mascara: MASCARA_PADRAO, digitos: [16, 17, 18, 19], cvv: 3 },

    // Bandeira não reconhecida: mesma faixa que a API aceita
    padrao: { mascara: MASCARA_PADRAO, digitos: [13, 14, 15, 16, 17, 18, 19], cvv: 3 },
};

export function regrasDaBandeira(codigo) {
    return PADROES[codigo] || PADROES.padrao;
}

export function apenasDigitos(valor) {
    return (valor || '').replace(/\D/g, '');
}

export function luhnValido(numero) {
    const digitos = apenasDigitos(numero);

    if (digitos.length < 12) return false;

    let soma = 0;
    let dobra = false;

    for (let i = digitos.length - 1; i >= 0; i--) {
        let d = parseInt(digitos[i], 10);

        if (dobra) {
            d *= 2;
            if (d > 9) d -= 9;
        }

        soma += d;
        dobra = !dobra;
    }

    return soma % 10 === 0;
}

export function capacidadeDaMascara(mascara) {
    return (mascara.match(/0/g) || []).length;
}

export function comprimentoValido(numero, codigoBandeira) {
    return regrasDaBandeira(codigoBandeira).digitos.includes(apenasDigitos(numero).length);
}

export function validadeValida(texto, agora) {
    const digitos = apenasDigitos(texto);

    if (digitos.length !== 4) return false;

    const mes = parseInt(digitos.substring(0, 2), 10);

    if (mes < 1 || mes > 12) return false;

    const referencia = agora || new Date();
    const ano = 2000 + parseInt(digitos.substring(2), 10);

    // O cartão vale até o último instante do mês impresso
    return new Date(ano, mes, 0, 23, 59, 59) >= referencia;
}

// O formulário manda mês e ano separados, mas a tela tem um campo só
export function partesDaValidade(texto) {
    const digitos = apenasDigitos(texto);

    return {
        mes: digitos.substring(0, 2),
        ano: digitos.length === 4 ? String(2000 + parseInt(digitos.substring(2), 10)) : '',
    };
}
