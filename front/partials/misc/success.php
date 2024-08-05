	<?php if(!empty($this->data['errors'])) { ?>
	<div class="mp-progress">
		<ul class="mp-progress-inner">
			<?php foreach($this->data['errors'] as $error) { ?>
			<li class="active" style="float: unset; margin: auto"><?php echo $error ?></li>
		</ul>
		<?php } ?>
	</div>
	<?php } ?>
