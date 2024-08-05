export default {
	minimum: {
		'expects': ['minimum'],
		'message': 'A {title} precisa ser maior que {minimum}.',
		'validate': function (value, pars) {
			return value >= pars.minimum;
		}
	},
	integer: {
		'expects': [],
		'message': 'O {title} precisa ser inteiro',
		'validate': function (value, pars) {
			return Number.isInteger(parseFloat(value));
		}
	},
	'valid-date': {
		expects: [
			'start',
			'end',
			'format',
		],
		message: '{title} precisa ser entre {start} and end with {end}.',
		validate: function (value, pars) {
			if ( typeof pars.format == 'function' ) {
				value = pars.format(value);
			}
			value =  new Date(value)
			if ( value == 'Invalid Date' ) {
				return false
			}
			else {
				let start = pars.start;
				let end = pars.end;

				if ( !start && !end ) {
					return true;
				}

				if ( typeof pars.format == 'function' ) {
					start = pars.format(start);
					end = pars.format(end);
				}
				start = new Date(start);
				end = new Date(end);
				if ( start > end ) {
					let aux = start;
					start = end;
					end = aux;
				}
				if ( value == 'Invalid Date' || value == 'Invalid Date' ) {
					return false;
				}
				return start <= value && value <= end;
			}
		}
	},
	'cpf':{
        expects:[],
        validate: function(){
            var cpfComPontos = document.querySelector('[name="cpf"]').value;
            var cpf = cpfComPontos.replace(/\.|\-/gi, "");
            var tamanho, numeros, digitos, soma, i, resultado, digitos_iguais;
            digitos_iguais = 1;
            for (i = 0; i < cpf.length - 1; i++){
                if(cpf.charAt(i) != cpf.charAt(i + 1)){
                    digitos_iguais = 0;
                    break;
                }
            }
            if (!digitos_iguais){
                numeros = cpf.substring(0,9);
                digitos = cpf.substring(9);
                soma = 0;
                for (i = 10; i > 1; i--){
                      soma += numeros.charAt(10 - i) * i;
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(0)){
                      return false;
                }
                numeros = cpf.substring(0,10);
                soma = 0;
                for (i = 11; i > 1; i--){
                      soma += numeros.charAt(11 - i) * i;
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(1)){
                	return false;
                }

                
                return true;
            }
            else{ 
                return false;
            }
        },
        message:'CPF Inválido'
    },
	'cnpj':{
        expects:[],
        validate: function(){
            var cnpjComPontos = document.querySelector('[name="cnpj"]').value;
		    var cnpj = cnpjComPontos.replace(/[^\d]+/g,'');
		    var numeros, digitos, soma, i, resultado, pos, tamanho;
		 
		    if(cnpj == '') return false;
		     
		    if (cnpj.length != 14)
		        return false;
		 
		    // Elimina CNPJs invalidos conhecidos
		    if (cnpj == "00000000000000" || 
		        cnpj == "11111111111111" || 
		        cnpj == "22222222222222" || 
		        cnpj == "33333333333333" || 
		        cnpj == "44444444444444" || 
		        cnpj == "55555555555555" || 
		        cnpj == "66666666666666" || 
		        cnpj == "77777777777777" || 
		        cnpj == "88888888888888" || 
		        cnpj == "99999999999999")
		        return false;
		         
		    tamanho = cnpj.length - 2
		    numeros = cnpj.substring(0,tamanho);
		    digitos = cnpj.substring(tamanho);
		    soma = 0;
		    pos = tamanho - 7;
		    for (i = tamanho; i >= 1; i--) {
		      soma += numeros.charAt(tamanho - i) * pos--;
		      if (pos < 2)
		            pos = 9;
		    }
		    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		    if (resultado != digitos.charAt(0))
		        return false;
		         
		    tamanho = tamanho + 1;
		    numeros = cnpj.substring(0,tamanho);
		    soma = 0;
		    pos = tamanho - 7;
		    for (i = tamanho; i >= 1; i--) {
		      soma += numeros.charAt(tamanho - i) * pos--;
		      if (pos < 2)
		            pos = 9;
		    }
		    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		    if (resultado != digitos.charAt(1))
		          return false;
		           
		    return true;
        },
        message:'CNPJ Inválido'
    }
}
