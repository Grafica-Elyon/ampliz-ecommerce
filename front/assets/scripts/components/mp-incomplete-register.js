import Components from '../Components';
import Form from '../Form';

export default function (el) {
    console.log("[DEBUG] Iniciando script de registro incompleto...");

    // Adicionando validação personalizada para minLength
    const validateMinLength = (value, length) => {
        return value.length >= length;
    };

    var rules = [
        {
            'name': 'email-incomplete-register',
            'rules': {
                stop: false,
                required: {
                    message: 'E-mail é obrigatório!',
                },
                email: {
                    message: 'E-mail inválido!',
                }
            }
        },
        {
            'name': 'celular-incomplete-register',
            'rules': {
                stop: true,
                required: {
                    message: 'O celular é obrigatório!',
                },
                custom: {
                    validate: (value) => validateMinLength(value, 15),
                    message: 'O celular deve conter pelo menos 15 caracteres!',
                }
            }
        },
    ];

    var getInputs = () => {
        console.log("[DEBUG] Capturando valores dos campos...");
        var values = {};
        $('input, select', el).each((index, element) => {
            values[$(element).attr('name')] = $(element).val();
            console.log(`[DEBUG] Campo: ${$(element).attr('name')}, Valor: ${$(element).val()}`);
        });
        return values;
    };

    var registerEvents = () => {
        console.log("[DEBUG] Registrando eventos no formulário...");
        $('input[name="celular-incomplete-register"]').mask('(00) 00000-0000');

        if (!$(el).data('initialized')) {
            console.log("[DEBUG] Registrando validações no formulário...");
            $(el).data('initialized', true);

            new Form(el, rules, (form) => {
                console.log("[DEBUG] Validação do formulário concluída com sucesso.");
                Components.loading(el);

                var inputs = getInputs();
                console.log("[DEBUG] Dados enviados ao servidor:", inputs);

                $.ajax({
                    method: "POST",
                    url: wp.ajax_url,
                    data: {
                        action: 'mp_incomplete_register',
                        'data': inputs,
                        'params': inputs.params,
                    }
                }).done((response) => {
                    console.log("[DEBUG] Resposta recebida do servidor:", response);

                    if (typeof response.redirect !== 'undefined') {
                        console.log("[DEBUG] Redirecionando para:", response.redirect);
                        window.location = response.redirect;
                        return;
                    }

                    $(el).html(response);
                    registerEvents();

                    Components.loading(el, 'stop');
                }).fail((jqXHR, textStatus, errorThrown) => {
                    console.error("[DEBUG] Erro na requisição AJAX:", textStatus, errorThrown);
                    Components.loading(el, 'stop');
                });
            });
        } else {
            console.log("[DEBUG] Eventos já registrados, evitando duplicação.");
        }
    };

    console.log("[DEBUG] Inicializando eventos...");
    registerEvents();
}
