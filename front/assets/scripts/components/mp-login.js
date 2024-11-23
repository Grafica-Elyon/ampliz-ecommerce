import Components from '../Components';
import Form from '../Form';

export default function (el) {
    var rules = [
        {
            'name': 'email',
            'rules': {
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
            'name': 'password', 
            'rules': {
                stop: true,
                required: {
                    message: 'A senha é obrigatória!',
                }
            }
        }
    ];

    // Captura os valores dos inputs
    var getInputs = () => {
        var values = {};
        $('input', el).each((index, element) => {
            values[$(element).attr('name')] = $(element).val();
        });

        console.log("Valores capturados:", values); // Log para verificar os valores capturados
        return values;
    };

    // Registra eventos no formulário
    var registerEvents = () => {
        console.log("Registrando eventos no formulário:", el); // Verificar se o elemento correto está sendo registrado

        new Form(el, rules, (form) => {
            Components.loading(el);

            let inputs = getInputs();

            $.ajax({
                method: "POST",
                url: wp.ajax_url,
                data: {
                    action: inputs.action || 'mp_login',
                    data: inputs,
                    params: $('input[name="params"]', el).val()
                }
            }).done((response) => {
                if (typeof response.redirect !== 'undefined') {
                    window.location = response.redirect;
                    return;
                }

                $(el).html(response);
                registerEvents(); // Re-registra os eventos após substituir o conteúdo

                Components.loading(el, 'stop');
            });
        });
    };

    // Aguarda o carregamento do DOM para registrar os eventos
    document.addEventListener('DOMContentLoaded', function () {
        registerEvents();
    });
}
