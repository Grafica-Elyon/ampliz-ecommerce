<?php

namespace MisterPrint\Components;

use MisterPrint\BO\User;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use MisterPrint\Support\SessionSupport;

class Login extends Component
{
    protected $name = 'Login';
    protected $description = 'Mister Print Login';
    protected $base = 'vc_mp_login';

    function render()
    {
        $data = [];
        if (isset($_POST['data']['redirect'])) {
            $data['redirect'] = $_POST['data']['redirect'];
        }
        $data['params'] = $this->getParamsAjax();

        $data['funcionario-session'] = true;
        $data['is_balcony'] = (new User)->get_is_balcony();

        error_log("[DEBUG] Renderizando a view de login com os dados: " . json_encode($data));
        return (new View('user/login', $data))->get();
    }

    // Element HTML
    public function html($atts)
    {
        $redirect = (isset($_GET['redirectTo'])) ? $_GET['redirectTo'] : '/';
        $hidden = "<input type='hidden' name='params' value='" . base64_encode(json_encode($atts)) . "'>";

        if (isset($_POST['action']) && $_POST['action'] === 'mp_login') {
            $_POST['data'] = $_POST;
            $_POST['params'] = isset($_POST['params']) ? $_POST['params'] : base64_encode(json_encode($atts));
            
            $login = self::action()();
            if (is_string($login)) {
                return '<div data-component="' . $this->base . '" data-redirect="' . $redirect . '" class="mp-component">' . $login . $this->component() . $hidden . '</div><div class="loader"></div>';
            } else {
                wp_redirect($login['redirect']);
            }
        }
        
        if (isset($_POST['mp_system_login'])) {
            error_log("[DEBUG] Tentativa de login recebida.");

            $login = self::action()();
            if (is_string($login)) {
                error_log("[DEBUG] Retornando a view de login com mensagem: " . $login);
                return '<div data-component="' . $this->base . '" data-redirect="' . $redirect . '" class="mp-component">' . $login . $this->component() . $hidden . '</div><div class="loader"></div>';
            } else {
                error_log("[DEBUG] Redirecionando após login bem-sucedido.");
                wp_redirect($login['redirect']);
            }
        }
        
        error_log("[DEBUG] Renderizando o formulário de login.");
        return '<div data-component="' . $this->base . '" data-redirect="' . $redirect . '" class="mp-component">' . $this->component() . $hidden . '</div><div class="loader"></div>';
    }

    static public function action()
    {
        // TODO Protect this from brute force.
        return function () {
            error_log("[DEBUG] Iniciando a ação de login.");

            if (
                (!isset($_POST['data']['mp_login']) || !wp_verify_nonce($_POST['data']['mp_login'], 'mp_login_action'))
                &&
                !(isset($_POST['mp_system_login']) && $_POST['mp_system_login'] === "")
            ) {
                error_log("[ERROR] Verificação de nonce falhou.");
                print 'Sorry, your nonce did not verify.';
                exit;
            }

            $data = $_POST['data'];
            $params = json_decode(base64_decode($_POST['params']), true);
            
            $data['email'] = $data['email-login'];
            $data['password'] = $data['password-login'];

            error_log("[DEBUG] Tentando fazer login com e-mail: " . $data['email']);
            $response = (new User)->login($data['email'], $data['password']);

            error_log("[DEBUG] Resposta do login: " . json_encode($response));

            $redirect = isset($data['redirect']) ? $data['redirect'] : get_page_url('cart');

            if (@$response['id']) {
                error_log("[DEBUG] Login bem-sucedido para o usuário ID: " . $response['id']);
                if (user()->login_user($response['id'], $data['email'])) {
                    if (user()->isRecadastro()) {
                        // Pega a pagina de recadastro
                        $newRedirect = get_page_url('my_data');

                        // Caso não tenha pagina de recadastro, apenas continua
                        if (!$newRedirect) {
                            return ['redirect' => $redirect];
                        }

                        if ($redirect) {
                            $newRedirect .= '?' . http_build_query(['redirect' => $redirect]);
                        }

                        return ['redirect' => $newRedirect];
                    }
                    return ['redirect' => $redirect];
                }
            }

            if (@$response['message'] == 'Acesso negado') {
                error_log("[ERROR] Acesso negado para o usuário: " . $data['email']);
                $pagina = get_page_url('recovery_blocked_login');
                if ($pagina) {
                    return ['redirect' => $pagina];
                }
                $response['message'] = 'Por favor, entrar em contato com o comercial';
            }

            error_log("[ERROR] Login falhou: " . @$response['message'] ?: 'E-mail ou senha inválido!');
            return (new View('user/login', [
                'redirect' => $redirect,
                'params' => $params,
                'errors' => [@$response['message'] ?: 'E-mail ou senha inválido!']
            ]))->get();
        };
    }

    static public function actionFuncionario()
    {
        // TODO Protect this from brute force.
        return function () {
            error_log("[DEBUG] Iniciando a ação de login para funcionário.");

            if (
                (!isset($_POST['data']['mp_login']) || !wp_verify_nonce($_POST['data']['mp_login'], 'mp_login_action'))
                &&
                !(isset($_POST['mp_system_login']) && $_POST['mp_system_login'] === "")
            ) {
                error_log("[ERROR] Verificação de nonce falhou para funcionário.");
                print 'Sorry, your nonce did not verify.';
                exit;
            }

            $data = $_POST['data'];
            $params = json_decode(base64_decode($_POST['params']), true);

            $loginNaSessao = SessionSupport::get('login-funcionario', false);
            if ($data['from-session'] == 'true' && $loginNaSessao) {
                $data['func_email'] = $loginNaSessao['email'];
                $data['func_senha'] = $loginNaSessao['senha'];
            }

            error_log("[DEBUG] Tentando fazer login como funcionário com e-mail: " . $data['func_email']);
            $response = (new User)->funcionaryLogin($data['func_email'], $data['func_senha'], $data['email']);

            error_log("[DEBUG] Resposta do login de funcionário: " . json_encode($response));

            $redirect = isset($data['redirect']) ? $data['redirect'] : get_page_url('cart');

            if (@$response['id']) {
                error_log("[DEBUG] Login de funcionário bem-sucedido para o usuário ID: " . $response['id']);
                if (!$loginNaSessao) {
                    SessionSupport::set('login-funcionario', ['email' => $data['func_email'], 'senha' => $data['func_senha']]);
                }

                if (user()->login_user($response['id'], $response['email'])) {
                    if (user()->isRecadastro()) {
                        // Pega a pagina de recadastro
                        $newRedirect = get_page_url('my_data');

                        // Caso não tenha pagina de recadastro, apenas continua
                        if (!$newRedirect) {
                            return ['redirect' => $redirect];
                        }

                        if ($redirect) {
                            $newRedirect .= '?' . http_build_query(['redirect' => $redirect]);
                        }

                        return ['redirect' => $newRedirect];
                    }
                    return ['redirect' => $redirect];
                }
            }

            if (@$response['message'] == 'Acesso negado') {
                error_log("[ERROR] Acesso negado para funcionário: " . $data['func_email']);
                $pagina = get_page_url('recovery_blocked_login');
                if ($pagina) {
                    return ['redirect' => $pagina];
                }
                $response['message'] = 'Por favor, entrar em contato com o comercial';
            }

            error_log("[ERROR] Login de funcionário falhou: " . @$response['message'] ?: 'E-mail ou senha inválido!');
            return (new View('user/login', [
                'redirect' => $redirect,
                'params' => $params,
                'is_balcony' => (new User)->get_is_balcony(),
                'funcionario-session' => $loginNaSessao,
                'errors' => [@$response['message'] ?: 'E-mail ou senha inválido!']
            ]))->get();
        };
    }

    public function setParams()
    {
        parent::setParams();
        $this->addParams([
            Vc::paramText('Titulo login', 'Login - Cliente já cadastrado'),
            Vc::paramText('Label email login', 'E-mail'),
            Vc::paramText('Placeholder email login', 'Digite seu e-mail'),
            Vc::paramText('Label senha login', 'Senha'),
            Vc::paramText('Placeholder senha login', 'Digite sua senha'),
            Vc::paramText('Esqueceu a senha login', 'Esqueceu a senha?'),
            Vc::paramText('Button login', 'Entrar'),
            // Será removido
            Vc::paramText('Funcionario Label email', 'E-mail do Funcionário'),
            Vc::paramText('Funcionario Placeholder email', 'Digite seu e-mail'),
            Vc::paramText('Funcionario Label senha', 'Senha do Funcionário'),
            Vc::paramText('Funcionario Placeholder senha', 'Digite sua senha'),
            Vc::paramText('Funcionario Login Cliente', 'E-mail ou id do cliente'),
        ]);
    }
}
