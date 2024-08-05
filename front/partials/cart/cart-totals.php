<?php
/**
 * Shortcode attributes
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
ob_start(); ?>
	<h2>Carrinho</h2>
	<div class="mp-cart-totals">
		<table>
			<thead>
				<tr>
					<th>Item</th>
					<th>Valor</th>
				</tr>
			</thead>
			<tbody>
				<tr class="cart-totals-view">
					<td>{{label}}</td>
					<td>{{value}}</td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
$output = ob_get_contents();
ob_end_clean();

echo $output;
