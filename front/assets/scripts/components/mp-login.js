import Components from '../Components';
import Form from '../Form';

export default function (el) {
    const rules = [
        {
            name: 'email',
            rules: {
                stop: true,
                required: {
                    message: 'E-mail é obrigatório!',
                },
                email: {
                    message: 'E-mail inválido!',
                }
            }
        },
        {
            name: 'password',
            rules: {
                stop: true,
                required: {
                    message: 'A senha é obrigatória!',
                }
            }
        }
    ];

    // Verifica se as regras estão configuradas corretamente
    const validateRules = (rules) => {
        if (!Array.isArray(rules) || rules.length === 0) {
            console.error('Nenhuma regra definida para validação.');
            return false;
        }
        for (let rule of rules) {
            if (!rule.name || !rule.rules) {
                console.error('Regra mal configurada:', rule);
                return false;
            }
        }
        return true;
    };

    // Captura os valores dos inputs
    const getInputs = () => {
        const values = {};
        $('input', el).each((index, element) => {
            values[$(element).attr('name')] = $(element).val();
        });
        return values;
    };

    // Registra eventos no formulário
    const registerEvents = () => {
        if (!validateRules(rules)) {
            console.error('Falha na validação das regras.');
            return;
        }

        new Form(el, rules, (form) => {
            Components.loading(el);
            const inputs = getInputs();

            $.ajax({
                method: 'POST',
                url: wp.ajax_url,
                data: {
                    action: inputs.action || 'mp_login',
                    data: inputs,
                    params: $('input[name="params"]', el).val()
                }
            })
                .done((response) => {
                    if (response.status === 'error') {
                        console.error('Erros do servidor:', response.errors);
                        for (let field in response.errors) {
                            const input = $(`[name="${field}"]`, el);
                            input.addClass('error');
                            input.after(`<span class="error-message">${response.errors[field]}</span>`);
                        }
                    } else if (response.status === 'success') {
                        window.location = response.redirect;
                    }
                })
                .always(() => Components.loading(el, 'stop'));
        });
    };

    // Aguarda o carregamento do DOM para registrar os eventos
    document.addEventListener('DOMContentLoaded', () => {
        registerEvents();
    });
}
