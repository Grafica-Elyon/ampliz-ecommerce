<?php
use MisterPrint\Support\View;
$data = $this->data['params'];
$params = "?idFranquia=2&pedido={$this->data['pedido']}";

$loja = config("plugin", "franquia");
if($loja != 1){
    ?><div class="mp-send-art">
        <center><h3>Pedido <?= $this->data['pedido'] ?></h3></center><hr />
        <?php
    foreach($this->data['produtos'] as $prod){
        if($prod['need_upload'] == 0){continue;} 
        $get = $params."&produto={$prod['orders_products_id']}";
        ?>
    <center><h4><?= $prod['orders_products_id'] ?> - <?= $prod['products_name'] ?></h4></center>
    <iframe width="350px" class="myIframe" border="0" src="<?php echo $this->data['iframe_url'].$get ?>"></iframe>

<?php } ?>
</div>
<?php
}else{ ?>

    <input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />
<div class="mp-send-art">
    <?php if($this->data['iframe_url'] !== null){ ?>
    <iframe width="100%" id="myIframe" height="800px" border="0" src="<?php echo $this->data['iframe_url'].$loja ?>"></iframe>
    <?php }else{ ?>
    <span class="mp-error">Pedido não foi encontrado no seu histórico de compras</span>
</div>
<?php }
} ?>

<style type="text/css">
span.mp-errors{
    display: block;
    font-weight: bold;
    color: var(--primary_color);
    position: relative;
    margin:0 auto;
    width:fit-content;
    
}
span.mp-errors:before {
    content: "+";
    color: red;
    font-size: 3rem;
    transform: rotate(45deg);
    position: absolute;
    left: -3rem;
    top:-50%;
}
.myIframe {
    border: 2px dashed #777;
    padding: 20px;
    display: flex;
    height: 320px;
    flex-flow: row wrap;
    justify-content: center;
    margin: 20px auto;
    width: 100%;
    max-width: 800px;
    min-width: unset;
}
h3, h4{
    color: var(--primary-color);
    font-weight: bold;
}
</style>