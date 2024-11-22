import Components from '../Components';
import Form from '../Form';

export default function (el) {
    var rules = [
        {
            name: 'email',
            rules: {
                required: {
                    message: 'E-mail é obrigatório!',
                },
                email: {
                    message: 'E-mail inválido!',
                },
            },
        },
        {
            name: 'confirm-email',
            rules: {
                required: {
                    message: 'Confirmação de e-mail é obrigatória!',
                },
                equal: {
                    field: 'email',
                    message: 'A confirmação deve ser igual ao e-mail!',
                },
            },
        },
        {
            name: 'nome-completo',
            rules: {
                required: {
                    message: 'O nome completo é obrigatório!',
                },
            },
        },
    ];

    // Captura os inputs do formulário
    const getInputs = () => {
        const values = {};
        $('input, select', el).each((_, element) => {
            values[$(element).attr('name')] = $(element).val();
        });
        return values;
    };

    // Função para registrar eventos
    const registerEvents = () => {
        new Form(el, rules, (form) => {
            Components.loading(el);

            const inputs = getInputs();
            $.ajax({
                method: 'POST',
                url: wp.ajax_url,
                data: {
                    action: 'mp_incomplete_register',
                    data: inputs,
                    params: inputs.params,
                },
            })
                .done((response) => {
                    if (typeof response.redirect !== 'undefined') {
                        window.location = response.redirect;
                        return;
                    }

                    $(el).html(response);
                    registerEvents();

                    Components.loading(el, 'stop');
                })
                .fail((error) => {
                    console.error('Erro na submissão do formulário:', error);
                    Components.loading(el, 'stop');
                });
        });
    };

    registerEvents();
}
