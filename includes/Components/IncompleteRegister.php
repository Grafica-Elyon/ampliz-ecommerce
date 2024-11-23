<?php

namespace MisterPrint\Components;

use MisterPrint\Factory\Vc;
use MisterPrint\Support\SessionSupport;
use MisterPrint\Support\View;
use MisterPrint\BO\Cliente;

class IncompleteRegister extends Component
{
    protected $name = 'Registro incompleto';
    protected $description = 'Mister Print incomplete register';
    protected $base = 'vc_mp_incomplete_register';

    function render()
    {
        $this->logMessage('Renderizando a página inicial...');
        $data = [];
        if (isset($_POST['data']['redirect'])) {
            $data['redirect'] = $_POST['data']['redirect'];
        }

        return (new View('user/incomplete-register', [
            'params' => $this->getParamsAjax(),
        ]))->get();
    }

    public function html($atts)
    {
        $this->logMessage('Gerando HTML do componente...');
        $redirect = (isset($_GET['redirectTo'])) ? $_GET['redirectTo'] : '/';
        $hidden = "<input type='hidden' name='params' value='" . base64_encode(json_encode($atts)) . "'>";
        return '<div data-component="' . $this->base . '" data-redirect="' . $redirect . '" class="mp-component">' . $this->component() . $hidden . '<div class="loader"></div></div>';
    }

    public static function action()
    {
        return function () {
            $self = new self();
            $self->logMessage('Iniciando ação do formulário...');

            // Validação do nonce
            if (
                !isset($_POST['data']['mp_incomplete_register']) ||
                !wp_verify_nonce($_POST['data']['mp_incomplete_register'], 'mp_incomplete_register_action')
            ) {
                $self->logMessage('Nonce inválido. Redirecionando para /cadastro_concluido/');
                wp_redirect(home_url('/cadastro_concluido/'));
                exit;
            }

            $self->logMessage('Nonce validado com sucesso.');

            // Captura os dados enviados
            $data = $_POST['data'];
            $self->logMessage('Dados recebidos do formulário: ' . json_encode($data));

            // Validação do e-mail
            if (empty($data['email-incomplete-register']) || !filter_var($data['email-incomplete-register'], FILTER_VALIDATE_EMAIL)) {
                $self->logMessage('Erro: E-mail inválido ou ausente.');
                return (new View('user/incomplete-register', [
                    'params' => $self->getParamsAjax(),
                    'errors' => ['E-mail inválido ou ausente!'],
                ]))->get();
            }

            $self->logMessage('E-mail validado: ' . $data['email-incomplete-register']);

            // Verificação de e-mail duplicado
            $boCliente = new Cliente();
            $verificacaoDeEmail = $boCliente->verifica_email_existente($data['email-incomplete-register']);
            if ($verificacaoDeEmail) {
                $self->logMessage('Erro: E-mail já cadastrado.');
                return (new View('user/incomplete-register', [
                    'params' => $self->getParamsAjax(),
                    'errors' => ['E-mail já cadastrado!'],
                ]))->get();
            }

            $self->logMessage('E-mail disponível para cadastro.');

            // Validação do celular
            if (empty($data['celular-incomplete-register']) || strlen($data['celular-incomplete-register']) < 15) {
                $self->logMessage('Erro: Celular inválido ou incompleto.');
                return (new View('user/incomplete-register', [
                    'params' => $self->getParamsAjax(),
                    'errors' => ['Celular inválido ou incompleto!'],
                ]))->get();
            }

            $self->logMessage('Celular validado: ' . $data['celular-incomplete-register']);

            // Fluxo de sucesso
            unset($data['params']);
            (new SessionSupport())->set('incomplete-register', $data);
            $self->logMessage('Dados salvos na sessão: ' . json_encode($data));

            $redirect = home_url('/cadastro_concluido/');
            $self->logMessage('Redirecionando para: ' . $redirect);
            wp_redirect($redirect);
            exit;
        };
    }

    public function setParams()
    {
        $this->logMessage('Definindo parâmetros do componente...');
        parent::setParams();
        $this->addParams([
            Vc::paramText('Titulo incomplete register', 'Novo Cliente - Cadastre-se'),
            Vc::paramText('Label celular incomplete register', 'Celular (DDD)'),
            Vc::paramText('Placeholder celular incomplete register', 'Digite o seu celular'),
            Vc::paramText('Label email incomplete register', 'E-mail'),
            Vc::paramText('Placeholder email incomplete register', 'Digite seu e-mail'),
            Vc::paramText('Button incomplete register', 'Cadastrar'),
        ]);
    }

    private function logMessage($message)
    {
        $logFile = __DIR__ . '/incomplete_register.log';
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($logFile, "[$timestamp] $message" . PHP_EOL, FILE_APPEND);
    }
}
