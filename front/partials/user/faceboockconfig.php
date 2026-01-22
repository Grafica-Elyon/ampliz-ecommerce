<?php
session_start();
require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

$storeUrl = rtrim(config('plugin', 'url_loja', home_url('/')), '/');
$storeUrl = $storeUrl ? $storeUrl : home_url('/');

// Função para registrar log
function registrarLog($mensagem) {
    $logFile = __DIR__ . '/log_api_facebook.log';
    $logMessage = "[" . date('Y-m-d H:i:s') . "] " . $mensagem . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Exemplo de log para quando o script inicia
registrarLog("Início do processo de autenticação com Facebook.");

$FBObject = new \Facebook\Facebook([
    'app_id' => config('env', 'APP_FACEBOOK_ID'), 
    'app_secret' => config('env', 'APP_FACEBOOK_SECRET'),
    'default_graph_version' => config('env', 'APP_FACEBOOK_VERSION')
]);

$handler = $FBObject->getRedirectLoginHelper();

// Inserindo o state manualmente
$handler->getPersistentDataHandler()->set('state', $_GET['state']);
registrarLog("State inserido manualmente.");

try {
    // Tenta obter o token de acesso
    $accessToken = $handler->getAccessToken();
    if (isset($accessToken)) {
        $_SESSION['fb_access_token'] = (string) $accessToken;
        
        registrarLog("Token de acesso obtido com sucesso: " . $accessToken);

        // Define o token de acesso na SDK
        $oAuth2Client = $FBObject->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        $tokenMetadata->validateAppId(config('env', 'APP_FACEBOOK_ID')); // ID do aplicativo
        $tokenMetadata->validateExpiration();
        
        registrarLog("Validação do token de acesso realizada com sucesso.");

        if (!$accessToken->isLongLived()) {
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                $_SESSION['fb_access_token'] = (string) $accessToken;
                registrarLog("Token de acesso estendido para longo prazo.");
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                registrarLog("Erro ao obter token de longo prazo: " . $e->getMessage());
            }
        }

        // Busca os dados do usuário
        try {
            $response = $FBObject->get('/me?fields=id,name,email', $accessToken);
            $user = $response->getGraphUser();
            
            $_SESSION['user_name'] = $user['name']; // Armazena o nome do usuário na sessão
            
            registrarLog("Dados do usuário obtidos: Nome = " . $user['name'] . ", ID = " . $user['id'] . ", Email = " . $user['email']);
            
            // Redireciona o usuário para a página desejada após o login
        registrarLog("Redirecionando usuário para {$storeUrl}");
        header("Location: {$storeUrl}");
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            registrarLog("Erro do Graph: " . $e->getMessage());
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            registrarLog("Erro da SDK do Facebook: " . $e->getMessage());
        }
    } elseif ($handler->getError()) {
        registrarLog("Erro ao obter o token de acesso: " . $handler->getError());
    }
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
    registrarLog("Erro do Graph ao tentar obter o token: " . $e->getMessage());
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
    registrarLog("Erro da SDK ao tentar obter o token: " . $e->getMessage());
}
?>
