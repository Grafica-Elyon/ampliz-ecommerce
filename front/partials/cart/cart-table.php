<?php
use MisterPrint\Support\View;
echo (new View('misc/errors', [
	'errors' => (isset($this->data['errors'])) ? $this->data['errors'] : []
]))->get();
?>

<div class="mp-cart-table mp-hide-small mp-hide-medium">
	<span id="clear" style="cursor: pointer;display: block;float: right;margin: 0px 5% 10px 0;">Esvaziar o Carrinho</span>
	<table cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th style="text-align: center;" width="20%">Produto</th>
				<th>Descrição</th>
				<th>Detalhes</th>
				<th>Valor</th>
				<th>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php if($this->data['cart']) {?>
				<?php foreach($this->data['cart'] as $item) { ?>
					<tr>
						<td class="mp_table_img_col">
							<a href="<?php echo get_product_url($item['product_id'], $item['name']); ?>">
								<img class="img-flex img-produto" src="<?= $item['imagem'] ?>" alt="imagem do produto">
								<br />
								<?php echo $item['name'] ?>
							</a>
						</td>
						<td>
							<?php if(!$item['hide_info']){ ?>
							<strong>Formato: </strong><?php echo $item['format'] ?> cm<br />
							<strong>Cor: </strong><?php echo $item['color'] ?><br />
							<strong>Substrato: </strong><?php echo $item['substrate'] ?><br />
							<strong>Cobertura: </strong><?php echo $item['cover'] ?><br />
							<?= (new View('cart/util/listar-acabamentos', $item['finishings']))->get() ?>
							<?php }else{?> 
								<strong>Sem informações adicionais</strong>
							<?php } ?>
						</td>
						<td >
							<?php if($item['quant'] > 1) { ?>
								<strong>Quantidade: </strong><?php echo $item['quant'] ?> Unidades<br />
							<?php } else { ?>
								<strong>Quantidade: </strong><?php echo $item['quant'] ?> Unidade<br />
							<?php } ?>

							<?php if($item['prazo'] > 1) { ?>
								<strong>Produção: </strong><?php echo $item['prazo'] ?> Dias úteis<br />
							<?php } else { ?>
								<strong>Produção: </strong><?php echo $item['prazo'] ?> Dia útil<br />
							<?php } ?>

							<strong>Peso: </strong><?php echo $item['weight'] ?> kg<br />
							<?php if(!$item['without_art']){ ?>
							<strong>Arte: </strong><?php echo $item['art'] ?>
							<?php } ?>
						</td>
						<td class="coluna-precos">
						<?php $descontos = $item['discount'];
							if($descontos['porcentagem'] > 0 || $descontos['fixo'] > 0 || $item['valorEnvioArte'] > 0){
								if($descontos['fixo'] > 0 || $item['discount']['porcentagem'] > 0){
									$item['preco_previo'] = $descontos['fixo'] > 0 
										? $item['preco_total'] + $descontos['fixo'] 
										: $item['preco_total'] / (1- ($descontos['porcentagem'] / 100));//Xi = t / (1- (d / 100))
								}
								echo "<span ><strong>Produto:</strong>R$".number_format($item['preco_previo'],2,",","")."</span>";
								if($item['valorEnvioArte'] > 0){
									echo '<span><strong>Arte:</strong>+R$'.$item['valorEnvioArte'].'</span>';
								}
								if($descontos['fixo'] > 0 || $item['discount']['porcentagem'] > 0){
									$descontoTotal = $item['preco_previo'] - $item['preco_total'];
									$descontoTotal = number_format($descontoTotal, 2, ',', '');
									echo "<span><strong>Desconto:</strong>-R$".$descontoTotal."</span>";
								}
								echo '<span class="mp-primary-color"><strong>Total:</strong><strong>R$'.$item['preco_total'].'</strong></span>';
							}else{
								echo '<span class="single"><strong>R$'.$item['preco_total'].'</strong></span>';
							}
							?>
						</td>
						<td>
							<a href="#" data-action="copy" data-cart="<?php echo $item['id'] ?>">
								<strong><i class="mp-icon mp-icon-copy"></i> Duplicar</strong>
							</a>
							<input class="mp-input" type="number" id="qtd-<?php echo $item['id'] ?>" min="1" pattern="[0-9]" placeholder="Quantidade">
							<br /><br />
							<a href="#" data-action="delete" data-cart="<?php echo $item['id'] ?>">
								<strong><i class="mp-icon mp-icon-trash"></i> Remover</strong>
							</a>
						</td>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="5" align="center">
						<strong><?= $this->data['params']['sem_itens']?></strong>
					</td>
				</tr>
			<?php }?>
		</tbody>
	</table>
</div>

<div class="mp-cart-table  mp-show-small mp-hide-large">
	<?php if($this->data['cart']) {?>
		<?php foreach($this->data['cart'] as $item) { ?>
			<h4 class="mp-painel-title">Produto</h4>
			<a href="<?php echo get_product_url($item['product_id'], $item['name']); ?>"><?php echo $item['name'] ?></a>
			<hr />

			<h4 class="mp-painel-title">Descrição</h4>
			<?php if(!$item['hide_info']){ ?>
			<strong>Formato: </strong><?php echo $item['format'] ?> cm<br />
			<strong>Cor: </strong><?php echo $item['color'] ?><br />
			<strong>Substrato: </strong><?php echo $item['substrate'] ?><br />
			<strong>Cobertura: </strong><?php echo $item['cover'] ?><br />
			<?= (new View('cart/util/listar-acabamentos', $item['finishings']))->get() ?>
			<?php }else{?> 
				<strong>Sem informações adicionais</strong>
			<?php } ?>
			<hr />

			<h4 class="mp-painel-title">Detalhes</h4>
			<?php if($item['quant'] > 1) { ?>
				<strong>Quantidade: </strong><?php echo $item['quant'] ?> Unidades<br />
			<?php } else { ?>
				<strong>Quantidade: </strong><?php echo $item['quant'] ?> Unidade<br />
			<?php } ?>

			<?php if($item['prazo'] > 1) { ?>
				<strong>Produção: </strong><?php echo $item['prazo'] ?> Dias úteis<br />
			<?php } else { ?>
				<strong>Produção: </strong><?php echo $item['prazo'] ?> Dia útil<br />
			<?php } ?>

			<strong>Peso: </strong><?php echo $item['weight'] ?> kg<br />

			<?php if(!$item['without_art']){ ?>
			<strong>Arte: </strong><?php echo $item['art'] ?>
			<?php } ?>
			<hr class="bold" />

			<div class="mp-row">
				<div class="mp-col-5">
					<h4 class="mp-painel-title">Valor</h4>
					R$ <?php echo $item['price'] ?>
				</div>
				<div class="mp-col-5">
					<div class="mp-text-right">
						<a href="#" data-action="copy" data-cart="<?php echo $item['id'] ?>">
							<strong><i class="mp-icon mp-icon-copy"></i> Duplicar</strong>
						</a>
						<input  type="text" id="qtd" >
						<br /><br />
						<a href="#" data-action="delete" data-cart="<?php echo $item['id'] ?>">
							<strong><i class="mp-icon mp-icon-trash"></i> Remover</strong>
						</a>

					</div>
				</div>
			</div>
			<hr class="bold" /><br />
		<?php } ?>
	<?php } else { ?>
		<tr>
			<td colspan="5" align="center">
				<strong><?= $this->data['params']['sem_itens']?></strong>
			</td>
		</tr>
	<?php }?>
</div>
<script type="text/javascript">
	document.getElementById('clear').addEventListener("click", function(){
		var base_url = window.location.hostname == "localhost" 
			? "https://ampliz.com.br" 
			: "https://"+window.location.hostname;

		jQuery('.loader').css('display', "block");
		if (window.sendinblue && window.sendinblue.track !== undefined){
			sendinblue.track('cart_deleted');
		}
		var url = base_url+'/wp-admin/admin-ajax.php?action=mp_clear_cart';		
		fetch(url).then(function(response) {
			jQuery('.loader').css('display', "none");
			if(response){
				window.location.reload();
			}else{
				alert("Erro ao limpar carrinho");
			}
		});
	});
</script>
<?php 
	$carrinho = array_map(
		function ($item) {
			return [
				'name' => "{$item['name']} {$item['substrate']} {$item['color']}",
				'format' => $item['format'],
				'id' => $item['product_id'],
				'price' => $item['value'],
				'quantity' => $item['quant'],
				'image' => $item['imagem'],
				'arttype' => $item['art'],
				'finishing' => str_replace( "<strong>Acabamentos: </strong> ", "", (new View('cart/util/listar-acabamentos', $item['finishings']))->get()),
			];
		},
		$this->data['cart']
	);
	@session_start();
	if(isset($_SESSION['update']) && $_SESSION['update'] == 1){ 
		$cliente = user()->getData();
		?>
		<script type="text/javascript">
		    if(window.sendinblue.track !== undefined){
		    	window.sendinblue.track(
		    	    'cart_updated',
		    	    {
        		        "NOME": "<?= $cliente['dadosCliente']['customers_firstname']; ?>",
        		        "APELIDO": "<?= $cliente['dadosCliente']['customers_lastname']; ?>",
        		        "ID": "<?= user()->getId() ?>"
        		    },
        		    {
        		        "id": "cart:<?= user()->getId() ?>",
        		        "data":
        		        {
        		            "products": <?= json_encode($carrinho) ?>
        		        }
        		    }
		    	  );

		    	console.info('sendinblue track enviado');
		    }else{
		    	console.info('sendinblue track NÃO enviado');
		    }
		    
		</script><?php 
		$_SESSION['update'] = 0; 
	} 
 ?>
<style type="text/css">
	.mp_table_img_col a{
		display: block;
		text-align: center;
	}
	.img-produto{
		height:130px;
		width: auto;
		margin-bottom:10px;
		white-space: normal;
		border-radius: 4px;
	}
	.mp-input {
	    margin-top:5px;
	    opacity:0;
	    line-height: 1px;
	    max-height:1px;
	    font-size:1px;
	    transition: all 0.3s !important;
	    border-radius: 30px !important;
    	max-width: 130px !important;
	}

	td:hover > .mp-input {
	    opacity:1;
	    line-height: 35px;
	    max-height:30px;
	    font-size:14px;
	}
</style>