import Components from '../Components';
import Form from '../Form';

export default function (el) {
    console.log("[DEBUG] Iniciando script de login...");

    var rules = [
        {
            'name': 'email-login',
            'rules': {
                stop: true,
                required: {
                    message: 'E-mail é obrigatório!',
                }
            }
        },
        {
            'name': 'password-login',
            'rules': {
                stop: true,
                required: {
                    message: 'A senha é obrigatória!',
                }
            }
        },
    ];

    // Opções de Impressão
    var getInputs = () => {
        console.log("[DEBUG] Capturando valores dos campos...");
        var values = {};
        $('input', el).each((index, element) => {
            values[$(element).attr('name')] = $(element).val();
            console.log(`[DEBUG] Campo: ${$(element).attr('name')}, Valor: ${$(element).val()}`);
        });
        return values;
    };

    var registerEvents = () => {
        console.log("[DEBUG] Registrando eventos no formulário...");

        new Form(el, rules, (form) => {
            console.log("[DEBUG] Validação do formulário concluída com sucesso.");
            Components.loading(el);

            let inputs = getInputs();
            console.log("[DEBUG] Dados enviados ao servidor:", inputs);

            $.ajax({
                method: "POST",
                url: wp.ajax_url,
                data: {
                    action: inputs.action || 'mp_login',
                    'data': inputs,
                    'params': $(' [name="params"]', el).val()
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
    };

    console.log("[DEBUG] Inicializando eventos...");
    registerEvents();
}
