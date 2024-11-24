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

	static public function action()
	{
		return function () {
			error_log("[DEBUG] Iniciando validação no backend...");
	
			// Verifica o nonce
			if (!isset($_POST['data']['mp_incomplete_register']) || !wp_verify_nonce($_POST['data']['mp_incomplete_register'], 'mp_incomplete_register_action')) {
				error_log("[DEBUG] Falha no nonce. Redirecionando para 'cadastro_concluido'...");
				wp_redirect(home_url('/cadastro_concluido/'));
				exit;
			}
	
			error_log("[DEBUG] Nonce validado. Capturando dados...");
	
			$data = $_POST['data'];
			$self = new self();
	
			error_log("[DEBUG] Dados recebidos: " . json_encode($data));
	
			$data['nome-completo'] = $data['nome-completo'];
			$data['email'] = $data['email-incomplete-register'];
	
			$boCliente = new Cliente();
	
			// Verifica se o email já existe
			$verificacaoDeEmail = $boCliente->verifica_email_existente($data['email']);
			error_log("[DEBUG] Verificação de email: " . ($verificacaoDeEmail ? 'Existe' : 'Não existe'));
	
			if ($verificacaoDeEmail) {
				error_log("[DEBUG] Email já cadastrado. Retornando erro...");
				return (new View('user/incomplete-register', [
					'params' => $self->getParamsAjax(),
					'errors' => ['Email já Cadastrado']
				]))->get();
			}
	
			// Continua o fluxo se os dados estiverem corretos
			if (!empty($data)) {
				unset($data['params']);
				(new SessionSupport())::set('incomplete-register', $data);
				error_log("[DEBUG] Dados salvos na sessão. Redirecionando para a página de registro...");
	
				$redirect = get_page_url('register');
				return ['redirect' => $redirect];
			}
	
			error_log("[DEBUG] Fluxo concluído sem erros.");
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
