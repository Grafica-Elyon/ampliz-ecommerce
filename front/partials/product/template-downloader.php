<?php
use MisterPrint\Support\View;
$data = $this->data;
$has_arte = $data['has_arte'];
$gabaritos = $data['gabaritos'];

?>
<?php if($gabaritos[0] != 0 || $gabaritos[1] != 0 ){ ?>
	<div class="<?= $data['class'] ?>" style="display:<?php echo $has_arte==1 ? 'block' : 'none'; ?>">
		<h4> <?= $data['text'] ?> </h4>
	<?php if($gabaritos[0] != 0 ){ ?>
		<button  type="button" id="horizontal" onclick="baixar('h')" class="mp-btn-darker-transparent">
			<i class="mp-icon mp-icon-download"></i> Horizontal
		</button>
	<?php } ?>
	<?php if($gabaritos[1] != 0 ){ ?>
		<button  type="button" id="vertical" onclick="baixar('v')" class="mp-btn-darker-transparent">
			<i class="mp-icon mp-icon-download"></i> Vertical
		</button>
	<?php } ?>
	</div>
<?php } ?>
<script type="text/javascript">
	function baixar(hv){
		var id = jQuery('.quantidade:checked').val();
		var x = jQuery('.finishing-options .mp-checkbox input:checked');
		resposta = x[0] ? x[0].value : "nenhum";
		window.open("<?= config('plugin', 'api') ?>gabarito/"+id+"/"+hv+"/"+resposta, '_blank');
	}
</script>
