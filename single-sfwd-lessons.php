<?php
get_header();

$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
$is_drip = has_term( 'no-nav', 'ld_lesson_category' );
$primary_class = ( ! $is_drip ) ? 'col-md-8' : '';

?>

<div id="page-wrapper">
	<div class="ld-featured-image center container">
		<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
	</div>

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<div class="<?php echo esc_attr( $primary_class ); ?> content-area" id="primary">

			<main class="site-main" id="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'loop-templates/content', 'lesson' ); ?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

		</div><!-- #primary -->

		<?php 
			if ( ! $is_drip ) {
				get_sidebar( 'learndash-widgets' ); 
			}
		?>


	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
