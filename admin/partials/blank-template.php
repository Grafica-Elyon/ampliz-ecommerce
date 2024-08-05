<?php

/**
 * Template limpo
 *
 * Disponibiliza um template limpo para o Visual Composer. Sem container,
 * Sem marcações, apenas o essencial para que o template seja confeccionado pelo
 * usuário no Visual Builder.
 *
 * Template Name: Página em branco
 *
 * @link       http://studiovisual.com.br
 * @since      1.0.0
 *
 * @package    MisterPrint
 * @subpackage MisterPrint/admin/partials
 */
?>

<?php get_header() ?>

<?php if ( have_posts() ) : while( have_posts()) : the_post() ?>
	<?php the_content() ?>
	<?php endwhile ?>
<?php endif ?>

<?php get_footer() ?>
