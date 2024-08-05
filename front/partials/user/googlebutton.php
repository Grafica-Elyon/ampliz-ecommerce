<?php
  $data_client_id = config('env', 'APP_GOOGLE_CLIENTID'); 
  $data_login_uri = config('env', 'APP_GOOGLE_LOGINURI'); 
 
?>

<script src="https://accounts.google.com/gsi/client" async></script>
<div id="g_id_onload" data-client_id="<?php echo $data_client_id; ?>" data-login_uri="<?php echo $data_login_uri; ?>" data-auto_prompt="false">  
<!-- <div id="g_id_onload" data-client_id="153943376301-1qq5op592m8or24imeggsj60r1hi5756.apps.googleusercontent.com" data-login_uri="http://localhost/mrprint/" data-auto_prompt="false">  -->
</div>
<div class="g_id_signin" data-type="standard" data-size="large" 
     data-theme="outline" data-text="sign_in_with" data-shape="rectangular" 
     data-logo_alignment="left" 
     onclick="handleGoogleSignIn()"> 
</div>
</script>

<script>
    function handleGoogleSignIn() {
        // Chama a função signIn() do Google Sign-In
        google.accounts.id.signIn({
            callback: handleGoogleResponse, 
            client_id: '<?php echo $clientId; ?>',
            auto_select: false, 
            hosted_domain: '', 
            cancel_on_tap_outside: false, 
            state: '', 
        });
    }

    // Função para lidar com a resposta do Google Sign-In
    function handleGoogleResponse(response) {
        if (response.error) {
            // Lidar com erros, se houver
            console.error('Erro durante o login do Google:', response.error);
        } else {
            var id_token = response.credential;
        }
    }
</script>
