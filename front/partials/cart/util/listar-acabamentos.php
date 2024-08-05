<?php
$finishings = $this->data;
?>
<strong>Acabamentos: </strong>
<?php if ( !$finishings ): ?>
	Sem Acabamentos<br />
<?php elseif ( is_string($finishings) ): ?>
	<?= $finishings ?><br />
<?php else: ?>
	<?php if ( isset( $finishings['nome'] ) ): ?>
		<li><?= $finishings['nome'] ?></li>
	<?php elseif ( empty( $finishings ) ): ?>
		Sem Acabamentos<br />
	<?php elseif ( sizeof( $finishings ) == 1 ): ?>
		<?php
			$finish = $finishings[0];
			if ( is_array( $finish ) ) {
				$finish = $finish['nome'];
			}
			echo $finish;
		?>
	<?php else: ?>
		<ul>
			<?php
			foreach ($finishings as $finish) {
				if ( is_array( $finish ) ) {
					$finish = $finish['nome'];
				}
				echo "<li>$finish</li>";
			}
			?>
		</ul>
	<?php endif; ?>
<?php endif; ?>
