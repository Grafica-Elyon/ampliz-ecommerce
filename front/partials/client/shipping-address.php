<?php
ob_start();
/**
 * Shortcode attributes
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */

$atts = shortcode_atts(
	[
		'shipping_address_class'                => '',
		'shipping_address_title'                => 'Endereço de Entrega do Cliente',
		'shipping_address_title_add'            => 'Adicionar um Endereço',
		'shipping_address_title_add_sucess'     => 'Endereço adicionado com sucesso!',
		'shipping_address_title_add_err'        => 'Erro ao adicionar o endereço.',
		'shipping_address_title_edit'           => 'Editar o Endereço',
		'shipping_address_title_edit_sucess'    => 'Endereço editado com sucesso!',
		'shipping_address_title_edit_err'       => 'Erro ao editar o endereço.',
		'shipping_address_title_del'            => 'Remover o Endereço',
		'shipping_address_title_del_sucess'     => 'Endereço removido com sucesso!',
		'shipping_address_title_del_err'        => 'Erro ao remover o endereço.',
		'shipping_address_desc_del'             => 'Deseja realmente remover o endereço de entrega?',
	],
	$atts
);
?>
	<div class="mp-shipping-address wp-core-ui <?= $atts['shipping_address_class'] ?>">

		<h1><?= $atts['shipping_address_title'] ?></h1>

		<table>
			<thead>
				<tr>
					<th width="25%">Nome</th>
					<th width="27%">Endereço</th>
					<th width="15%">Telefone</th>
					<th width="9%">Ação</th>
					<th width="9%">Ação</th>
					<th width="15%">Local de Entrega</th>
				</tr>
			</thead>
			<tbody>
				<tr class="shipping-address-view">
					<td width="25%">
						{{client}}
					</td>
					<td width="27%">
						<span class="rua">{{endereco}}</span>, <span class="numero">{{numero}}</span><br/>
						<span class="cep">{{cep}}</span> - <span class="bairro">{{bairro}}</span> - <span class="cidade">{{cidade}}</span><br/>
						<span class="estado">{{estado}}</span> - <span class="pais">{{pais}}</span>
					</td>
					<td width="15%">
						<span class="telefone">{{telefone}}</span>
					</td>
					<td width="9%">
						<a data-id="{{id}}" href="javascript:void(0);" class="mp-btn mp-btn-edit-address">Editar</a>
					</td>
					<td width="9%">
						<a data-id="{{id}}" href="javascript:void(0);" class="mp-btn mp-btn-red mp-btn-del-address">Excluir</a>
					</td>
					<td width="15%">
						<input type="checkbox" id="ckb_addresses[{{id}}]" name="ckb_addresses[{{id}}]" value="{{id}}"><label for="ckb_addresses[{{id}}]">Entregar Aqui</label>
					</td>
				</tr>
			</tbody>
		</table>
		<p>
			<a href="javascript:void(0);" class="mp-btn mp-btn-green mp-btn-add-address">Novo Endereço</a>
		</p>
		<hr/>
	</div>

	<div class="mp-lightbox">
		<div class="overlay"></div>
		<div class="content">
			<a href="javascript:void(0);" class="boxclose"></a>

			<div class="mp-forms">

				<h1></h1>

				<div class="mp-add-edit-form">

					<p class="p70">
						<label for="rua">Logradouro</label>
						<input type="text" name="rua">
					</p>
					<p class="p30">
						<label for="numero">Nº</label>
						<input type="text" name="numero">
					</p>
					<p class="p50">
						<label for="cep">CEP</label>
						<input type="text" name="cep">
					</p>
					<p class="p50">
						<label for="bairro">Bairro</label>
						<input type="text" name="bairro">
					</p>
					<p class="p70">
						<label for="cidade">Cidade</label>
						<input type="text" name="cidade">
					</p>
					<p class="p30">
						<label for="estado">UF</label>
						<input type="text" name="estado">
					</p>
					<p class="p50">
						<label for="pais">País</label>
						<input type="text" name="pais">
					</p>
					<p class="p50">
						<label for="telefone">Telefone</label>
						<input type="text" name="telefone">
					</p>

					<p class="action">
						<a href="javascript:void(0);" class="mp-btn mp-btn-green">Salvar Endereço</a>
					</p>

				</div>

				<div class="mp-del-form">
					<div class="mp-del-form-desc">
						<p>
							<?= $atts['shipping_address_desc_del'] ?>
						</p>
					</div>
					<div class="mp-form-acts">
						<a href="javascript:void(0);" class="mp-btn mp-btn-red mp-btn-del-no">Não</a>
						<a href="javascript:void(0);" class="mp-btn mp-btn-green mp-btn-del-yes">Sim</a>
					</div>
				</div>

				<div class="mp-sucess-form">
					<div class="mp-form-acts">
						<a href="javascript:void(0);" class="mp-btn mp-btn-sucess-ok">Fechar</a>
					</div>
				</div>

				<div class="mp-error-form">
					<div class="mp-form-acts">
						<a href="javascript:void(0);" class="mp-btn mp-btn-error-ok">Fechar</a>
					</div>
				</div>

				<input type="hidden" name="codigoEnd">

				<input type="hidden" name="shipping_address_title_add" value="<?= $atts['shipping_address_title_add'] ?>">
				<input type="hidden" name="shipping_address_title_add_sucess" value="<?= $atts['shipping_address_title_add_sucess'] ?>">
				<input type="hidden" name="shipping_address_title_add_err" value="<?= $atts['shipping_address_title_add_err'] ?>">

				<input type="hidden" name="shipping_address_title_edit" value="<?= $atts['shipping_address_title_edit'] ?>">
				<input type="hidden" name="shipping_address_title_edit_sucess" value="<?= $atts['shipping_address_title_edit_sucess'] ?>">
				<input type="hidden" name="shipping_address_title_edit_err" value="<?= $atts['shipping_address_title_edit_err'] ?>">

				<input type="hidden" name="shipping_address_title_del" value="<?= $atts['shipping_address_title_del'] ?>">
				<input type="hidden" name="shipping_address_title_del_sucess" value="<?= $atts['shipping_address_title_del_sucess'] ?>">
				<input type="hidden" name="shipping_address_title_del_err" value="<?= $atts['shipping_address_title_del_err'] ?>">

			</div>

		</div>
	</div>

<?php
$output = ob_get_contents();
ob_end_clean();

echo $output;
