<?php
$data = $this->data['params'];
?>
<ul class="menu">
	<li><a href="<?= get_page_url('my_orders') ?>" class="<?= $this->data['active'] === 'orders' ? 'mp-primary-color' : ''?>"><?= $data['menu_meus_pedidos']?></a></li>
	<li><a href="<?= get_page_url('my_favorites') ?>" class="<?= $this->data['active'] === 'favorites' ? 'mp-primary-color' : ''?>"><?= $data['menu_meus_favoritos']?></a></li>
	<li><a href="<?= get_page_url('my_data') ?>" class="<?= $this->data['active'] === 'data' ? 'mp-primary-color' : ''?>"><?= $data['menu_meus_dados']?></a></li>
	<li><a href="<?= get_page_url('my_addresses') ?>" class="<?= $this->data['active'] === 'addresses' ? 'mp-primary-color' : ''?>"><?= $data['menu_meus_enderecos']?></a></li>
	<li><a href="<?= get_page_url('my_credit_extract') ?>" class="<?= $this->data['active'] === 'credit_extract' ? 'mp-primary-color' : ''?>"><?= $data['menu_conta_corrente']?></a></li>
	<li><a href="<?= home_url('/sair') ?>"><?= $data['menu_sair']?></a></li>
</ul>
