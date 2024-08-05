<?php use MisterPrint\Support\View; ?>

<div class="mp-pagination mp-text-center">
	<ul class="mp-pagination-list">
		<?php for($i = 1; $i <= $this->data['pagination']['total']; $i++) { ?>
			<?php if ( $this->data['with-helpers'] && $i == $this->data['pagination']['total'] ): ?>
				<li class="helper last-helper">
					<a href="javascript:void(0)">...</a>
				</li>
			<?php endif; ?>
			<?php $active = ($i == $this->data['pagination']['current']) ? 'active' : '' ?>
			<li class="<?php echo $active ?>">
				<a href="javascript:void('page<?php echo $i ?>')" data-page="<?php echo $i ?>"><?php echo $i ?></a>
			</li>
			<?php if ( $this->data['with-helpers'] && $i == 1 ): ?>
				<li class="helper first-helper">
					<a href="javascript:void(0)">...</a>
				</li>
			<?php endif; ?>
		<?php } ?>
	</ul>
</div>
