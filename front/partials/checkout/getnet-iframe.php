<?php
  use MisterPrint\BO\Pagamento;
  use MisterPrint\Helper\Log;
  //PARTE 1: TOKEN DE ACESSO

  $dados = (new Pagamento)->get_iframe_info();
  $dados = json_decode($dados, true);

  $sellerId = config('env', 'GETNET_SELLER_ID', '');
  $clientId = config('env', 'GETNET_CLIENT_ID', '');
  $clientSecret = config('env', 'GETNET_CLIENT_SECRET', '');
  $url = config('env', 'GETNET_TOKEN_URL');
  $checkoutScript = config('env', 'GETNET_CHECKOUT_SCRIPT');

  $token = base64_encode("{$clientId}:{$clientSecret}");
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, "scope=oob&grant_type=client_credentials");
  curl_setopt($curl, CURLOPT_HTTPHEADER, [
    "Content-Type: application/x-www-form-urlencoded",
    "Authorization: Basic {$token}"
  ]);
  $result_token = json_decode(curl_exec($curl), true);
  $result_token = $result_token['access_token'];

  //PARTE 2: DADOS DO CLIENTE
  $franquia = config("plugin", "franquia");
  $site = $_SERVER['HTTP_HOST']; $filial = "";
  if($site != "localhost"){
    $filial = explode(".",$site)[0];
    $filial = $filial == "ampliz" ? "PRO" : ucwords($filial);
  }
  $usuario = user()->getData();
  $usuario = json_decode(json_encode($usuario), true);
  $sobrenome = explode(" ",$usuario['dadosCliente']['customers_firstname'],2);
  $sobrenome = isset($sobrenome[1]) ? $sobrenome[1] : $usuario['dadosCliente']['customers_lastname'];
  $orderid = user()->getId().":{$usuario['dadosCliente']['qtde_pedidos']}:{$filial}:{$franquia}";
  $complemento = $usuario['dadosEndereco']['complemento'] == null ? "" : $usuario['dadosEndereco']['complemento'];
  $id = user()->getId();
  $data = "
  ---------------------------------------
  sellerid= {$sellerId}  
  loja= {$filial}  
  token= Bearer {$result_token}  
  amount= 1000000.00 
  customerid= {$id} 
  orderid= {$orderid} 
  button-class= pay-button-getnet 
  installments= 1 
  customer-first-name= {$usuario['dadosCliente']['customers_firstname']} 
  customer-last-name= {$sobrenome} 
  customer-document-type= CPF 
  customer-document-number= {$usuario['dadosCliente']['customers_cpf']} 
  customer-email= {$usuario['dadosCliente']['customers_email_address']} 
  customer-phone-number= {$usuario['dadosCliente']['customers_telephone']} 
  customer-address-street= {$usuario['dadosEndereco']['entry_street_address']} 
  customer-address-street-number= {$usuario['dadosEndereco']['entry_street_number']} 
  customer-address-complementary= {$complemento} 
  customer-address-neighborhood= {$usuario['dadosEndereco']['entry_suburb']} 
  customer-address-city= {$usuario['dadosEndereco']['entry_city']} 
  customer-address-state= {$usuario['dadosEndereco']['entry_state']} 
  customer-address-zipcode= {$usuario['dadosEndereco']['entry_postcode']}
  ---------------------------------------";
  //Log::info($data);
  
?>

<span id="teste" class="mp-btn-primary pay-button-getnet">Efetuar pagamento</span>

<script id="iframe-script" async src="<?= esc_url($checkoutScript) ?>"
data-getnet-sellerid="<?= $sellerId  ?>" 
data-getnet-token="Bearer <?= $result_token ?>" 
  data-getnet-amount="1000000.00"
  data-getnet-customerid="<?= user()->getId() ?>"
  data-getnet-orderid="<?= $orderid ?>"
  data-getnet-button-class="pay-button-getnet"
  data-getnet-installments="1"
  data-getnet-customer-first-name="<?= $usuario['dadosCliente']['customers_firstname'] ?>"
  data-getnet-customer-last-name="<?= $sobrenome ?>"
  data-getnet-customer-document-type="CPF"
  data-getnet-customer-document-number="<?= $usuario['dadosCliente']['customers_cpf'] ?>"
  data-getnet-customer-email="<?= $usuario['dadosCliente']['customers_email_address'] ?>"
  data-getnet-customer-phone-number="<?= $usuario['dadosCliente']['customers_telephone'] ?>"
  data-getnet-customer-address-street="<?= $usuario['dadosEndereco']['entry_street_address'] ?>"
  data-getnet-customer-address-street-number="<?= $usuario['dadosEndereco']['entry_street_number'] ?>"
  data-getnet-customer-address-complementary="<?= $complemento ?>"
  data-getnet-customer-address-neighborhood="<?= $usuario['dadosEndereco']['entry_suburb'] ?>"
  data-getnet-customer-address-city="<?= $usuario['dadosEndereco']['entry_city'] ?>"
  data-getnet-customer-address-state="<?= $usuario['dadosEndereco']['entry_state'] ?>"
  data-getnet-customer-address-zipcode="<?= $usuario['dadosEndereco']['entry_postcode'] ?>"
  data-getnet-customer-country="Brasil"
  data-getnet-shipping-address=''
  data-getnet-payment-methods-disabled='["boleto"]'
  data-getnet-pre-authorization-credit=""
  data-getnet-url-callback="">
</script>
<script >
  document.addEventListener('click',function(e){
    if(e.target && e.target.id== 'teste'){   
      let getnetIfrm = document.querySelector('#getnet-checkout');
      var total = parseFloat(jQuery("[data-total-price]").attr('data-total-price'));
      getnetIfrm.setAttribute('data-getnet-amount', total);
          getnetIfrm.addEventListener('load', ev => { 
           // Funções compatíveis com IE e outros navegadores
           var eventMethod = (window.addEventListener ? 'addEventListener' : 'attachEvent');
           var eventer = window[eventMethod];
           var messageEvent = (eventMethod === 'attachEvent') ? 'onmessage' : 'message';
           // Ouvindo o evento do loader
          eventer(messageEvent, function iframeMessage(e) {
            var data = e.data || '';
            switch (data.status || data) {
              case 'success':
                // jQuery('.mp-btn-primary[type="submit"]').click()
                console.log('pago!');
                window.location.reload();
                break;
              case 'error':
                // jQuery('.mp-btn-primary[type="submit"]').click()
                console.error('erro!', e);
                window.location.reload();
                break;
              case 'close':
                window.location.reload();
                console.log('janela fechada!');
                break; 
              case 'pending': 
                window.location.reload();
                console.log('Boleto registrado e pendente de pagamento'); 
                console.log(e); 
                break;
              default:
                console.warn(e); 
                break;
            }
            
          }, false);
      }); 
    }
 });
</script>
<div class="mp-errors-container"></div>
<?php 