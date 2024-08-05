<?php
/**
 * Shortcode attributes
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$atts = shortcode_atts([
	'shipping_class' => '',
	'shipping_label' => 'Fitros',
	'removed_shipping' => ''
], $atts);

$removed_shipping = explode(',', $atts['removed_shipping']);
ob_start(); ?>
	<div class="mp-shipping <?php echo $atts['shipping_class'] ?>">
		<h2><?php echo $atts['shipping_label'] ?></h2>
		<div class="shipping-methods">
			<?php if (!in_array('correios', $removed_shipping)) { ?>
				<a data-shipping="correios" href="#">Correios</a>
			<?php } ?>
			<?php if (!in_array('balcao', $removed_shipping)) { ?>
				<a data-shipping="balcao" href="#">Balcão</a>
			<?php } ?>
			<?php if (!in_array('transportadora', $removed_shipping)) { ?>
				<a data-shipping="transportadora" href="#">Transportadora</a>
			<?php } ?>
			<?php if (!in_array('motoboy', $removed_shipping)) { ?>
				<a data-shipping="motoboy" href="#">Motoboy</a>
			<?php } ?>
		</div>
		<div class="shipping-options">
			<table>
				<thead>
				<tr>
					<th width="50px"></th>
					<th>Metodo</th>
					<th width="100px">Prazo</th>
					<th width="100px" align="center">Valores</th>
				</tr>
				</thead>
				<tbody>
					<tr class="shipping-view">
						<td>
							<input type="radio" name="shipping_method" value="{{codigo}}">
						</td>
						<td>
							<h4>{{titulo}}</h4>
							<p>{{detalhe}}</p>
						</td>
						<td>{{prazo}}</td>
						<td>{{valor}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
<?php
$output = ob_get_contents();
ob_end_clean();

echo $output;
