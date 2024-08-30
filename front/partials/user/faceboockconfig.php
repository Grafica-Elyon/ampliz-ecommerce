<?php
session_start();
require_once('/home/dev_ecommerce_ampliz/vendor/autoload.php'); // Caminho absoluto para o autoload do Composer

$FBObject = new \Facebook\Facebook([
    'app_id' => config('env', 'APP_FACEBOOK_ID'), 
    'app_secret' => config('env', 'APP_FACEBOOK_SECRET'),
    'default_graph_version' => config('env', 'APP_FACEBOOK_VERSION')
]);

$handler = $FBObject->getRedirectLoginHelper();

try {
    // Tenta obter o token de acesso
    $accessToken = $handler->getAccessToken();
    if (isset($accessToken)) {
        $_SESSION['fb_access_token'] = (string) $accessToken;
        
        // Log para verificar se o token de acesso foi obtido
        error_log('Access Token: ' . $accessToken);
        
        // Define o token de acesso na SDK
        $oAuth2Client = $FBObject->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        $tokenMetadata->validateAppId(config('env', 'APP_FACEBOOK_ID')); // ID do aplicativo
        $tokenMetadata->validateExpiration();
        
        if (!$accessToken->isLongLived()) {
            // Troca o token de curto prazo por um token de longo prazo
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                $_SESSION['fb_access_token'] = (string) $accessToken;
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                error_log('Erro ao obter token de longo prazo: ' . $e->getMessage());
            }
        }
        
        // Busca os dados do usuário
        try {
            $response = $FBObject->get('/me?fields=id,name,email', $accessToken);
            $user = $response->getGraphUser();
            
            $_SESSION['user_name'] = $user['name']; // Armazena o nome do usuário na sessão
            
            // Log para verificar os dados do usuário
            error_log('Nome do usuário: ' . $user['name']);
            error_log('ID do usuário: ' . $user['id']);
            error_log('Email do usuário: ' . $user['email']);
            
            // Redireciona o usuário para a página desejada após o login
            header("Location: https://ampliz.com.br");
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // Quando o Graph retorna um erro
            error_log('Graph returned an error: ' . $e->getMessage());
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // Quando a SDK retorna um erro
            error_log('Facebook SDK returned an error: ' . $e->getMessage());
        }
    } elseif ($handler->getError()) {
        // Log de erro se houver problema ao obter o token de acesso
        error_log('Facebook SDK returned an error: ' . $handler->getError());
        error_log('Error code: ' . $handler->getErrorCode());
        error_log('Error reason: ' . $handler->getErrorReason());
        error_log('Error description: ' . $handler->getErrorDescription());
    }
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
    // Quando o Graph retorna um erro
    error_log('Graph returned an error: ' . $e->getMessage());
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
    // Quando a SDK retorna um erro
    error_log('Facebook SDK returned an error: ' . $e->getMessage());
}
?>
