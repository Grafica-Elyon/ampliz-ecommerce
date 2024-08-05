<?php use MisterPrint\Support\View; ?>
<div class="mp-config-print-options-inner">
	<div class="format">
		<?php echo (new View('category/configuration/format',
			$this->data['formats'] + [
				'titulo' => $this->data['vc_data']['painel_2_formato'],
				'painel_2_sem_dados' => $this->data['vc_data']['painel_2_sem_dados'],
			]))->get() ?><hr />
	</div>
	<div class="color">
		<?php echo (new View('category/configuration/color',
			$this->data['colors'] + [
				'titulo' => $this->data['vc_data']['painel_2_cores'],
				'painel_2_sem_dados' => $this->data['vc_data']['painel_2_sem_dados'],
			]))->get() ?><hr />
	</div>
	<div class="paper">
		<?php echo (new View('category/configuration/paper',
			$this->data['papers'] + [
				'titulo' => $this->data['vc_data']['painel_2_papel'],
				'painel_2_sem_dados' => $this->data['vc_data']['painel_2_sem_dados'],
			]))->get() ?><hr />
	</div>
	<div class="ennoblement">
		<?php echo (new View('category/configuration/ennoblement',
			$this->data['ennoblements'] + [
				'titulo' => $this->data['vc_data']['painel_2_enobrecimento'],
				'painel_2_sem_dados' => $this->data['vc_data']['painel_2_sem_dados'],
			]))->get() ?><hr />
	</div>
	<div class="finishing">
		<?php echo (new View('category/configuration/finishing',
			$this->data['finishings'] + [
				'titulo' => $this->data['vc_data']['painel_2_acabamentos'],
				'painel_2_sem_dados' => $this->data['vc_data']['painel_2_sem_dados'],
			]))->get() ?>
	</div>
</div>
